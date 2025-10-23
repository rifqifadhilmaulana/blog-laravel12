@props(['username'])

@php
    $colors = ['bg-red-500','bg-blue-500','bg-green-500','bg-yellow-500','bg-purple-500','bg-pink-500','bg-indigo-500'];
    $color = $colors[ord(strtoupper($username[0])) % count($colors)];
    $initial = strtoupper(substr($username, 0, 1));
@endphp

<div class="w-8 h-8 flex items-center justify-center rounded-full text-white font-bold {{ $color }}">
    {{ $initial }}
</div>
