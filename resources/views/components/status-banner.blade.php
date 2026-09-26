@props(['type' => 'info'])
@php
    $tone = [
        'success' => 'status-banner--success',
        'warning' => 'status-banner--warning',
        'error' => 'status-banner--error',
        'info' => 'status-banner--info',
    ][$type] ?? 'status-banner--info';
@endphp

<aside {{ $attributes->merge(['class' => 'status-banner '.$tone, 'role' => 'status']) }}>
    <span aria-hidden="true">✦</span>
    <div>{{ $slot }}</div>
</aside>
