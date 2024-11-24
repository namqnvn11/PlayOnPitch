@props(['class'=>''])
<button
    {{ $attributes->merge(
        [
            'class' =>
                "$class items-center w-[120px] px-4 py-[10px] h-10 bg-green-800
                 border border-transparent rounded-md
                 font-semibold text-xs text-white
                 uppercase tracking-widest hover:bg-green-900
                 transition ease-in-out duration-150 shadow-md"
        ]
      )
    }}
>
    {{ $slot }}
</button>
