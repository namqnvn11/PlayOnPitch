@props(['class'=>'','name'=>'','isChecked'=>'','onchange'=>'','id'=>'','onclick'=>'','value'=>''])
<input
    class="{{$class}} ml-2 text-green-700 border-green-900 rounded focus:ring-2 focus:ring-green-600"
    type="checkbox"
    name="{{ $name }}"
    id="{{$id}}"
    value="{{$value}}"
    {{ $isChecked ? 'checked' : '' }}
    {{ $onchange ? "onchange=$onchange" : '' }}
    {{ $onclick ? "onclick=$onclick" : '' }}

/>
