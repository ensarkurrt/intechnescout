@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5  focus:outline-none focus:border-indigo-700 transition'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition';

$styles = ($active ?? false)
            ? 'color: rgb(234 88 12 / 1);'
            : 'color: rgb(255 255 255 / 1);';
@endphp

<a {{ $attributes->merge(['class' => $classes,'style'=> $styles]) }}>
    {{ $slot }}
</a>
