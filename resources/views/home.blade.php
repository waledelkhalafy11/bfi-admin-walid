@extends('layouts.index')
@section('page_title')
    Home
@endsection
@section('home_active')
    nav-item active
@endsection
@section('headaddons')
    <link href="{{asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection
@section('pg_name')
    Dashbord Home
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
    <div class="col-xl-3 col-md-6 mb-4 zoomIn">
        <a href="{{url('/units')}}">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xxl font-weight-bold text-primary text-uppercase mb-1">
                                All Units</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6 mb-4 zoomIn">
        <a href="{{url('/cities')}}">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xxl font-weight-bold text-primary text-uppercase mb-1">
                                All Cities</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-md-6 mb-4 zoomIn">
        <a href="{{url('/regions')}}">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xxl font-weight-bold text-primary text-uppercase mb-1">
                                All Regions</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-md-6 mb-4 zoomIn">
        <a href="{{url('/contacts')}}">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xxl font-weight-bold text-primary text-uppercase mb-1">
                                All Requests</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>



    <!-- Content Row -->

    <div class="col-12">

        <div class="card shadow mb-4 zoomInUp">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Units</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Unit Name</th>
                                <th>Address</th>
                                <th>Region</th>
                                <th>City</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th></th>
                                <th></th>

                            
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Unit Name</th>
                                <th>Address</th>
                                <th>Region</th>
                                <th>City</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th></th>
                                <th></th>

                              
                            </tr>
                        </tfoot>
                        <tbody>


                            @foreach ($dataresponed as $i => $unit)
                                <tr>
                                    <td>{{ $unit['unit']->unit_name }}</td>
                                    <td>{{ $unit['unit']->unit_address }}</td>
                                    <td>{{ $unit['location'][0]->region_name }}</td>
                                    <td>{{ $unit['location'][0]->city_name }}</td>
                                    <td>{{ $unit['unit']->unit_price }}</td>
                                    <td>{{ $unit['unit']->unit_category }}</td>
                                   
                                    <td><a href="{{ route('updatephotoview', ['uid' => $unit['unit']->id]) }}" class="btn btn-primary">Photos</a></td>
                                    <td><a href="{{ route('updateview', ['uid' => $unit['unit']->id]) }}" class="btn btn-circle btn-warning">Edit</a></td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
       
      
    </div>

    
@endsection
