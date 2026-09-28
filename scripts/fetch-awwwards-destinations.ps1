param(
    [string] $CatalogPath = (Join-Path $PSScriptRoot '..\docs\research\portfolio-catalog.csv'),
    [string] $OutputPath = (Join-Path $PSScriptRoot '..\docs\research\portfolio-destinations.csv'),
    [int] $TargetRecords = 4526,
    [int] $BatchSize = 80,
    [int] $ThrottleLimit = 5
)

$ErrorActionPreference = 'Stop'
$records = @(Import-Csv -LiteralPath $CatalogPath | Select-Object -First $TargetRecords)
$outputDirectory = Split-Path -Parent $OutputPath
New-Item -ItemType Directory -Path $outputDirectory -Force | Out-Null
$completed = [System.Collections.Generic.HashSet[string]]::new([System.StringComparer]::OrdinalIgnoreCase)
if (Test-Path -LiteralPath $OutputPath) {
    Import-Csv -LiteralPath $OutputPath | ForEach-Object { [void] $completed.Add($_.Slug) }
}

for ($offset = 0; $offset -lt $records.Count; $offset += $BatchSize) {
    $batch = @($records | Select-Object -Skip $offset -First $BatchSize | Where-Object { -not $completed.Contains($_.Slug) })
    if (-not $batch.Count) { continue }

    $results = @($batch | ForEach-Object -Parallel {
        $record = $_
        $destination = ''
        $status = ''
        $errorMessage = ''

        try {
            $response = Invoke-WebRequest -Uri $record.AwwwardsRecord -TimeoutSec 18 -MaximumRedirection 5 -UserAgent 'Mozilla/5.0 (compatible; KamalPortfolioResearch/1.0)'
            $status = [string] $response.StatusCode
            $link = [regex]::Match($response.Content, '(?is)<a\b(?=[^>]*data-controller\s*=\s*["'']visit-count["''])(?<attributes>[^>]*)>')
            if ($link.Success) {
                $href = [regex]::Match($link.Groups['attributes'].Value, '(?is)\bhref\s*=\s*["''](?<url>.*?)["'']')
                if ($href.Success) { $destination = [System.Net.WebUtility]::HtmlDecode($href.Groups['url'].Value) }
            }
        }
        catch {
            $errorMessage = $_.Exception.Message -replace '[\r\n]+', ' '
        }

        $hostName = ''
        if ($destination) {
            try { $hostName = ([Uri] $destination).Host.ToLowerInvariant() }
            catch { $errorMessage = 'Invalid destination URL.' }
        }

        [pscustomobject] @{
            Title = $record.Title
            Slug = $record.Slug
            CatalogTags = $record.Tags
            AwwwardsRecord = $record.AwwwardsRecord
            DestinationUrl = $destination
            DestinationHost = $hostName
            ListingStatus = $status
            FetchedAtUtc = [DateTime]::UtcNow.ToString('yyyy-MM-ddTHH:mm:ssZ')
            Error = $errorMessage
        }
    } -ThrottleLimit $ThrottleLimit)

    if ($results.Count) {
        if (Test-Path -LiteralPath $OutputPath) { $results | Export-Csv -LiteralPath $OutputPath -NoTypeInformation -Encoding utf8 -Append }
        else { $results | Export-Csv -LiteralPath $OutputPath -NoTypeInformation -Encoding utf8 }
        foreach ($result in $results) { [void] $completed.Add($result.Slug) }
    }

    Write-Host "Fetched $($completed.Count) / $($records.Count) Awwwards listing pages; found $((Import-Csv -LiteralPath $OutputPath | Where-Object DestinationUrl).Count) destination URLs."
}

[pscustomobject] @{
    ListingPagesFetched = $completed.Count
    DestinationUrlsFound = (Import-Csv -LiteralPath $OutputPath | Where-Object DestinationUrl).Count
    OutputPath = $OutputPath
} | Format-List
