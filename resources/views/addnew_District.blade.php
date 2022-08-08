@extends('layouts.index')
@section('page_title')
    New District
@endsection
@section('pg_name')
    Add New District
@endsection
@section('locations_active')
    nav-item active
@endsection
@section('headaddons')
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <script src='https://api.mapbox.com/mapbox.js/v2.4.0/mapbox.js'></script>
    <link href='https://api.mapbox.com/mapbox.js/v2.4.0/mapbox.css' rel='stylesheet' />
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.js"></script>
    <style>

        .mapp {
            height: 60vh;
            position: relative
        }

        #map {
            position: absolute;
            top: 20px;
            bottom: 0;
            width: 100%;
        }

    </style>
@endsection

@section('content')
@if (count($errors) > 0)
    <div class="col-12 " id="div__Error">
        @foreach ($errors->all() as $error)
        <div class="zoomIn col-12 alert alert-danger" >
            Can't add Distrirct :
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
            }, 4000);
        </script>
    @endif
<div class="col-12">

  <form action="{{ route('adddist') }}" method="POST">
    @csrf
    
    <label for="exampleFormControlInput1" class="form-label">District Name</label>
    <input type="text" class="form-control" id="region" name="dist_name" placeholder="Add Name">
    <div class="row mt-2">
    <div class="col-6">
        <label for="exampleFormControlInput1" class="form-label">District Longitude</label>

        <input type="text" class="form-control"  id="dist_longitude" name="dist_longitude" placeholder="City Longitude">
        </div>
    <div class="col-6">
        <label for="exampleFormControlInput1" class="form-label">District Latitude</label>
        <input type="text" class="form-control" id="dist_latitude" name="dist_latitude" placeholder="City Latitude">
        </div>
   </div>
    <input hidden type="text" value="{{$city}}"  id="city_id" name="city_id" >
       <div class="col-12 mapp">
                  <div id="map"></div></div>
                  <button style="margin: 20px auto" class="btn btn-success" type="submit">Add District</button>
                </form>
</div>         
</div>
   <script>
        var cityData = {!! json_encode($cityData->toArray(), JSON_HEX_TAG) !!};
        var lng = cityData.city_longitude ;
        var lat = cityData.city_latitude ;
        mapboxgl.accessToken =
            'pk.eyJ1Ijoid2FsZWRlbGtoYWxhZnkiLCJhIjoiY2w2Z3Fzc2QzMTl5MzNqbjJrbzd5eGpnMyJ9.WOoSdruvXycU7nqQ6k09gg';


        this.map = new mapboxgl.Map({
            container: "map",
            style: "mapbox://styles/mapbox/streets-v11",
            center: [lng, lat], // starting position [lng, lat]
            zoom: 10 // starting zoom
        });
        this.marker = new mapboxgl.Marker();
        this.map.on('click', this.add_marker.bind(this));

        function add_marker(event) {
            var coordinates = event.lngLat;
            var longinput = document.getElementById('dist_longitude');
            var latinput = document.getElementById('dist_latitude');
            longinput.value = coordinates.lng;
            latinput.value = coordinates.lat;

            this.marker.setLngLat(coordinates).addTo(this.map);

        }
    </script>
@endsection
