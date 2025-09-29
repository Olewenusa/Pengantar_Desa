@php
    $menus = [
        1 => [
            (object)[
                'title' => 'Dashboard',
                'path' => '/dashboard',
                'icon' => 'fas fa-fw fa-tachometer-alt',
            ],
            (object)[
                'title' => 'Penduduk',
                'path' => '/resident',
                'icon' => 'fas fa-fw fa-table',
            ],(object)[
                'title' => 'Daftar Akun',
                'path' => '/account_list',
                'icon' => 'fas fa-fw fa-user',
            ],(object)[
                'title' => 'Permintaan Akun',
                'path' => '/account-requests',
                'icon' => 'fas fa-fw fa-user',
            ],(object)[
                'title' => 'Surat Pengantar',
<<<<<<< HEAD
                'path' => '/pengantar',
                'icon' => 'fas fa-envelope-open-text',
            ],(object)[
                'title' => 'Dashboard Surat RT',
                'path' => '/pengantar/dashboard/rt',
                'icon' => 'fas fa-envelope-open-text',
            ],(object)[
                'title' => 'Dashboard Surat RW',
                'path' => '/pengantar/dashboard/rw',
=======
                'path' => 'pengantar',
>>>>>>> 233322a9c996a99db394807f7489572fb8c4a25a
                'icon' => 'fas fa-envelope-open-text',
            ]
        ],
        2 => [
            (object)[
                'title' => 'Dashboard',
                'path' => '/dashboard',
                'icon' => 'fas fa-fw fa-tachometer-alt',
            ],(object)[
                'title' => 'Surat Pengantar',
<<<<<<< HEAD
                'path' => '/pengantar',
=======
                'path' => 'pengantar',
>>>>>>> 233322a9c996a99db394807f7489572fb8c4a25a
                'icon' => 'fas fa-envelope-open-text',
            ]
],
3 => [
            (object)[
                'title' => 'Dashboard',
                'path' => '/dashboard',
                'icon' => 'fas fa-fw fa-tachometer-alt',
            ],(object)[
                'title' => 'Surat Pengantar',
                'path' => '/pengantar',
                'icon' => 'fas fa-envelope-open-text',
            ],(object)[
                'title' => 'Dashboard Surat RT',
                'path' => '/pengantar/dashboard/rt',
                'icon' => 'fas fa-envelope-open-text',
            ]
],
        4 => [
            (object)[
                'title' => 'Dashboard',
                'path' => '/dashboard',
                'icon' => 'fas fa-fw fa-tachometer-alt',
            ],(object)[
                'title' => 'Surat Pengantar',
<<<<<<< HEAD
                'path' => '/pengantar',
                'icon' => 'fas fa-envelope-open-text',
            ],(object)[
                'title' => 'Dashboard Surat RW',
                'path' => '/pengantar/dashboard/rw',
=======
                'path' => 'pengantar',
>>>>>>> 233322a9c996a99db394807f7489572fb8c4a25a
                'icon' => 'fas fa-envelope-open-text',
            ]
],
    ];
@endphp

@if(auth()->user()->role == 'Kepala RT' || auth()->user()->role == 'Admin')
<li class="nav-item">
    <a class="nav-link" href="{{ route('dashboard.rt') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard RT</span>
    </a>
</li>
@endif

@if(auth()->user()->role == 'Kepala RW' || auth()->user()->role == 'Admin')
<li class="nav-item">
    <a class="nav-link" href="{{ route('dashboard.rw') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard RW</span>
    </a>
</li>
@endif

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-home"></i> 
                </div>
                <div class="sidebar-brand-text mx-3">Desa Cimandala</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            {{-- <li class="nav-item {{ request()->is('dashboard*') ?  'active' : '' }}">
                <a class="nav-link" href="/dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li> --}}

            {{-- <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Manajemen Data
            </div> --}}

                 <!-- Nav Item - Tables -->

            @auth
                @foreach ($menus[auth()->user()->role_id] as $menu)
                    <li class="nav-item {{ request()->is(ltrim($menu->path, '/').'*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ $menu->path }}">
                            <i class="{{ $menu->icon }}"></i>
                            <span>{{ $menu->title }}</span>
                        </a>
                    </li>
                @endforeach
            @endauth

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
         

        </ul>