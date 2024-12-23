@props(['class' => ''])

<select
    {{ $attributes->merge([
        'class' => "$class focus:ring-1 focus:ring-green-600 focus:border-green-600 rounded"
    ]) }}
>
    {{ $slot }}
</select>
