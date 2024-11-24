@props(['disabled' => false,'class'=>''])

<input @disabled($disabled)
    {{
        $attributes
        ->merge(
            [
                'class' =>
                "$class border-gray-300 p-2 h-10
                 focus:border-green-500 focus:ring-green-500
                 rounded-md shadow-sm"
            ])
    }}
>
