@props(['label', 'value', 'tone' => 'peach'])

<div {{ $attributes->merge(['class' => 'info-card info-card--'.$tone]) }}>
    <dt>{{ $label }}</dt>
    <dd>{{ $value }}</dd>
</div>
