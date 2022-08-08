@extends('layouts.index')
@section('page_title')
{{ $heroCard->card_title }}
@endsection
@section('website_active')
    nav-item active
@endsection
@section('pg_name')
    Update Card Data
@endsection
@section('headaddons')
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

    <style>

        ::selection {
            color: #fff;
            background-color: #000;
        }
        ::-moz-selection {
            color: #fff;
            background-color: #000;
        }

        [type="radio"]:checked,
        [type="radio"]:not(:checked){
            position: absolute;
            left: -9999px;
            width: 0;
            height: 0;
            visibility: hidden;
        }


        .checkbox-tools:checked + label,
        .checkbox-tools:not(:checked) + label{
            position: relative;
            display: inline-block;
            padding: 5px;
            width: 80px;
            font-size: 14px;
            line-height: 20px;
            letter-spacing: 1px;
            margin: 0 auto;
            margin-left: 5px;
            margin-right: 5px;
            margin-bottom: 10px;
            text-align: center;
            border-radius: 2px;
            overflow: hidden;
            cursor: pointer;
            text-transform: uppercase;
            color: #fff;
            -webkit-transition: all 300ms linear;
            transition: all 300ms linear; 
        }
        .checkbox-tools:not(:checked) + label{
            background-color: #fff;
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
        }
        .checkbox-tools:checked + label{
            background-color: transparent;
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
            border: #04AA6D solid 3px ;
        }
        .checkbox-tools:not(:checked) + label:hover{
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }
        .checkbox-tools:checked + label::before,
        .checkbox-tools:not(:checked) + label::before{
            position: absolute;
            content: '';
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 4px;
            background: linear-gradient(45deg, #000000, #ab26aa) !important;
            z-index: -1;
        }
        .checkbox-tools:checked + label .uil,
        .checkbox-tools:not(:checked) + label .uil{
            font-size: 24px;
            line-height: 24px;
            display: block;
            padding-bottom: 10px;
        }

        .checkbox-tools:not(:checked) + label{
            background-color: #f0eff3;
            color: #1f2029;
            box-shadow: 0 1x 4px 0 rgba(0, 0, 0, 0.05);
        }

        .checkbox-tools:not(:checked) + label img{
            filter:blur(0.6px);
        }

        label img {
        width: 70px;
        border-radius: 2px;
        }
        .iconsCheck{
            background: #fff;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.068);

        }
    </style>
@endsection

@section('content')
@if (count($errors) > 0)
    <div class="col-12 " id="div__Error">
        @foreach ($errors->all() as $error)
        <div class="zoomIn col-12 alert alert-danger" >
            Can't Update Card :
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
    <div class="col-12">

        <form action="{{ route('updateHeroCards') }}" method="POST">
            @csrf

            <label for="exampleFormControlInput1" class="form-label">Card Name</label>
            <input type="text" class="form-control" id="card_title" value="{{ $heroCard->card_title }}" name="card_title"
                placeholder="Add Title">
                
                
                <label for="exampleFormControlInput1" class="form-label mt-5">Chose Icon</label>

                <div class="col-12  iconsCheck">

                @foreach ($icons as $icon)


                @if ($icon->id == $heroCard->icon_id)
                <input class="checkbox-tools" value="{{$icon->id}}" type="radio" name="icon_id" id="tool-{{$icon->id}}" checked>
                <label class="for-checkbox-tools" for="tool-{{$icon->id}}">
                    <img src="{{$icon->card_icon_url}}"
                        class="img-fluid" alt="">
                </label>
                @else
                <input class="checkbox-tools" value="{{$icon->id}}" type="radio" name="icon_id" id="tool-{{$icon->id}}">
                <label class="for-checkbox-tools" for="tool-{{$icon->id}}">
                    <img src="{{$icon->card_icon_url}}"
                        class="img-fluid" alt="">
                </label>
                @endif
               
                @endforeach
                
            </div>

            <input hidden type="text" value="{{ $heroCard->id }}" id="card_id" name="card_id">
            <label for="exampleFormControlInput1" class="form-label mt-4">Card Description</label>

            <textarea name="card_desciption" id="card_desciption" cols="30" rows="10">{{ $heroCard->card_desciption }}</textarea>

            <button style="margin: 20px auto" class="btn btn-success" type="submit">Submit Updates</button>
        </form>
    </div>
    </div>
@endsection
