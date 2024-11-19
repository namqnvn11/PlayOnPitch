@props(['disabled' => false,'name'=>'', 'placeholder'=>'','value'=>'','id'=>'','time'=>''])

<input class='border-gray-300 dark:border-gray-700 h-10 w-[100px] dark:bg-gray-900 dark:text-gray-300
              focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500
              dark:focus:ring-indigo-600 rounded-md shadow-sm'
       type="time"
       placeholder="{{$placeholder}}"
       name="{{$name}}"
       value="{{$value}}"
       id="{{$id}}"
       time="{{$time}}"
>
