@extends('layouts.appboss')
@section("content")
<body>
 <h1> this is testing page</h1>
<button><a href="{{url('boss/yard/testing/create')}}">create</a></button>
 <button><a href="{{url('boss/yard/testing/delete')}}">deleteAll</a></button>
 <table class="table">
     <thead>
        <tr>
            <th scope="col">yard</th>
            <th scope="col">date</th>
            <th scope="col">price</th>
            <th scope="col">time</th>
        </tr>
     </thead>
     <tbody>
        @foreach(\App\Models\YardSchedule::all() as $y)
            <tr>
                <td>{{$y->yard_id}}</td>
                <td>{{$y->date}}</td>
                <td>{{$y->price_per_hour}}</td>
                <td>{{$y->time_slot}}</td>
            </tr>
        @endforeach
     </tbody>
 </table>
</body>
@endsection
