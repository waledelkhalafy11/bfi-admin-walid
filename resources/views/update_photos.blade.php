@extends('layouts.index')
@section('page_title')
    Unit Photos
@endsection
@section('units_active')
    nav-item active
@endsection
@section('pg_name')
    Unit Photos
@endsection
@section('headaddons')
    <link href="{{asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <style>
        .imgcont {


            max-height: 10vh !important
        }

        img {
            max-width: 100%;
        }

    </style>
@endsection
@section('content')
@if (count($errors) > 0)
    <div class="col-12 " id="div__Error">
        @foreach ($errors->all() as $error)
        <div class="zoomIn col-12 alert alert-danger" >
            Can't Change Photo :
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
        <div class="zoomIn col-12 alert alert-success" id="message">{{ Session::get('message') }}</div>
        <script>
            let messageeDiv = document.getElementById('message')
            setInterval(function() {
                messageeDiv.style.display = "none"
            }, 2000);
        </script>
    @endif
    <div class="col-12 mb-4">
        <div class="px-2">

            <a href="{{ route('updateunitPhotoView', ['uid' => $uid]) }}" class="px-4 btn  btn-success">Add New Photos</a>
        </div>
    </div>
    @foreach ($photos as $photo)
        <div class="col-xl-3 col-md-6 mb-4 card__units_photos">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2 imgcont overflow-hidden img__container ">

                            <img class="w-full h-full object-cover" src="{{ $photo->unit_image_url }}" alt="">
                        </div>

                        <div class="row mt-2 cardbtns">
                            <div class="px-2">


                            </div>
                            <div class="px-2 col-12 unit__btns">


                                <button type="button" class="px-4 btn btn-danger"
                                    onclick="deletinPhoto({{ $photo->id }})" data-toggle="modal"
                                    data-target="#deleteModal">Remove</button>

                                <button type="button" onclick="changingPhoto({{ $photo->id }})" data-toggle="modal"
                                    data-target="#changeModal"
                                    class="px-4 btn btn-primary">Change</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Delete Photo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('deletePhoto') }}">
                    @csrf
                    <div class="modal-body">
                        Are You Sure Want to Delete Photo !?
                        <input hidden id="modalDeleteInput" name="photo_id" type="number">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        <button type="submit"  class="btn  btn-danger">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="changeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Insert the New Photo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('changePhoto') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="file" accept="image/png, image/gif, image/jpeg" class="form-control" id="file" name="image">
                        <input hidden id="modalChangeInput" name="photo_id" type="number">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit"  class="btn  btn-danger">Change Photo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function deletinPhoto(id) {
            document.getElementById('modalDeleteInput').value = id
        }
        function changingPhoto(id) {
            document.getElementById('modalChangeInput').value = id
        }
    </script>
@endsection
