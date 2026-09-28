param(
    [int] $TargetUniqueSites = 4500,
    [int] $MaxPages = 200,
    [int] $DelayMilliseconds = 750
)

$ErrorActionPreference = 'Stop'
$progressPreference = 'SilentlyContinue'
$baseUrl = 'https://www.awwwards.com/websites/portfolio/'
$headers = @{ 'User-Agent' = 'Mozilla/5.0 (compatible; PortfolioReferenceStudy/1.0)' }
$records = [System.Collections.Generic.Dictionary[string, object]]::new([System.StringComparer]::OrdinalIgnoreCase)
$fetchErrors = [System.Collections.Generic.List[string]]::new()
$successfulPages = 0

for ($pageNumber = 1; $pageNumber -le $MaxPages; $pageNumber++) {
    $pageUrl = if ($pageNumber -eq 1) { $baseUrl } else { "${baseUrl}?page=$pageNumber" }
    $html = $null

    for ($attempt = 1; $attempt -le 3; $attempt++) {
        try {
            $response = Invoke-WebRequest -Uri $pageUrl -Headers $headers -TimeoutSec 30
            if ($response.StatusCode -ne 200) {
                throw "Unexpected HTTP $($response.StatusCode)"
            }
            $html = $response.Content
            break
        }
        catch {
            if ($attempt -eq 3) {
                $fetchErrors.Add("$pageNumber`t$($_.Exception.Message)")
            }
            else {
                Start-Sleep -Seconds ([Math]::Pow(2, $attempt))
            }
        }
    }

    if ($null -ne $html) {
        $successfulPages++
        $cardMatches = [regex]::Matches(
            $html,
            '(?is)<li\b(?=[^>]*\bjs-collectable\b)(?<attributes>[^>]*)>'
        )

        foreach ($cardMatch in $cardMatches) {
            $attributes = $cardMatch.Groups['attributes'].Value
            $modelMatch = [regex]::Match(
                $attributes,
                '(?is)\bdata-collectable-model-value\s*=\s*(["''])(?<value>.*?)\1'
            )
            if (-not $modelMatch.Success) { continue }

            try {
                $json = [System.Net.WebUtility]::HtmlDecode($modelMatch.Groups['value'].Value)
                $model = $json | ConvertFrom-Json
                $slug = [string] $model.slug
                if ([string]::IsNullOrWhiteSpace($slug) -or $records.ContainsKey($slug)) { continue }

                $image = [string] $model.collectableImage
                $records[$slug] = [pscustomobject] @{
                    Title = [string] $model.title
                    Slug = $slug
                    DirectoryType = [string] $model.type
                    Tags = (@($model.tags) -join ' | ')
                    AwwwardsRecord = "https://www.awwwards.com/sites/$slug"
                    GalleryPage = $pageUrl
                    PreviewImage = if ($image) { "https://assets.awwwards.com/awards/media/cache/thumb_880_660/$image" } else { '' }
                    ListedAtUtc = if ($model.createdAt) { [DateTimeOffset]::FromUnixTimeSeconds([long] ($model.createdAt / 1)).UtcDateTime.ToString('yyyy-MM-ddTHH:mm:ssZ') } else { '' }
                }
            }
            catch {
                continue
            }
        }
    }

    Write-Progress -Activity 'Collecting portfolio references' -Status "$pageNumber / $MaxPages pages · $($records.Count) unique entries" -PercentComplete ([Math]::Min(100, [Math]::Round(100 * $records.Count / $TargetUniqueSites)))

    if ($records.Count -ge $TargetUniqueSites) { break }
    Start-Sleep -Milliseconds $DelayMilliseconds
}

Write-Progress -Activity 'Collecting portfolio references' -Completed

if ($records.Count -lt $TargetUniqueSites) {
    throw "Only $($records.Count) unique site listings were collected; the target is $TargetUniqueSites. Successful gallery pages: $successfulPages. Errors: $($fetchErrors -join ' | ')"
}

$researchDirectory = Join-Path $PSScriptRoot '..\docs\research'
New-Item -ItemType Directory -Path $researchDirectory -Force | Out-Null
$catalogPath = Join-Path $researchDirectory 'portfolio-catalog.csv'
$summaryPath = Join-Path $researchDirectory 'portfolio-catalog-summary.md'
$catalog = @($records.Values | Sort-Object Title, Slug)
$catalog | Export-Csv -LiteralPath $catalogPath -NoTypeInformation -Encoding utf8

$tagCounts = @{}
foreach ($record in $catalog) {
    foreach ($tag in ($record.Tags -split '\s*\|\s*')) {
        if ([string]::IsNullOrWhiteSpace($tag)) { continue }
        if (-not $tagCounts.ContainsKey($tag)) { $tagCounts[$tag] = 0 }
        $tagCounts[$tag]++
    }
}

$topTags = $tagCounts.GetEnumerator() | Sort-Object Value -Descending | Select-Object -First 25
$tagTable = @('| Tag katalog | Jumlah situs |', '| --- | ---: |')
$tagTable += $topTags | ForEach-Object { "| $($_.Key) | $($_.Value) |" }
$errorSection = if ($fetchErrors.Count) {
    "`nHalaman yang gagal setelah tiga percobaan: $($fetchErrors.Count). Daftar ada di log terminal; tidak dihitung sebagai situs."
} else {
    "`nTidak ada halaman galeri yang gagal diambil."
}

$summary = @"
# Portfolio reference catalog

- Date collected: $(Get-Date -AsUTC -Format 'yyyy-MM-dd HH:mm:ss UTC')
- Unique Awwwards portfolio records: **$($catalog.Count)**
- Gallery pages fetched successfully: **$successfulPages**
- Source: [Awwwards portfolio websites]($baseUrl)
- Collection rule: unique Awwwards submission slug; repeated cards are deduplicated.
- Fields: title, tags, directory record, originating gallery page, and preview image.

These are unique portfolio-site listings and metadata from Awwwards' index. The catalog does not claim that every external website URL was opened, healthy, or visually reviewed. A separate, stratified sample must be visited and inspected before applying detailed visual conclusions.

## Most common index tags

$($tagTable -join "`n")
$errorSection
"@

Set-Content -LiteralPath $summaryPath -Value $summary -Encoding utf8

[pscustomobject] @{
    UniqueSites = $catalog.Count
    SuccessfulGalleryPages = $successfulPages
    Catalog = $catalogPath
    Summary = $summaryPath
    FetchErrors = $fetchErrors.Count
} | Format-List
