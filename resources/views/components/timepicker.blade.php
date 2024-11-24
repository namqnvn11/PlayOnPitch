@props(['class'=>''])
<input
    {{
        $attributes
        ->merge(
            [
                'type' => 'date',
                'class' =>
                " $class inline-flex items-center px-4 py-2 h-10 border border-green-300
                  rounded-md font-semibold text-sm text-gray-700 uppercase
                  tracking-widest shadow-sm hover:bg-green-900 hover:text-white
                  focus:outline-none focus:bg-green-900 focus:ring-2
                  focus:ring-indigo-500 focus:ring-offset-2 focus:text-white
                  disabled:opacity-25 transition ease-in-out duration-150"
            ]) }}
>
