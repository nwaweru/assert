<header class="app-header navbar">
    <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="{{ route('dashboard') }}"></a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="nav navbar-nav d-md-down-none">
        <li class="nav-item px-3">
            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        @permission('view-users')
        <li class="nav-item px-3">
            <a class="nav-link" href="{{ route('users.index') }}">Users</a>
        </li>
        @endpermission
        @permission('view-roles')
        <li class="nav-item px-3">
            <a class="nav-link" href="{{ route('roles.index') }}">Roles</a>
        </li>
        @endpermission
        @permission('view-asset-categories')
        <li class="nav-item px-3">
            <a class="nav-link" href="{{ route('asset_categories') }}">Categories</a>
        </li>
        @endpermission
        @permission('view-assets')
        <li class="nav-item px-3">
            <a class="nav-link" href="{{ route('assets.index') }}">Assets</a>
        </li>
        @endpermission
        @permission('view-requests')
        <li class="nav-item px-3">
            <a class="nav-link" href="{{ route('requests.index') }}">Requests</a>
        </li>
        @endpermission
        @permission('view-assignments')
        <li class="nav-item px-3">
            <a class="nav-link" href="{{ route('assignments.index') }}">Assignments</a>
        </li>
        @endpermission
    </ul>
    <ul class="nav navbar-nav ml-auto">
        @permission('create-user')
        <li class="nav-item px-3">
            <a class="nav-link" href="{{ route('users.create') }}">New User</a>
        </li>
        @endpermission
        @permission('create-role')
        <li class="nav-item px-3">
            <a class="nav-link" href="{{ route('roles.create') }}">New Role</a>
        </li>
        @endpermission
        @permission('create-asset')
        <li class="nav-item px-3">
            <a class="nav-link" href="{{ route('assets.create') }}">New Asset</a>
        </li>
        @endpermission
        @permission('create-request')
        <li class="nav-item px-3">
            <a class="nav-link" href="{{ route('requests.create') }}">New Request</a>
        </li>
        @endpermission
        @permission('create-assignment')
        <li class="nav-item px-3">
            <a class="nav-link" href="{{ route('assignments.create') }}">New Assignment</a>
        </li>
        @endpermission
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <img src="{{ Auth::user()->gravatar }}" class="img-avatar" alt="{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}">
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header text-center">
                    <strong>{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</strong>
                </div>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                    <i class="fa fa-lock"></i> {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
            </div>
        </li>
    </ul>
</header>