
@extends('layouts.index')
@section('page_title')
Cities
@endsection
@section('locations_active')
    nav-item active
@endsection
@section('headaddons')


@endsection
@section('pg_name')
    Districts  
    <a class="ml-4 btn btn-success" href="{{route('addDist_location_select')}}">Add New District</a>
@endsection
@section('content')
@if (count($errors) > 0)
    <div class="col-12 " id="div__Error">
        @foreach ($errors->all() as $error)
        <div class="zoomIn col-12 alert alert-danger" >
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
@if (Session::get('message'))
<div class="col-12 alert alert-success" id="message">{{Session::get('message');}}</div>
<script>
    let messageeDiv = document.getElementById('message')
    setInterval(function(){
        messageeDiv.style.display = "none"
    }, 2000);

</script>
@endif
@foreach ($districts as $i=>$district)
<div class="col-xl-3 col-md-6 mb-4 zoomIn">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xxl font-weight-bold text-primary text-uppercase mb-1">
                        {{$district->dist_name}}</div>
                     
                </div>
                <div class="col-12">
                   
                </div>
         <div class="row mt-2 cardbtns">
           
        <div class="px-2">
            <a href="{{route('updateDistview' , [ 'did'=> $district->id])}}" class="px-4 btn btn-warning">Edit</a>
           <form class="d-inline" method="POST" action="{{route('addnew')}}">
               @csrf
               <input type="number" value="{{$district->id}}" name="district" hidden>
               <button type="submit" class="px-4 btn btn-primary">Add Unit</button>
            </form>
            <a href="{{route('showAllDistUnits' , [ 'dis'=> $district->id])}}" class="px-4 btn btn-primary">Units</a>

        </div>
         </div>
            
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection