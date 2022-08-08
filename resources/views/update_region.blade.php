@extends('layouts.index')
@section('page_title')
    {{ $regionData->region_name }}
@endsection
@section('locations_active')
    nav-item active
@endsection
@section('pg_name')
    Update Region Data
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
                    Can't Update Region :
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
            }, 2000);
        </script>
    @endif
    <div class="col-12">

        <form action="{{ route('updateregion') }}" method="POST">
            @csrf
            <div class="row">

                <label for="exampleFormControlInput1" class="form-label">Region Name</label>
                <input type="text" class="form-control" id="region" value="{{ $regionData->region_name }}"
                    name="region_name" placeholder="Add Name">
            </div>
            <input type="number" hidden name="region_id" value="{{ $regionData->id }}">
            <div class="row mt-4">
                <div class="col-6">
                    <label for="exampleFormControlInput1" class="form-label">Region Longitude</label>

                    <input type="text" class="form-control" id="region_longitude" name="region_longitude"
                        placeholder="Region Longitude">
                </div>
                <div class="col-6">
                    <label for="exampleFormControlInput1" class="form-label">Region Latitude</label>
                    <input type="text" class="form-control" id="region_latitude" name="region_latitude"
                        placeholder="Region Latitude">
                </div>
            </div>
    </div>
    <div class="col-12 mapp">
        <div id="map"></div>
    </div>
    <button style="margin: 20px auto" class="btn btn-success" type="submit">Update Region</button>
    </form>
    </div>
    </div>
    <script>
        var regionData = {!! json_encode($regionData->toArray(), JSON_HEX_TAG) !!};
        var lng = regionData.region_longitude;
        var lat = regionData.region_latitude;
        mapboxgl.accessToken =
            'pk.eyJ1Ijoid2FsZWRlbGtoYWxhZnkiLCJhIjoiY2w2Z3Fzc2QzMTl5MzNqbjJrbzd5eGpnMyJ9.WOoSdruvXycU7nqQ6k09gg';


        this.map = new mapboxgl.Map({
            container: "map",
            style: "mapbox://styles/mapbox/streets-v11",
            center: [lng, lat], // starting position [lng, lat]
            zoom: 3 // starting zoom
        });
        this.marker = new mapboxgl.Marker();
        this.map.on('click', this.add_marker.bind(this));
        window.onload = function() {
            var longinput1 = document.getElementById('region_longitude').value;
            var latinput1 = document.getElementById('region_latitude').value;
            let indexmarker = {
                lngLat: {
                    lng: lng,
                    lat: lat
                }
            }
            add_marker(indexmarker);

        }

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
