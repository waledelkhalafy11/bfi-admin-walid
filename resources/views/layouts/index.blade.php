@include('layouts.head')

<body id="page-top">

    <div id="wrapper">


        @include('layouts.sidebar')



        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">


                @include('layouts.topbar')

                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">@yield('pg_name')</h1>
                      
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        @yield('content')
                    </div>
                </div>


            </div>
        </div>
    </div>

    @include('layouts.scripts')

</body>

</html>
