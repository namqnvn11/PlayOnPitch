@props(['disabled' => false,'name'=>'', 'placeholder'=>'','value'=>'','id'=>'','time'=>''])

<input class='border-gray-300 h-10 w-[100px]
              focus:ring-green-500
              rounded-md shadow-sm focus:border-green-500'
       type="time"
       placeholder="{{$placeholder}}"
       name="{{$name}}"
       value="{{$value}}"
       id="{{$id}}"
       time="{{$time}}"
>
