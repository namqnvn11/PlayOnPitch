@props(['class'=>''])
<button
    {{ $attributes->merge(
        [
            'type'=>
                'submit',
            'class' =>
                "$class items-center w-[120px] px-4 py-[10px] bg-green-700
                 border border-transparent rounded-md
                 font-semibold text-xs text-white
                 uppercase tracking-widest hover:bg-green-900
                 transition ease-in-out duration-150"
        ]
      )
    }}
>
    {{ $slot }}
</button>