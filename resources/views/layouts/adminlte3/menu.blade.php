
<ul class="nav nav-pills nav-sidebar flex-column " data-widget="treeview" role="menu" data-accordion="false">

    {{--    <li class="nav-header">MULTI LEVEL EXAMPLE</li>--}}


    <li class="nav-item">
        <a href="{{ route('admin.boss.index') }}" class="nav-link">
            <i class="nav-icon far fa-circle text-warning"></i>
            <p class="text-gray-300">Boss</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('admin.user.index') }}" class="nav-link">
            <i class="nav-icon far fa-circle text-warning"></i>
            <p class="text-gray-300">User</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('admin.voucher.index') }}" class="nav-link">
            <i class="nav-icon far fa-circle text-warning"></i>
            <p class="text-gray-300">Voucher</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('admin.registerBoss.index') }}" class="nav-link">
            <i class="nav-icon far fa-circle text-warning"></i>
            <p class="text-gray-300">Register Boss</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('admin.reported.index') }}" class="nav-link">
            <i class="nav-icon far fa-circle text-warning"></i>
            <p class="text-gray-300">Reported Rating</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('admin.logout') }}" class="nav-link">
            <i class="nav-icon far fa-circle text-info"></i>
            <p class="text-gray-300">Logout</p>
        </a>
    </li>
</ul>
