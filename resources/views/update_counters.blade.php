@extends('layouts.index')
@section('page_title')
{{$counter->count_name}}
@endsection
@section('website_active')
    nav-item active
@endsection
@section('pg_name')
    Update Counter Data
@endsection
@section('headaddons')
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

@endsection

@section('content')
@if (count($errors) > 0)
    <div class="col-12 " id="div__Error">
        @foreach ($errors->all() as $error)
        <div class="zoomIn col-12 alert alert-danger" >
            Can't Update Counter :
            {{$error}}
            </div>
            @endforeach
        </div>

        <script>
            let messageeDiv = document.getElementById('div__Error')
            setInterval(function() {
            let messageeDiv = document.getElementById('div__Error')
              messageeDiv.classList.add('zoomOut')
              setInterval(function() {
                messageeDiv.style.display = "none"
                
              },400)
            }, 2000);
        </script>
    @endif
    <div class="col-12">

        <form action="{{ route('updateCounters') }}" method="POST">
            @csrf

            <label for="exampleFormControlInput1" class="form-label">Counter Name</label>
            <input type="text" class="form-control" id="counter_name" value="{{ $counter->count_name}}" name="count_name"
                placeholder="Add Name">
                
                
                <label for="exampleFormControlInput1" class="form-label mt-4">Number</label>
                <input type="text" class="form-control" id="num_count" value="{{ $counter->num_count }}" name="num_count"
                placeholder="Add Number">
            <input hidden type="text" value="{{ $counter->id }}" id="counter_id" name="counter_id">

            <button style="margin: 20px auto" class="btn btn-success" type="submit">Submit Updates</button>
        </form>
    </div>
    </div>
@endsection
