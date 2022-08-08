@extends('layouts.index')
@section('page_title')
    New City
@endsection
@section('locations_active')
    nav-item active
@endsection
@section('pg_name')
    Add New Photos
@endsection
@section('headaddons')
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <script src='https://api.mapbox.com/mapbox.js/v2.4.0/mapbox.js'></script>
    <link href='https://api.mapbox.com/mapbox.js/v2.4.0/mapbox.css' rel='stylesheet' />
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.js"></script>
    
@endsection

@section('content')
@if (count($errors) > 0)
    <div class="col-12 " id="div__Error">
        @foreach ($errors->all() as $error)
        <div class="zoomIn col-12 alert alert-danger" >
            Can't add Photo :
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

  <form action="{{ route('addnewPhotos') }}" method="POST"  enctype="multipart/form-data">
    @csrf
    
    
    

    <label for="exampleFormControlInput1" class="form-label">Images Upload</label>
    
    <input hidden type="number" value="{{$uid}}"  id="unit_id" name="unit_id" >
    <input type="file" accept="image/png, image/gif, image/jpeg" multiple class="form-control" id="file" name="images[]">
   
    <div class="col-12 ">
             
                  <button style="margin: 20px auto" class="btn btn-success" type="submit">Add Photos</button>
                </form>
</div>         
</div>
 
      
@endsection
