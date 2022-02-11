@php
    $types = [
        'pdf' => ['state' => 'danger', 'icon' => 'fa fa-file-pdf-o'],
        'word' => ['state' => 'info', 'icon' => 'fa fa-file-word-o'],
        'excel' => ['state' => 'success', 'icon' => 'fa fa-file-excel-o'],
        'file' => ['state' => 'brand', 'icon' => 'fa fa-file-o'],
    ];
@endphp

<a target="_blank" href="{{ $url }}">
    <button class="btn btn-{{ $types[$type]['state'] }} btn-sm" type="button">
        <i class="{{ $types[$type]['icon'] }}"></i> {{ $title }}
    </button>
</a>