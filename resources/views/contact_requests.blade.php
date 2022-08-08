@extends('layouts.index')
@section('contacts_active')
    nav-item active
@endsection
@section('page_title')
    Contacts
@endsection
@section('headaddons')
    <link href="{{asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection
@section('pg_name')
    Contact Requeste
@endsection
@section('content')
    <!-- Content Row -->

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
    <!-- Area Chart -->
    <div class="col-xl-12 col-lg-12 zoomInUp">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Contacts</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>City</th>
                                <th>Message</th>
                                <th>Time</th>
                                <th></th>

                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>City</th>
                                <th>Message</th>
                                <th>Time</th>
                                <th></th>

                            </tr>
                        </tfoot>
                        <tbody>



                            @foreach ($allContacts as $i => $contact)
                                <tr>
                                    <td>{{ $contact->name }}</td>
                                    <td>{{ $contact->phone }}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ $contact->city }}</td>
                                    <td>{{ $contact->message }}</td>
                                    <td>{{ $contact->created_at }}</td>
                                    <td><button id='{{ $contact->id }}' data-message="{{ $contact->message }}"
                                            onclick="showMessage({{ $contact->id }})" data-toggle="modal"
                                            data-target="#questionModal" class="p-2 btn  btn-success">Show Message</button>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="questionModal" tabindex="-1" role="dialog" aria-labelledby="questionModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div id="modalBodymessage" class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>

            </div>
        </div>
    </div>
    <!-- Pie Chart -->


    <script>
        function showMessage(e) {
            let message = document.getElementById(e).dataset.message;
            document.getElementById('modalBodymessage').innerHTML = message;
        }
    </script>
@endsection
