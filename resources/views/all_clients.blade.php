@extends('layouts.index')

@section('page_title')
    Clients
@endsection
@section('website_active')
    nav-item active
@endsection
@section('pg_name')
    Clients Section
    <button type="button" class="ml-4 btn btn-success" data-toggle="modal" data-target="#addClientModal">Add New
        Client</button>
@endsection
@section('content')
    @if (Session::get('message'))
        <div class="col-12 alert alert-danger" id="message">{{ Session::get('message') }}</div>
        <script>
          let messageeDiv = document.getElementById('message')
            setInterval(function() {
            let messageeDiv = document.getElementById('message')
              messageeDiv.classList.add('zoomOut')
              setInterval(function() {
                messageeDiv.style.display = "none"
                
              },400)
            }, 2000);
        </script>
    @endif
    @if (count($errors) > 0)
    <div class="col-12 " id="div__Error">
        @foreach ($errors->all() as $error)
        <div class="col-12 alert alert-danger" >
            Can't add Client :
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
            }, 3000);
        </script>
    @endif
    @isset($clientsData)
        @foreach ($clientsData as $i => $client)
            <div class="col-xl-3 card__units col-md-6 mb-4 zoomIn">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col-12 mr-2">
                                <div class="text-xxl font-weight-bold text-primary text-uppercase mb-1">
                                    {{ $client->client_name }}
                                </div>
                                <div class="px-2 col-12 ">

                                    <img class="w-50 h-50" src="https://api.bfi-re.com/{{$client->icon_image_url}}" />
                                </div>
                            </div>

                            <div class="row mt-2 cardbtns">
                                


                                <div class="col-12 px-2 Allunit__btns">
                                    <button type="button" class="px-4 btn btn-primary"
                                        onclick="changingClientData({{ $client->id }} ,{{ json_encode($client->client_name) }} )"
                                        data-toggle="modal" data-target="#changeClientModal">Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endisset

    <div class="modal fade" id="addClientModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Insert the New Client</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('addClient') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <label for="exampleFormControlInput1" class="form-label">Client Name</label>
                        <input type="text" class="form-control" id="place_nameModal" name="client_name"
                            placeholder="Add Client Name">

                        <label for="exampleFormControlInput1" class="form-label">Logo Photo</label>
                        <input type="file" accept="image/png, image/svg, image/jpeg" class="form-control" id="file" name="image">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn  btn-success">Add Client</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="changeClientModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Insert the New Photo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('updateClients') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <label for="exampleFormControlInput1" class="form-label">Client Name</label>
                    <input type="text" class="form-control" id="clientNameModal" name="client_name">

                    <label for="exampleFormControlInput1" class="form-label">New Logo Photo</label>
                    <input type="file" accept="image/png, image/gif, image/jpeg" class="form-control" id="file" name="image">
                    <input hidden id="clientIdModal" name="client_id" type="number">
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
        function changingClientData(id, name) {
            document.getElementById('clientNameModal').value = name;
            document.getElementById('clientIdModal').value = id;
        }
    </script>
@endsection
