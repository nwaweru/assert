<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-fw fa-tachometer-alt"></i> Dashboard</a>
            </li>
            @permission('view-users')
            <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link"><i class="fas fa-users"></i> Users</a>
            </li>
            @endpermission
            @permission('view-roles')
            <li class="nav-item">
                <a href="{{ route('roles.index') }}" class="nav-link"><i class="fas fa-wrench"></i> Roles</a>
            </li>
            @endpermission
            @permission('view-asset-categories')
            <li class="nav-item">
                <a href="{{ route('asset_categories') }}" class="nav-link"><i class="fas fa-certificate"></i> Categories</a>
            </li>
            @endpermission
            @permission('view-assets')
            <li class="nav-item">
                <a href="{{ route('assets.index') }}" class="nav-link"><i class="fas fa-truck"></i> Assets</a>
            </li>
            @endpermission
            @permission('view-assignments')
            <li class="nav-item">
                <a href="{{ route('assignments.index') }}" class="nav-link"><i class="fas fa-hands-helping"></i> Assignments</a>
            </li>
            @endpermission
            @permission('view-requests')
            <li class="nav-item">
                <a href="{{ route('requests.index') }}" class="nav-link"><i class="fas fa-tasks"></i> Requests</a>
            </li>
            @endpermission
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>