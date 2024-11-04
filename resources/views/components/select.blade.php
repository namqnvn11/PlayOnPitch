@props(['class' => ''])

<select
    {{
        $attributes
        ->merge(
            [
                'class' =>
                'ml-1 border-gray-300 dark:border-gray-700 h-10 dark:bg-gray-900 dark:text-gray-300
                 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500
                 dark:focus:ring-indigo-600 rounded-md shadow-sm'
            ])
    }}
>
    {{$slot}}
</select>


