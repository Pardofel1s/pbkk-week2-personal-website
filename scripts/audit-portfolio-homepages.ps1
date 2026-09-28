param(
    [string] $DestinationsPath = (Join-Path $PSScriptRoot '..\docs\research\portfolio-destinations.csv'),
    [string] $OutputPath = (Join-Path $PSScriptRoot '..\docs\research\portfolio-homepage-audit.csv'),
    [int] $TargetSites = 2000,
    [int] $BatchSize = 100,
    [int] $ThrottleLimit = 12
)

$ErrorActionPreference = 'Stop'
$destinations = @(Import-Csv -LiteralPath $DestinationsPath | Where-Object DestinationUrl)
$uniqueTargets = [System.Collections.Generic.List[object]]::new()
$seenUrls = [System.Collections.Generic.HashSet[string]]::new([System.StringComparer]::OrdinalIgnoreCase)
foreach ($entry in $destinations) {
    try {
        $uri = [Uri] $entry.DestinationUrl
        if ($uri.Scheme -notin @('http', 'https')) { continue }
        $authority = if ($uri.IsDefaultPort) { $uri.Host.ToLowerInvariant() } else { $uri.Authority.ToLowerInvariant() }
        $canonical = $authority + $uri.AbsolutePath.TrimEnd('/')
        if ($seenUrls.Add($canonical)) {
            $uniqueTargets.Add([pscustomobject] @{ Record = $entry; Url = $uri.GetLeftPart([System.UriPartial]::Path) })
        }
    }
    catch { continue }
}

if ($uniqueTargets.Count -lt $TargetSites) {
    throw "Only $($uniqueTargets.Count) unique destination URLs are available; $TargetSites are required. Fetch additional Awwwards records before auditing."
}
$targets = @($uniqueTargets | Select-Object -First $TargetSites)
$outputDirectory = Split-Path -Parent $OutputPath
New-Item -ItemType Directory -Path $outputDirectory -Force | Out-Null
$completed = [System.Collections.Generic.HashSet[string]]::new([System.StringComparer]::OrdinalIgnoreCase)
if (Test-Path -LiteralPath $OutputPath) {
    Import-Csv -LiteralPath $OutputPath | ForEach-Object { [void] $completed.Add($_.RequestedUrl) }
}

