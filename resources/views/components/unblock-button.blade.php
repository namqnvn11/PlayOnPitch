@props(['class'=>''])
<button
    {{ $attributes->merge(
        [
            'type'=>
                'submit',
            'class' =>
                "$class items-center w-[90px] py-2 h-10 bg-gray-500
                 border border-transparent rounded-md
                 font-semibold text-xs text-white
                 uppercase tracking-widest hover:bg-gray-700
                 transition ease-in-out duration-150"
        ]
      )
    }}
>
    {{ $slot }}
</button>
