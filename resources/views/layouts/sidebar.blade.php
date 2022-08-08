<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/home') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">BFI Admin <sup>1.0</sup>

        </div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="@yield('home_active', 'nav-item')">
        <a class="nav-link" href="{{ url('/home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Home</span></a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Units
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="@yield('units_active', 'nav-item')">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-fw fa-building"></i>
            <span>Units</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Unit Data:</h6>

                <a class="collapse-item" href="{{ url('/units') }}">Show Units</a>
                <a class="collapse-item" href="{{ url('/addunit') }}">Add New Unit</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="@yield('locations_active', 'nav-item')">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-location-arrow"></i>
            <span>Locations</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Location customization :</h6>
                <!-- <a class="collapse-item" href="{{ url('regions/add') }}">Add New Region</a> -->
                <a class="collapse-item" href="{{ url('regions') }}">Regions</a>
                <!-- <a class="collapse-item" data-toggle="modal" data-target="#RegionModal">Add New City</a> -->
                <a class="collapse-item" href="{{ url('/cities') }}">Cities</a>
                <a class="collapse-item" href="{{ url('/districts') }}">Districts</a>
              
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Website
    </div>



    <li class="@yield('website_active', 'nav-item')">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseWebsite"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-palette"></i>
            <span>Website Setttings</span>
        </a>
        <div id="collapseWebsite" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Web customization :</h6>

                <a class="collapse-item" href="{{ url('/web/hero-cards') }}">Hero Cards</a>

                <a class="collapse-item" href="{{ url('/web/explore') }}">Explore Section</a>

                <a class="collapse-item" href="{{ url('/web/counters') }}">Counters Section</a>
                <a class="collapse-item" href="{{ url('/web/clients') }}">Clients Section</a>

            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Contacts
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="@yield('contacts_active', 'nav-item')">
        <a class="nav-link" href="{{ url('/contacts') }}">
            <i class="fas fa-envelope fa-fw"></i>
            <span>Contact Requests</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>

<div class="modal fade" id="RegionModal" tabindex="-1" role="dialog" aria-labelledby="questionModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">City Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('addcity_select') }}">
                @csrf
                <div class="modal-body">

                    <select name="region_id" class="form-control">
                        <option selected disabled>Select Region</option>
                        @foreach (\App\Models\Region::all() as $region)
                            <option value="{{ $region->id }}">{{ $region->region_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add City</button>
                </div>
            </form>
        </div>
    </div>
</div>
