param(
    [string] $CatalogPath = (Join-Path $PSScriptRoot '..\docs\research\portfolio-catalog.csv'),
    [string] $OutputPath = (Join-Path $PSScriptRoot '..\docs\research\portfolio-live-review-sample.csv')
)

$ErrorActionPreference = 'Stop'
$catalog = @(Import-Csv -LiteralPath $CatalogPath)
$dimensions = @(
    [pscustomobject] @{ Tag = 'Typography'; Pattern = 'Hierarchy and readable type' },
    [pscustomobject] @{ Tag = 'Minimal'; Pattern = 'Restraint and whitespace' },
    [pscustomobject] @{ Tag = 'Animation'; Pattern = 'Purposeful motion' },
    [pscustomobject] @{ Tag = 'Responsive Design'; Pattern = 'Responsive composition' },
    [pscustomobject] @{ Tag = 'Microinteractions'; Pattern = 'Interaction feedback' },
    [pscustomobject] @{ Tag = 'Storytelling'; Pattern = 'Personal narrative' },
    [pscustomobject] @{ Tag = 'UI design'; Pattern = 'Interface clarity' },
    [pscustomobject] @{ Tag = 'Colorful'; Pattern = 'Color systems' }
)
$bands = @(
    [pscustomobject] @{ Name = 'Recent'; Minimum = 1; Maximum = 22 },
    [pscustomobject] @{ Name = 'Middle'; Minimum = 23; Maximum = 45 },
    [pscustomobject] @{ Name = 'Earlier'; Minimum = 46; Maximum = 68 }
)
$usedSlugs = [System.Collections.Generic.HashSet[string]]::new([System.StringComparer]::OrdinalIgnoreCase)
$sample = [System.Collections.Generic.List[object]]::new()

foreach ($dimension in $dimensions) {
    foreach ($band in $bands) {
        $candidates = foreach ($entry in $catalog) {
            $pageNumber = 1
            if ($entry.GalleryPage -match '[?&]page=(\d+)') { $pageNumber = [int] $Matches[1] }
            $entryTags = @($entry.Tags -split '\s*\|\s*')

            if ($entryTags -contains $dimension.Tag -and $pageNumber -ge $band.Minimum -and $pageNumber -le $band.Maximum) {
                $entry
            }
        }

        $selected = $candidates | Where-Object { -not $usedSlugs.Contains($_.Slug) } | Sort-Object Slug | Select-Object -First 1
        if ($null -eq $selected) { continue }
        [void] $usedSlugs.Add($selected.Slug)

        $sample.Add([pscustomobject] @{
            Pattern = $dimension.Pattern
            CatalogTag = $dimension.Tag
            ArchiveBand = $band.Name
            Title = $selected.Title
            Slug = $selected.Slug
            AwwwardsRecord = $selected.AwwwardsRecord
            GalleryPage = $selected.GalleryPage
        })
    }
}

$sample | Export-Csv -LiteralPath $OutputPath -NoTypeInformation -Encoding utf8
Write-Output "Selected $($sample.Count) unique sites across $($dimensions.Count) design patterns and $($bands.Count) archive bands."
Write-Output $OutputPath
