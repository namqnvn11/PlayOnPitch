@props(['class' => ''])

<select
    {{
        $attributes
        ->merge(
            [
                'class' =>
                "$class border-gray-300 h-10
                 focus:border-green-500  focus:ring-green-500 rounded-md shadow-sm"
            ])
    }}
>
    {{$slot}}
</select>


