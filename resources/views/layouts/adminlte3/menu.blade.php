
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

    {{--    <li class="nav-header">MULTI LEVEL EXAMPLE</li>--}}


    <li class="nav-item">
        <a href="{{ route('admin.user.index') }}" class="nav-link">
            <i class="nav-icon far fa-circle text-warning"></i>
            <p>User</p>
        </a>
    </li>


    <li class="nav-item">
        <a href="{{ route('logout') }}" class="nav-link">
            <i class="nav-icon far fa-circle text-info"></i>
            <p>Logout</p>
        </a>
    </li>
</ul>
