@extends('layouts.index')

@section('page_title')
    Explore
@endsection
@section('website_active')
    nav-item active
@endsection
@section('pg_name')
    All Explore Cards
@endsection
@section('content')
    @if (Session::get('message'))
        <div class="col-12 alert alert-success" id="message">{{ Session::get('message') }}</div>
        <script>
            let messageeDiv = document.getElementById('message')
            setInterval(function() {
                messageeDiv.style.display = "none"
            }, 2000);
        </script>
    @endif
    @if (count($errors) > 0)
    <div class="col-12 " id="div__Error">
        @foreach ($errors->all() as $error)
        <div class="zoomIn col-12 alert alert-danger" >
            Can't Edit Card : 
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
    @foreach ($exploreCards as $i => $card)
        <div class="col-xl-3 card__units col-md-6 mb-4 card__units_photos zoomIn">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-12 mr-2">
                            <div class="text-xxl font-weight-bold text-primary text-uppercase mb-1">
                                {{ $card->place_name }}
                            </div>
                            <div class="px-2 col-12 overflow-hidden expimg__container">

                                <img class="w-full h-full object-cover" src="{{ $card->card_image_url }}" />
                            </div>

                        </div>

                        <div class="row mt-2 cardbtns">


                            <div class="col-12 px-2 unit__btns">

                                <button type="button" class="px-4 btn btn-primary"
                                    onclick="changingExplorePhoto({{ $card->id }} ,{{ json_encode($card->place_name) }} )"
                                    data-toggle="modal" data-target="#changeExploreModal">Edit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="modal fade" id="changeExploreModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Insert the New Photo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('updateExplore') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <label for="exampleFormControlInput1" class="form-label">Place Name</label>
                        <input type="text" class="form-control" id="place_nameModal" name="place_name">

                        <label for="exampleFormControlInput1" class="form-label">New Photo</label>
                        <input type="file" accept="image/png, image/gif, image/jpeg" class="form-control" id="file" name="image">
                        <input hidden id="modalChangeExploreInput" name="card_id" type="number">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn  btn-success">Submit Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function changingExplorePhoto(id, name) {
            document.getElementById('place_nameModal').value = name;
            document.getElementById('modalChangeExploreInput').value = id;
        }
    </script>
@endsection
