
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

    {{--    <li class="nav-header">MULTI LEVEL EXAMPLE</li>--}}


    <li class="nav-item">
        <a href="{{ route('boss.yard.index') }}" class="nav-link">
            <i class="nav-icon far fa-circle text-warning"></i>
            <p class="text-gray-300">Yard</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('boss.yard_schedule.index') }}" class="nav-link">
            <i class="nav-icon far fa-circle text-warning"></i>
            <p class="text-gray-300">Yard Schedule</p>
        </a>
    </li>


    <li class="nav-item">
        <a href="{{ route('boss.image.index') }}" class="nav-link">
            <i class="nav-icon far fa-circle text-warning"></i>
            <p class="text-gray-300">General Images</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('boss.yard.image.index') }}" class="nav-link">
            <i class="nav-icon far fa-circle text-warning"></i>
            <p class="text-gray-300">Yards Images</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('boss.logout') }}" class="nav-link">
            <i class="nav-icon far fa-circle text-info"></i>
            <p class="text-gray-300">Logout</p>
        </a>
    </li>
</ul>
