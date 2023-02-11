@extends('layouts.index')
@section('page_title')
    New Region
@endsection
@section('locations_active')
    nav-item active
@endsection
@section('pg_name')
    Add New Region
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
            Can't add Region :
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

  <form action="{{ route('addregion') }}" method="POST" >
    @csrf
    <label for="exampleFormControlInput1" class="form-label">Region Name</label>
    <input type="text" class="form-control" id="region" name="region_name" placeholder="Add Name" required> 
   <div class="row mt-2">
    <div class="col-6">
        <label for="exampleFormControlInput1" class="form-label">Region Longitude</label>

        <input type="text" class="form-control"  id="region_longitude" name="region_longitude" required placeholder="Region Longitude">
        </div>
    <div class="col-6">
        <label for="exampleFormControlInput1" class="form-label">Region Latitude</label>
        <input type="text" class="form-control" id="region_latitude" name="region_latitude" placeholder="Region Latitude" required>
        </div>
   </div>
    <div class="col-12 mapp">
                  <div id="map"></div></div>
                  <button style="margin: 20px auto" class="btn btn-success" type="submit">Add Region</button>
                </form>
</div>         
</div>
   <script>
        mapboxgl.accessToken =
            'pk.eyJ1Ijoid2FsZWRlbGtoYWxhZnkiLCJhIjoiY2w2Z3Fzc2QzMTl5MzNqbjJrbzd5eGpnMyJ9.WOoSdruvXycU7nqQ6k09gg';


        this.map = new mapboxgl.Map({
            container: "map",
            style: "mapbox://styles/mapbox/streets-v11",
            center: [0, 10], // starting position [lng, lat]
            zoom: 1.7 // starting zoom
        });
        this.marker = new mapboxgl.Marker();
        this.map.on('click', this.add_marker.bind(this));

        function add_marker(event) {
            var coordinates = event.lngLat;
            var longinput = document.getElementById('region_longitude');
            var latinput = document.getElementById('region_latitude');
            longinput.value = coordinates.lng;
            latinput.value = coordinates.lat;

            this.marker.setLngLat(coordinates).addTo(this.map);

        }
    </script>
@endsection