for ($offset = 0; $offset -lt $targets.Count; $offset += $BatchSize) {
    $batch = @($targets | Select-Object -Skip $offset -First $BatchSize | Where-Object { -not $completed.Contains($_.Url) })
    if (-not $batch.Count) { continue }

    $results = @($batch | ForEach-Object -Parallel {
        $target = $_
        $record = $target.Record
        $status = ''
        $contentType = ''
        $finalUrl = ''
        $title = ''
        $description = ''
        $language = ''
        $errorMessage = ''
        $html = ''

        try {
            $response = Invoke-WebRequest -Uri $target.Url -TimeoutSec 15 -MaximumRedirection 5 -UserAgent 'Mozilla/5.0 (compatible; KamalPortfolioResearch/1.0)'
            $status = [string] $response.StatusCode
            $contentType = [string] $response.Headers['Content-Type']
            $finalUrl = [string] $response.BaseResponse.RequestMessage.RequestUri.AbsoluteUri
            $html = [string] $response.Content
            $titleMatch = [regex]::Match($html, '(?is)<title\b[^>]*>(?<value>.*?)</title>')
            if ($titleMatch.Success) { $title = [System.Net.WebUtility]::HtmlDecode(($titleMatch.Groups['value'].Value -replace '<[^>]+>', ' ' -replace '\s+', ' ').Trim()) }
            $descriptionTag = [regex]::Match($html, '(?is)<meta\b(?=[^>]*\bname\s*=\s*["'']description["''])(?<attributes>[^>]*)>')
            if ($descriptionTag.Success) {
                $content = [regex]::Match($descriptionTag.Groups['attributes'].Value, '(?is)\bcontent\s*=\s*["''](?<value>.*?)["'']')
                if ($content.Success) { $description = [System.Net.WebUtility]::HtmlDecode(($content.Groups['value'].Value -replace '\s+', ' ').Trim()) }
            }
            $languageTag = [regex]::Match($html, '(?is)<html\b[^>]*\blang\s*=\s*["''](?<value>.*?)["'']')
            if ($languageTag.Success) { $language = [System.Net.WebUtility]::HtmlDecode($languageTag.Groups['value'].Value) }
        }
        catch {
            $errorMessage = $_.Exception.Message -replace '[\r\n]+', ' '
            $errorResponse = $_.Exception.Response
            if ($null -ne $errorResponse) {
                try { $status = [string] [int] $errorResponse.StatusCode } catch { $status = '' }
                try { $contentType = [string] $errorResponse.Content.Headers.ContentType.MediaType } catch { $contentType = '' }
                try { $finalUrl = [string] $errorResponse.RequestMessage.RequestUri.AbsoluteUri } catch { $finalUrl = '' }
                try { $html = $errorResponse.Content.ReadAsStringAsync().GetAwaiter().GetResult() } catch { $html = '' }
            }
        }

        $hostName = ''
        try { $hostName = ([Uri] $(if ($finalUrl) { $finalUrl } else { $target.Url })).Host.ToLowerInvariant() }
        catch { $hostName = '' }

        [pscustomobject] @{
            RequestedUrl = $target.Url
            FinalUrl = $finalUrl
            Host = $hostName
            AwwwardsSlug = $record.Slug
            AwwwardsTitle = $record.Title
            AwwwardsTags = $record.CatalogTags
            HttpStatus = $status
            ContentType = $contentType
            PageTitle = $title.Substring(0, [Math]::Min(300, $title.Length))
            MetaDescription = $description.Substring(0, [Math]::Min(600, $description.Length))
            Language = $language
            HasViewport = [regex]::IsMatch($html, '(?is)<meta\b(?=[^>]*\bname\s*=\s*["'']viewport["''])')
            H1Count = [regex]::Matches($html, '(?is)<h1\b').Count
            NavLandmarks = [regex]::Matches($html, '(?is)<nav\b').Count
            ButtonCount = [regex]::Matches($html, '(?is)<button\b').Count
            LinkCount = [regex]::Matches($html, '(?is)<a\b').Count
            AriaAttributeCount = [regex]::Matches($html, '(?is)\baria-[a-z-]+\s*=').Count
            SkipLinkCount = [regex]::Matches($html, '(?is)<a\b[^>]*href\s*=\s*["'']#(main|content|skip)').Count
            StylesheetCount = [regex]::Matches($html, '(?is)<link\b[^>]*\brel\s*=\s*["'']stylesheet["'']').Count
            ScriptCount = [regex]::Matches($html, '(?is)<script\b').Count
            AnimationHints = [regex]::Matches($html, '(?is)\b(animation|transition|keyframes|gsap|framer-motion|view-transition)\b').Count
            FetchedAtUtc = [DateTime]::UtcNow.ToString('yyyy-MM-ddTHH:mm:ssZ')
            Error = $errorMessage
        }
    } -ThrottleLimit $ThrottleLimit)

    if ($results.Count) {
        if (Test-Path -LiteralPath $OutputPath) { $results | Export-Csv -LiteralPath $OutputPath -NoTypeInformation -Encoding utf8 -Append }
        else { $results | Export-Csv -LiteralPath $OutputPath -NoTypeInformation -Encoding utf8 }
        foreach ($result in $results) { [void] $completed.Add($result.RequestedUrl) }
    }

    Write-Host "Audited $($completed.Count) / $($targets.Count) unique destination homepages."
}

$audit = @(Import-Csv -LiteralPath $OutputPath)
$responded = @($audit | Where-Object { $_.HttpStatus -match '^2' }).Count
[pscustomobject] @{
    UniqueHomepagesAudited = $audit.Count
    SuccessfulResponses = $responded
    OutputPath = $OutputPath
} | Format-List
