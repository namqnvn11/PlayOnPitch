@props(['class'=>''])
<button
    {{ $attributes->merge(
        [
            'type'=>
                'submit',
            'class' =>
                "$class items-center w-[90px] px-4 py-2 bg-red-700
                 border border-transparent rounded-md
                 font-semibold text-xs text-white
                 uppercase tracking-widest hover:bg-red-900
                 transition ease-in-out duration-150"
        ]
      )
    }}
>
    {{ $slot }}
</button>
