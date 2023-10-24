@props(['status'])

@php
switch ($status) {
    case '1':
        $text = 'พระ';
        break;
    case '2':
        $text = 'กัลฯ';
        break;
    case '3':
        $text = 'กัลฯ';
        break;
    default:
        $text = 'กัลฯ';
        break;
}
@endphp

<p {{ $attributes->merge(['class' => '']) }}>
{{ $text }}{{ $slot }}
</p>