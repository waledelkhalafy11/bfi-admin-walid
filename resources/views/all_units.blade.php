@extends('layouts.index')

@section('page_title')
    Units
@endsection
@section('units_active')
    nav-item active
@endsection
@section('pg_name')
    All Units

    <a class="ml-4 btn btn-success" href="{{ url('/addunit') }}">Add New Unit</a>
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
        <div class="col-12 alert alert-success" id="message">{{ Session::get('message') }}</div>
        <script>
            let messageeDiv = document.getElementById('message')
            setInterval(function() {
                messageeDiv.style.display = "none"
            }, 2000);
        </script>
    @endif
    @foreach ($dataresponed as $i => $unit)
        <div class="col-xl-3 card__units col-md-6 mb-4 zoomIn">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-12 mr-2">
                            <div class="text-xxl font-weight-bold text-primary text-uppercase mb-1">
                                {{ $unit['unit']->unit_name }}
                            </div>
                            <div>{{ $unit['unit']->unit_address }}</div>
                        </div>
                        <div class="col-12 ">
                            <div>{{ $unit['location'][0]->region_name }}</div>
                            <div>{{ $unit['location'][0]->city_name }}</div>
                        </div>
                        <div class="row mt-2 cardbtns">
                            <div class="px-2">

                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $unit['unit']->unit_price }} LE
                                </div>
                            </div>

                            <hr black width="100">

                            <div class="col-12 px-2 Allunit__btns">

                                <a href="{{ route('updatephotoview', ['uid' => $unit['unit']->id]) }}"
                                    class="px-4 btn  btn-primary ">Photos</a>

                                <a href="{{ route('updateview', ['uid' => $unit['unit']->id]) }}"
                                    class="px-4 btn btn-warning ">Edit</a>

                                <button type="button" class="px-4 btn btn-danger" onclick="deletinUnit({ $unit->id })"
                                    data-toggle="modal" data-target="#deleteModal">Delete</button>
                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Delete unit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('deleteunit', ['uid' => $unit['unit']->id]) }}">
                    @csrf
                    <div class="modal-body">
                        Are You Sure Want to Delete unit !?
                        <input hidden id="modalDeleteInput" name="unnit_id" type="number">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        <button type="submit" class="btn  btn-danger">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach




   
    <script>
        function deletinUnit(id) {
            document.getElementById('modalDeleteInput').value = id
        }
    </script>
@endsection
