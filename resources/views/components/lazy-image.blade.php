@props(['src', 'alt' => '', 'class' => '', 'eager' => false])

<img src="{{ $src }}" alt="{{ $alt }}" @unless($eager) loading="lazy" decoding="async" @endunless class="{{ $class }}">
