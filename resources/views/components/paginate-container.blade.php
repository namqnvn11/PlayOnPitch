@props(['class'=>''])

<div {{ $attributes->merge([
    'class'=>
    "$class flex py-3 justify-center border-t"
]) }}
>
    {{$slot}}
</div>
