@extends('layouts.index')
@section('page_title')
    {{ $unit->unit_name }}
@endsection
@section('units_active')
    nav-item active
@endsection
@section('pg_name')
    Update Unit Data
@endsection
@section('headaddons')
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <script src='https://api.mapbox.com/mapbox.js/v2.4.0/mapbox.js'></script>
    <link href='https://api.mapbox.com/mapbox.js/v2.4.0/mapbox.css' rel='stylesheet' />
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.js"></script>
    <style>
        .mapp {
            height: 400px;
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
                    Can't Update Unit :
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
            }, 5000);
        </script>
    @endif
    <form action="{{ route('update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container mt-3">

            <input type="text" class="form-control " hidden name="unit_id" value="{{ $unit->id }}">
            <input type="text" class="form-control " hidden name="property_id" value="{{ $proprties->id }}">

            <div class="row mb-2">
                <div class="col-6">

                    <label for="exampleFormControlInput1" class="form-label">Unit Name</label>
                    <input type="text" class="form-control" id="unit" name="unit_name" value="{{ $unit->unit_name }}"
                        placeholder="Add Name">
                </div>
                <div class="col-6">
                    <label for="exampleFormControlInput1" class="form-label">Unit Address</label>
                    <input type="text" class="form-control" id="unit" name="unit_address"
                        value="{{ $unit->unit_address }}" placeholder="Add the adress">

                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3">

                    <label for="exampleFormControlInput1" class="form-label">Unit Price</label>
                    <input type="number" step="0.001" class="form-control" id="unit" name="unit_price"
                        value="{{ $unit->unit_price }}" placeholder="ex: 2000.00">
                </div>

                <div class="col-3">
                    <label for="exampleFormControlInput1" class="form-label">Main Category</label>
                    <select id="main_category" onchange="getCategories()" class="form-control" name="main_category">
                        @foreach ($mainCat as $cat)
                            @if ($cat == $unit->main_category)
                                <option selected value="{{ $unit->main_category }}">{{ $unit->main_category }}</option>
                            @else
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                @switch($unit->main_category)
                    @case('Residential')
                        <div id="unit_categoryDiv" class="col-3">
                            <label for="unit_category" class="form-label">Unit Category</label>
                            <select onchange="getResCategories()" id="unit_category" class="form-control" name="unit_category">
                                @php($resCats = ['Villa', 'Appartment', 'Sahel'])
                                @foreach ($resCats as $cat)
                                    @if ($cat == $unit->unit_category)
                                        <option selected value="{{ $unit->unit_category }}">{{ $unit->unit_category }}
                                        </option>
                                    @else
                                        <option value="{{ $cat }}">{{ $cat }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div id="res_unit_categoryDiv" class="col-3">
                            <label for="exampleFormControlInput1" class="form-label">Unit Category</label>
                            <select id="res_unit_category" class="form-control" name="res_unit_category">
                                @switch($unit->unit_category)
                                    @case('Villa')
                                        @php($resunitCats = ['Standalone', 'Twin House', 'Town House'])
                                        @foreach ($resunitCats as $rescat)
                                            @if ($rescat == $unit->res_unit_category)
                                                <option selected value="{{ $unit->res_unit_category }}">{{ $unit->res_unit_category }}
                                                </option>
                                            @else
                                                <option value="{{ $rescat }}">{{ $rescat }}</option>
                                            @endif
                                        @endforeach
                                    @break

                                    < @case('Appartment') @php($resunitCats = ['Duplex', 'Penthouse', 'Appartment']) @foreach ($resunitCats as $rescat)
                                            @if ($rescat == $unit->res_unit_category)
                                                <option selected value="{{ $unit->res_unit_category }}">{{ $unit->res_unit_category }}
                                                </option>
                                            @else
                                                <option value="{{ $rescat }}">{{ $rescat }}</option>
                                            @endif
                                            @endforeach
                                        @break

                                        @case('Sahel')
                                            @php($resunitCats = ['Chalets', 'Loft', 'One Story' , 'Standalone', 'Twin House', 'Town House'])
                                            @foreach ($resunitCats as $rescat)
                                                @if ($rescat == $unit->res_unit_category)
                                                    <option selected value="{{ $unit->res_unit_category }}">
                                                        {{ $unit->res_unit_category }}
                                                    </option>
                                                @else
                                                    <option value="{{ $rescat }}">{{ $rescat }}</option>
                                                @endif
                                            @endforeach
                                        @break

                                        @default
                                    @endswitch

                            </select>
                        </div>
                    @break

                    @case('Commercial')
                        <div id="unit_categoryDiv" class="col-3">
                            <label for="unit_category" class="form-label">Unit Category</label>
                            <select onchange="getResCategories()" id="unit_category" class="form-control" name="unit_category">

                            </select>
                        </div>
                        <div id="res_unit_categoryDiv" class="col-3">
                            <label for="res_unit_category" class="form-label">Unit Category</label>
                            <select id="res_unit_category" class="form-control" name="res_unit_category">

                            </select>
                        </div>
                        <script>
                            document.getElementById('unit_categoryDiv').style.visibility = 'hidden';
                            document.getElementById('res_unit_categoryDiv').style.visibility = 'hidden';
                            document.getElementById('unit_category').value = null;
                            document.getElementById('res_unit_category').value = null;
                        </script>
                    @break

                    @case('Administration')
                        <div id="unit_categoryDiv" class="col-3">
                            <label for="unit_category" class="form-label">Unit Category</label>
                            <select onchange="getResCategories()" id="unit_category" class="form-control" name="unit_category">

                            </select>
                        </div>
                        <div id="res_unit_categoryDiv" class="col-3">
                            <label for="res_unit_category" class="form-label">Unit Category</label>
                            <select id="res_unit_category" class="form-control" name="res_unit_category">

                            </select>
                        </div>
                        <script>
                            document.getElementById('unit_categoryDiv').style.visibility = 'hidden';
                            document.getElementById('res_unit_categoryDiv').style.visibility = 'hidden';
                            document.getElementById('unit_category').value = null;
                            document.getElementById('res_unit_category').value = null;
                        </script>
                    @break

                    @case('Medical')
                        <div id="unit_categoryDiv" class="col-3">
                            <label for="unit_category" class="form-label">Unit Category</label>

                            <select onchange="getResCategories()" id="unit_category" class="form-control" name="unit_category">

                            </select>
                        </div>
                        <div id="res_unit_categoryDiv" class="col-3">
                            <label for="res_unit_category" class="form-label">Unit Category</label>
                            <select id="res_unit_category" class="form-control" name="res_unit_category">

                            </select>
                        </div>
                        <script>
                            document.getElementById('unit_categoryDiv').style.visibility = 'hidden';
                            document.getElementById('res_unit_categoryDiv').style.visibility = 'hidden';
                            document.getElementById('unit_category').value = null;
                            document.getElementById('res_unit_category').value = null;
                        </script>
                    @break

                    @default
                @endswitch
            </div>
            <div class="row mb-2">

                <label for="exampleFormControlInput1" class="form-label">Unit Description</label>

                <textarea name="unit_description" id="" cols="30" rows="10">
        {{ $unit->unit_description }}
    </textarea>

            </div>
            <input type="text" class="form-control" hidden value="{{ $unit->dist_id }}" id="dist_id" name="dist_id"
                placeholder="name@example.com">
            <input type="text" class="form-control" value="{{ $unit->unit_longitude }}" hidden id="unit_longitude"
                name="unit_longitude" placeholder="name@example.com">
            <input type="text" class="form-control" value="{{ $unit->unit_latitude }}" hidden id="unit_latitude"
                name="unit_latitude" placeholder="name@example.com">

            <div class="col-12 mapp">
                <div id="map"></div>
            </div>
            <div class="row mt-5">
                <div class="md-col-4 mr-2 xs-col-12 mb-2">

                    <label for="exampleFormControlInput1" class="form-label">Surfuce Area</label>
                    <input type="number" min="1" class="form-control" value="{{ $proprties->surface_area }}" id="file"
                        name="surface_area" placeholder="Surfuce Area">
                </div>
                <div class="md-col-4 mr-2 xs-col-12 mb-2">

                    <label for="exampleFormControlInput1" class="form-label">kitchen</label>
                    <input type="number" multiple class="form-control" id="file" name="kitchen"
                        value="{{ $proprties->kitchen }}" placeholder="kitchen">
                </div>
                <div class="md-col-4 mr-2 xs-col-12 mb-2">

                    <label for="exampleFormControlInput1" class="form-label">bedroom</label>
                    <input type="number" multiple class="form-control" id="file" name="bedroom"
                        value="{{ $proprties->bedroom }}" placeholder="bedroom">
                </div>
                <div class="md-col-4 mr-2 xs-col-12 mb-2">

                    <label for="exampleFormControlInput1" class="form-label">rooms</label>
                    <input type="number" multiple class="form-control" id="file" name="rooms"
                        value="{{ $proprties->rooms }}" placeholder="rooms">
                </div>
                <div class="md-col-4 mr-2 xs-col-12 mb-2">

                    <label for="exampleFormControlInput1" class="form-label">living room</label>
                    <input type="number" multiple class="form-control" id="file" name="living_room"
                        value="{{ $proprties->living_room }}" placeholder="living_room">
                </div>
                <div class="md-col-4 mr-2 xs-col-12 mb-2">

                    <label for="exampleFormControlInput1" class="form-label">bathroom</label>
                    <input type="number" multiple class="form-control" id="file" name="bathroom"
                        value="{{ $proprties->bathroom }}" placeholder="bathroom">
                </div>
                <div class="md-col-4 mr-2 xs-col-12 mb-2">

                    <label for="exampleFormControlInput1" class="form-label">garage</label>
                    <input type="number" multiple class="form-control" id="file" name="garage"
                        value="{{ $proprties->garage }}" placeholder="garage">
                </div>
                <div class="md-col-4 mr-2 xs-col-12 mb-2">

                    <label for="exampleFormControlInput1" class="form-label">elevator</label>
                    <input type="number" multiple class="form-control" id="file" name="elevator"
                        value="{{ $proprties->elevator }}" placeholder="elevator">
                </div>
                <div class="md-col-4 mr-2 xs-col-12 mb-2">

                    <label for="exampleFormControlInput1" class="form-label">floor</label>
                    <input type="number" multiple class="form-control" id="file" name="floor"
                        value="{{ $proprties->floor }}" placeholder="floor">
                </div>
                <div class="md-col-4 mr-2 xs-col-12 mb-2">
                    <label for="exampleFormControlInput1" class="form-label">Garden</label>
                    <input type="number" value="{{ $proprties->garden }}" min="0" class="form-control" id="garden"
                        name="garden" placeholder="garden">
                </div>
                <div class="md-col-4 mr-2 xs-col-12 mb-2">
                    <label for="pool" class="form-label">Pool</label>
                    <input type="number" value="{{ $proprties->pool }}" min="0" class="form-control" id="pool"
                        name="pool" placeholder="pool">

                </div>

            </div>
        </div>
        <div class="row">
            <button style="margin: 20px auto" class="btn btn-success" type="submit">Update</button>

        </div>
        </div>
    </form>
    <script>
        mapboxgl.accessToken =
            'pk.eyJ1Ijoid2FsZWRlbGtoYWxhZnkiLCJhIjoiY2w2Z3Fzc2QzMTl5MzNqbjJrbzd5eGpnMyJ9.WOoSdruvXycU7nqQ6k09gg';

        var longinput1 = document.getElementById('unit_longitude').value;
        var latinput1 = document.getElementById('unit_latitude').value;
        this.map = new mapboxgl.Map({
            container: "map",
            style: "mapbox://styles/mapbox/streets-v11",
            center: [longinput1, latinput1], // starting position [lng, lat]
            zoom: 15 // starting zoom
        });
        this.marker = new mapboxgl.Marker();
        this.map.on('click', this.add_marker.bind(this));
        window.onload = function() {
            var longinput1 = document.getElementById('unit_longitude').value;
            var latinput1 = document.getElementById('unit_latitude').value;
            let indexmarker = {
                lngLat: {
                    lng: longinput1,
                    lat: latinput1
                }
            }
            add_marker(indexmarker);
        };

        function add_marker(event) {
            var coordinates = event.lngLat;
            var longinput = document.getElementById('unit_longitude');
            var latinput = document.getElementById('unit_latitude');
            longinput.value = coordinates.lng;
            latinput.value = coordinates.lat;

            this.marker.setLngLat(coordinates).addTo(this.map);

        }

        function getResCategories() {
            let unit_cat = document.getElementById('unit_category').value;
            let res_unit_cat = document.getElementById('res_unit_category');
            switch (unit_cat) {
                case null:
                    res_unit_cat.value = null
                    break;
                case 'Appartment':
                    res_unit_cat.innerHTML =
                        '<option value="Duplex">Duplex</option><option value="Penthouse">Penthouse</option><option value="Appartment">Appartment</option>';
                    break;
                case 'Villa':
                    res_unit_cat.innerHTML =
                        '<option value="Standalone">Standalone</option><option value="Twin House">Twin House</option><option value="Town House">Town House</option>';

                    break;
                case 'Sahel':
                    res_unit_cat.innerHTML =
                        '<option value="Chalets">Chalets</option><option value="Loft">Loft</option><option value="One Story">One Story</option>';

                    break;

                default:
                    break;
            }

        }


        function getCategories() {
            let main_cat = document.getElementById('main_category').value;
            let unit_cat = document.getElementById('unit_category');
            let res_unit_cat = document.getElementById('res_unit_category');
            let unit_catDiv = document.getElementById('unit_categoryDiv');
            let res_unit_catDiv = document.getElementById('res_unit_categoryDiv');
            switch (main_cat) {
                case 'Residential':
                    unit_catDiv.style.visibility = 'visible';
                    res_unit_catDiv.style.visibility = 'visible';
                    unit_cat.innerHTML =
                        '<option value="Villa">Villa</option><option value="Appartment">Appartment</option><option value="Sahel">Sahel</option>';
                    res_unit_cat.innerHTML =
                        '<option value="Standalone">Standalone</option><option value="Twin House">Twin House</option><option value="Town House">Town House</option>';
                    break;
                case 'Commercial':
                    unit_cat.value = null;
                    res_unit_cat.value = null;
                    unit_catDiv.style.visibility = 'hidden';
                    res_unit_catDiv.style.visibility = 'hidden';
                    break;
                case 'Administration':
                    unit_cat.value = null;
                    res_unit_cat.value = null;
                    unit_catDiv.style.visibility = 'hidden';
                    res_unit_catDiv.style.visibility = 'hidden';
                    break;
                case 'Medical':
                    unit_cat.value = null;
                    res_unit_cat.value = null;
                    unit_catDiv.style.visibility = 'hidden';
                    res_unit_catDiv.style.visibility = 'hidden';
                    break;

                default:
                    break;
            }

        }
    </script>
@endsection
