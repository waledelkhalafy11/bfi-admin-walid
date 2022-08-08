@extends('layouts.index')
@section('page_title')
{{$cityData->city_name}}
@endsection
@section('locations_active')
    nav-item active
@endsection
@section('pg_name')
    Update City Data
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
            Can't Update City :
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

  <form action="{{ route('updatecity') }}" method="POST">
    @csrf
    
    <label for="exampleFormControlInput1" class="form-label">City Name</label>
    <input type="text" class="form-control" id="region" value="{{$cityData->city_name}}" name="city_name" placeholder="Add Name">
    <input hidden type="text" value="{{$cityData->region_id}}"  id="region_id" name="region_id" >
    <input hidden type="text" value="{{$cityData->id}}"  id="city_id" name="city_id" >

    <div class="row mt-4">
        <div class="col-6">
            <label for="exampleFormControlInput1" class="form-label">City Longitude</label>
    
            <input type="text" class="form-control"  id="city_longitude" name="city_longitude" placeholder="City Longitude">
            </div>
        <div class="col-6">
            <label for="exampleFormControlInput1" class="form-label">City Latitude</label>
            <input type="text" class="form-control" id="city_latitude" name="city_latitude" placeholder="City Latitude">
            </div>
       </div>
    </div>
    <div class="col-12 mapp">
                  <div id="map"></div>
                </div>
                  <button style="margin: 20px auto" class="btn btn-success" type="submit">Update city</button>
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
            zoom: 8 // starting zoom
        });
        this.marker = new mapboxgl.Marker();
        this.map.on('click', this.add_marker.bind(this));
        window.onload = function(){
            var longinput1 = document.getElementById('city_longitude').value;
            var latinput1 = document.getElementById('city_latitude').value;
            let indexmarker = {
                lngLat : {
                    lng : lng ,
                    lat : lat
                }
            }
            add_marker(indexmarker);

        }
        function add_marker(event) {
            var coordinates = event.lngLat;
            var longinput = document.getElementById('city_longitude');
            var latinput = document.getElementById('city_latitude');
            longinput.value = coordinates.lng;
            latinput.value = coordinates.lat;

            this.marker.setLngLat(coordinates).addTo(this.map);

        }
    </script>
@endsection
