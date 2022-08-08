@extends('layouts.index')
@section('page_title')
    New District
@endsection
@section('pg_name')
    Update District
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
                <div class="zoomIn col-12 alert alert-danger">
                    Can't add Distrirct :
                    {{ $error }}
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

                }, 400)
            }, 4000);
        </script>
    @endif
    <div class="col-12">

        <form action="{{ route('updatedist') }}" method="POST">
            @csrf

            <label for="exampleFormControlInput1" class="form-label">District Name</label>
            <input type="text" class="form-control" value="{{$dist->dist_name}}" id="region" name="dist_name" placeholder="Add Name">
            <div class="row mt-2">
                <div class="col-6">
                    <label for="exampleFormControlInput1" class="form-label">District Longitude</label>

                    <input type="text" class="form-control" value="{{$dist->dist_longitude}}" id="dist_longitude" name="dist_longitude"
                        placeholder="City Longitude">
                </div>
                <div class="col-6">
                    <label for="exampleFormControlInput1" class="form-label">District Latitude</label>
                    <input type="text" class="form-control" value="{{$dist->dist_latitude}}" id="dist_latitude" name="dist_latitude"
                        placeholder="City Latitude">
                </div>
            </div>
            <input hidden type="text" value="{{ $dist->id }}" id="dist_id" name="dist_id">

            <input hidden type="text" value="{{ $dist->city_id }}" id="city_id" name="city_id">
            <div class="col-12 mapp">
                <div id="map"></div>
            </div>
            <button style="margin: 20px auto" class="btn btn-success" type="submit">Update District</button>
        </form>
    </div>
    </div>
    <script>
        var distData = {!! json_encode($dist->toArray(), JSON_HEX_TAG) !!};
        var lng = distData.dist_longitude;
        var lat = distData.dist_latitude;
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
        window.onload = function(){
            var longinput1 = document.getElementById('dist_longitude').value;
            var latinput1 = document.getElementById('dist_latitude').value;
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
            var longinput = document.getElementById('dist_longitude');
            var latinput = document.getElementById('dist_latitude');
            longinput.value = coordinates.lng;
            latinput.value = coordinates.lat;

            this.marker.setLngLat(coordinates).addTo(this.map);

        }
    </script>
@endsection
