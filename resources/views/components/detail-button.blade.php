@props(['class'=>''])
<button
    {{ $attributes->merge(
        [
            'type'=>
                'submit',
            'class' =>
                "$class items-center w-[70px] py-2 bg-blue-700
                 border border-transparent rounded-md
                 font-semibold text-xs text-white
                 uppercase tracking-widest hover:bg-blue-900
                 transition ease-in-out duration-150"
        ]
      )
    }}
>
    {{ $slot }}
</button>
