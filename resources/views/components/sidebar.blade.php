<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <span class="sidebar-brand d-flex align-items-center justify-content-center" >
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </span>
    <x-nav-link href="/admin" :active="request()->is('admin')">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
    </x-nav-link>
    @php
        $user = Auth::guard('admin')->check() ? Auth::guard('admin')->user() :
                (Auth::guard('web')->check() ? Auth::guard('web')->user() : null);
    @endphp

    @if ($user)
        @if ($user->isAdmin())
            @if ($user->hasPermission('view.admins'))
                <x-nav-link href="{{ route('admins.list') }}" :active="request()->is('admins*')">
                    <i class="fas fa-fw fa-users-cog"></i>
                    <span>Admins</span>
                </x-nav-link>
            @endif
            @if ($user->hasPermission('view.all.users'))
                <x-nav-link href="{{ route('users.list') }}" :active="request()->is('users*')">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Users</span>
                </x-nav-link>
            @endif
        @elseif ($user->isUser())
            <x-nav-link href="{{ route('tasks.index') }}" :active="request()->is('tasks*')">
                <i class="fas fa-fw fa-tasks"></i>
                <span>Tasks</span>
            </x-nav-link>
        @endif
    @endif
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
