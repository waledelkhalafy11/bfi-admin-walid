@extends('layouts.index')
@section('page_title')
    New Unit
@endsection
@section('units_active')
    nav-item active
@endsection
@section('pg_name')
    Add New Unit
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
                    Can't add Unit :
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
    <form action="{{ route('upload.uploadfile') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container mt-3">

            <div class="row mb-2">
                <div class="col-6">

                    <label for="exampleFormControlInput1" class="form-label">Unit Name</label>
                    <input type="text" class="form-control" id="unit" name="unit_name" required placeholder="Add Name">
                </div>
                <div class="col-6">
                    <label for="exampleFormControlInput1" class="form-label">Unit Address</label>
                    <input type="text" class="form-control" id="unit" name="unit_address" required placeholder="Add the adress">

                </div>
              </div>
              <div class="row mb-2">
                <div class="col-3">

                    <label for="exampleFormControlInput1" class="form-label">Unit Price</label>
                    <input type="number" class="form-control" id="unit" required name="unit_price" placeholder="ex: 200000">
                </div>


                <div class="col-3">
                    <label for="exampleFormControlInput1" class="form-label">Main Category</label>
                    <select id="main_category" onchange="getCategories()" required class="form-control" name="main_category">
                      <option disabled selected value="">Select category</option>
                      <option value="Residential">Residential</option>
                      <option value="Commercial">Commercial</option>
                      <option value="Administration">Administration</option>
                      <option value="Medical">Medical</option>
                    </select>
                </div>
                <div onchange="getResCategories()" id="unit_categoryDiv" class="col-3">
                    <label for="exampleFormControlInput1" class="form-label">Unit Category</label>
                    <select id="unit_category" class="form-control" required name="unit_category">
                        <option disabled selected value="">Select Main category First</option>
                       
                    </select>
                </div>
                <div id="res_unit_categoryDiv" class="col-3">
                    <label for="exampleFormControlInput1" class="form-label">Residential Unit Category</label>
                    <select  id="res_unit_category" class="form-control" required name="res_unit_category">
                        <option disabled selected value="">Select Unit category First</option>
                       
                    </select>
                </div>
            </div>
            <div class="row mb-2">

                <label for="exampleFormControlInput1" class="form-label">Unit Description</label>

                <textarea name="unit_description" id="" cols="30" rows="10" required>
      write unit descreption
    </textarea>

            </div>
            <input type="text" class="form-control" hidden value="{{ $district }}" id="dist_id" name="dist_id" required
                placeholder="name@example.com">
            <div class="container mt-5">
                <div class="row ">
                    <div class="col-6">
                        <label for="unit_longitude" class="form-label">Region Longitude</label>

                        <input type="text" class="form-control" id="unit_longitude" name="unit_longitude" required
                            placeholder="unit_longitude">
                    </div>
                    <div class="col-6">
                        <label for="unit_latitude" class="form-label">Unit Latitude</label>
                        <input type="text" class="form-control" id="unit_latitude" name="unit_latitude" required
                            placeholder="unit_latitude">
                    </div>
                </div>
            </div>



            <div class="col-12 mapp">
                <div id="map"></div>
            </div>
            <div class="row mt-5">
                <div class="md-col-4 mr-2 xs-col-12 mb-2">

                    <label for="exampleFormControlInput1" class="form-label">Surfuce Area</label>
                    <input type="number" min="0" value="0" class="form-control" id="file" name="surface_area" required
                        placeholder="Surfuce Area">
                </div>
                <div class="md-col-4 mr-2 xs-col-12 mb-2">

                    <label for="exampleFormControlInput1" class="form-label">kitchen</label>
                    <input type="number" min="0" value="0" class="form-control" id="file" name="kitchen" required
                        placeholder="kitchen">
                </div>
                <div class="md-col-4 mr-2 xs-col-12 mb-2">

                    <label for="exampleFormControlInput1" class="form-label">bedroom</label>
                    <input type="number" min="0" value="0" class="form-control" id="file" name="bedroom" required
                        placeholder="bedroom">
                </div>
                <div class="md-col-4 mr-2 xs-col-12 mb-2">

                    <label for="exampleFormControlInput1" class="form-label">rooms</label>
                    <input type="number" min="0" value="0" class="form-control" id="file" name="rooms" required
                        placeholder="rooms">
                </div>
                <div class="md-col-4 mr-2 xs-col-12 mb-2">

                    <label for="exampleFormControlInput1" class="form-label">living room</label>
                    <input type="number" min="0" value="0" class="form-control" id="file" name="living_room" required
                        placeholder="living room">
                </div>
                <div class="md-col-4 mr-2 xs-col-12 mb-2">

                    <label for="exampleFormControlInput1" class="form-label">bathroom</label>
                    <input type="number" min="0" value="0" class="form-control" id="file" name="bathroom" required
                        placeholder="bathroom">
                </div>
                <div class="md-col-4 mr-2 xs-col-12 mb-2">

                    <label for="exampleFormControlInput1" class="form-label">garage</label>
                    <input type="number" min="0" value="0" class="form-control" id="file" name="garage" required
                        placeholder="garage">
                </div>
                <div class="md-col-4 mr-2 xs-col-12 mb-2">

                    <label for="exampleFormControlInput1" class="form-label">elevator</label>
                    <input type="number" min="0" value="0" class="form-control" id="file" name="elevator" required
                        placeholder="elevator">
                </div>
                <div class="md-col-4 mr-2 xs-col-12 mb-2">

                    <label for="exampleFormControlInput1" class="form-label">floor</label>
                    <input type="number" min="0" value="0" class="form-control" id="file" name="floor" required
                        placeholder="floor">
                </div>
                <div class="md-col-4 mr-2 xs-col-12 mb-2">

                    <label for="exampleFormControlInput1" class="form-label">Garden</label>
                    <input type="number" min="0" value="0" class="form-control" id="garden" name="garden" required
                        placeholder="garden">
                </div>
                <div class="md-col-4 mr-2 xs-col-12 mb-2">

                  <label for="exampleFormControlInput1" class="form-label">Pool</label>
                  <input type="number" min="0" value="0" class="form-control" name="pool" required
                      placeholder="Pool">
              </div>
                <div class="md-col-4 mr-2 xs-col-12 mb-2">

                    <label for="exampleFormControlInput1" class="form-label">Images Upload</label>
                    <input type="file" accept="image/png, image/gif, image/jpeg" multiple class="form-control" id="file" required
                        name="images[]" placeholder="Unit Photos">
                </div>
                
            </div>
        </div>
        <div class="row">
            <button style="margin: 20px auto" class="btn btn-success" type="submit">Add Unit</button>

        </div>
        </div>
    </form>
    <script>
        document.getElementById('unit_categoryDiv').style.visibility = 'hidden';
        document.getElementById('res_unit_categoryDiv').style.visibility = 'hidden';

        var distData = {!! json_encode($distData->toArray(), JSON_HEX_TAG) !!};
        var lng = distData.dist_longitude;
        var lat = distData.dist_latitude;
        mapboxgl.accessToken =
            'pk.eyJ1Ijoid2FsZWRlbGtoYWxhZnkiLCJhIjoiY2w2Z3Fzc2QzMTl5MzNqbjJrbzd5eGpnMyJ9.WOoSdruvXycU7nqQ6k09gg';


        this.map = new mapboxgl.Map({
            container: "map",
            style: "mapbox://styles/mapbox/streets-v11",
            center: [lng, lat], // starting position [lng, lat]
            zoom: 12 // starting zoom
        });
        this.marker = new mapboxgl.Marker();
        this.map.on('click', this.add_marker.bind(this));

        function add_marker(event) {
            var coordinates = event.lngLat;
            var longinput = document.getElementById('unit_longitude');
            var latinput = document.getElementById('unit_latitude');
            longinput.value = coordinates.lng;
            latinput.value = coordinates.lat;

            this.marker.setLngLat(coordinates).addTo(this.map);

        }

        
        function getResCategories(){
          let unit_cat = document.getElementById('unit_category').value;
          let res_unit_cat = document.getElementById('res_unit_category');
          switch (unit_cat) {
            case null :
            res_unit_cat.value = null
                break;
            case 'Appartment':
            res_unit_cat.innerHTML = '<option value="Duplex">Duplex</option><option value="Penthouse">Penthouse</option><option value="Appartment">Appartment</option>';
              break;
            case 'Villa':
            res_unit_cat.innerHTML = '<option value="Standalone">Standalone</option><option value="Twin House">Twin House</option><option value="Town House">Town House</option>';

              break;
            case 'Sahel':
            res_unit_cat.innerHTML = '<option value="Chalets">Chalets</option><option value="Loft">Loft</option><option value="One Story">One Story</option><option value="Standalone">Standalone</option><option value="Twin House">Twin House</option><option value="Town House">Town House</option>';
              break;
            
            default:
              break;
          }

        }


        function getCategories(){
          let main_cat = document.getElementById('main_category').value;
          let unit_cat = document.getElementById('unit_category');
          let res_unit_cat = document.getElementById('res_unit_category');
          let unit_catDiv = document.getElementById('unit_categoryDiv');
          let res_unit_catDiv = document.getElementById('res_unit_categoryDiv');
          switch (main_cat) {
            case 'Residential':
            unit_catDiv.style.visibility = 'visible';
            res_unit_catDiv.style.visibility = 'visible';
            unit_cat.innerHTML = '<option value="Villa">Villa</option><option value="Appartment">Appartment</option><option value="Sahel">Sahel</option>';
            res_unit_cat.innerHTML = '<option value="Standalone">Standalone</option><option value="Twin House">Twin House</option><option value="Town House">Town House</option>';
              break;
            case 'Commercial':
            unit_cat.value = null;
            res_unit_cat.value = null ;
            unit_catDiv.style.visibility = 'hidden';
            res_unit_catDiv.style.visibility = 'hidden';
              break;
            case 'Administration':
            unit_cat.value = null;
            res_unit_cat.value = null ;
            unit_catDiv.style.visibility = 'hidden';
            res_unit_catDiv.style.visibility = 'hidden';
              break;
            case 'Medical':
            unit_cat.value = null;
            res_unit_cat.value = null ;
            unit_catDiv.style.visibility = 'hidden';
            res_unit_catDiv.style.visibility = 'hidden';
              break;
            
            default:
              break;
          }

        }
    </script>
@endsection
