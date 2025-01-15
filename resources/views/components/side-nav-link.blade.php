@props(['active'])

@php
$classes = ($active ?? false)
            ? 'bg-gray-200'
            : 'hover:bg-red-700 hover:text-white transition duration-150 ease-in-out'
@endphp
<a {{ $attributes->class(['block py-3 px-4 rounded'])->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>