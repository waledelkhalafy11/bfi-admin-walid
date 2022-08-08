@extends('layouts.index')

@section('page_title')
    Hero Cards
@endsection
@section('website_active')
    nav-item active
@endsection
@section('pg_name')
    All Hero Cards
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
    @foreach ($heroCards as $i => $card)
        <div class="col-xl-3 card__units col-md-6 mb-4 zoomIn">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-12 mr-2">
                            <div class="text-xxl font-weight-bold text-primary text-uppercase mb-1">
                                {{ $card->card_title }}
                            </div>
                            <div>{{ $card->card_desciption }}</div>
                            @foreach ($icons as $icon)
    @if ($icon->id == $card->icon_id )
    <img style="margin-left: 50% !important" width="20%" src="{{ asset($icon->card_icon_url) }}" />
        
    @endif
@endforeach
                        </div>

                        <div class="row mt-2 cardbtns">
                            <div class="px-2 col-12">

                            </div>


                            <div class="col-12 px-2 Allunit__btns">
                                <a href="{{ route('updateHeroCardsView', ['cardid' => $card->id]) }}"
                                    class="px-4 btn btn-warning ">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
