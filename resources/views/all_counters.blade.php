@extends('layouts.index')

@section('page_title')
    Counters
@endsection
@section('website_active')
    nav-item active
@endsection
@section('pg_name')
    Counters Section
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
    @foreach ($counters as $i => $counter)
        <div class="col-xl-3 card__units col-md-6 mb-4 zoomIn">
            <div class="card border-left-primary shadow c__cards py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-12 mr-2">
                            <div class="text-xxl font-weight-bold text-primary text-uppercase mb-1">
                                {{ $counter->count_name }}
                            </div>

                        </div>

                        <div class="row mt-2">
                            <div class="px-2 col-12">
                                {{ $counter->num_count }}

                            </div>


                            <div class="col-12 px-2 Allunit__btns">
                                <a href="{{ route('updateCountersView', ['countid' => $counter->id]) }}"
                                    class="px-4 btn btn-warning ">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
