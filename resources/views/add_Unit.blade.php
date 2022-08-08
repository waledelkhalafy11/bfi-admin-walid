@extends('layouts.index')
@section('page_title')
    Select Location
@endsection
@section('units_active')
    nav-item active
@endsection
@section('pg_name')
    Select Unit Location
@endsection
@section('headaddons')
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }


        #regForm {
            background-color: #ffffff;
            margin: 100px auto;
            font-family: Raleway;
            padding: 40px;
            width: 70%;
            min-width: 300px;
            border-radius: 50px;
            -webkit-box-shadow: 5px 5px 15px 5px rgba(0, 0, 0, 0.16);
            box-shadow: 5px 5px 15px 5px rgba(0, 0, 0, 0.16);
        }

        #prevBtn {
            background-color: #bbbbbb;
        }

        /* Make circles that indicate the steps of the form: */
        .step {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbbbbb;
            border: none;
            border-radius: 50%;
            display: inline-block;
            opacity: 0.5;
        }

        .step.active {
            opacity: 1;
        }

        /* Mark the steps that are finished and valid: */
        .step.finish {
            background-color: #04AA6D;
        }

    </style>
@endsection

@section('content')
    <form class="bounceIn" id="regForm" method="POST" action="{{ route('addnew') }}">
        @csrf

        <h1>Please Select Unit Location :</h1>
        <!-- One "tab" for each step in the form: -->
        <div class="tab">Region:
            {{-- <p><input placeholder="First name..."name="fname"></p> --}}

            <select class="form form-select mt-2 p-2" name="region" onchange="cityName()" oninput="this.className = ''" id="region">
                <option disabled selected value="">Please select region</option>

                @foreach ($regions as $region)
                    <option value="{{ $region->id }}">{{ $region->region_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="tab">City:
            <select class="form form-select mt-2 p-2" name="city" onchange="distName()" oninput="this.className = ''" id="city">
                <option disabled selected value="">Please select city</option>


            </select>
        </div>
        <div class="tab">City:
            <select class="form form-select mt-2 p-2" name="district" oninput="this.className = ''" id="district">
                <option disabled selected value="">Please select District</option>


            </select>
        </div>

        <div style="overflow:auto;">
            <div style="float:right; margin-top:20px">
                <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>

            </div>
        </div>
        <!-- Circles which indicates the steps of the form: -->
        <div style="text-align:center;margin-top:40px;">
            <span class="step"></span>
            <span class="step"></span>
            <span class="step"></span>

        </div>
    </form>

    <script>
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            //... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Submit";

            } else {
                document.getElementById("nextBtn").innerHTML = "Next";
            }
            //... and run a function that will display the correct step indicator:
            fixStepIndicator(n)
        }

        function cityName() {

            const region_name = document.getElementById('region').value;
            var data = {!! json_encode($cities, JSON_HEX_TAG) !!}
            data.map(function(e) {
                if (region_name == e.region_id) {
                    var x = document.createElement("OPTION");
                    var y = document.getElementById('city');
                    x.innerHTML = e.city_name;
                    x.value = (e.id);
                    y.appendChild(x);

                }
            })

        }
        function distName() {

        const city_name = document.getElementById('city').value;
        var data = {!! json_encode($districts, JSON_HEX_TAG) !!}
        data.map(function(e) {
            if (city_name == e.city_id) {
                var x = document.createElement("OPTION");
                var y = document.getElementById('district');
                x.innerHTML = e.dist_name;
                x.value = (e.id);
                y.appendChild(x);

            }
        })

        }

        function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm()) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form...
            if (currentTab >= x.length) {
                // ... the form gets submitted:
                document.getElementById("regForm").submit();
                return true;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {
            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByTagName("select");
            // A loop that checks every input field in the current tab:
            for (i = 0; i < y.length; i++) {
                // If a field is empty...
                if (y[i].value == "") {
                    // add an "invalid" class to the field:
                    y[i].className += " invalid";
                    // and set the current valid status to false
                    valid = false;
                }
            }
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("step")[currentTab].className += " finish";
            }
            return valid; // return the valid status
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }
    </script>
@endsection
