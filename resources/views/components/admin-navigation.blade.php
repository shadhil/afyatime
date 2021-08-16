@props(['mobile', 'desky'])

<div id="navbar2" class="app-navbar horizontal horizontal-vertical {{ $mobile }} {{ $desky }}">
    <div class="navbar-wrap">

        <button class="no-style navbar-toggle navbar-close icofont-close-line d-lg-none"></button>

        <div class="app-logo">
            <div class="logo-wrap">
                <img src="{{ asset('assets/img/logo.svg') }}" alt="" width="147" height="33" class="logo-img">
            </div>
        </div>

        <div class="main-menu">
            <nav class="main-menu-wrap">
                <ul class="menu-ul">
                    <li class="menu-item {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}">
                        <a class="item-link" href="{{ route('admin.dashboard') }}">
                            <span class="link-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.organizations*') ? 'active' : '' }}">
                        <a class="item-link" href="{{ route('admin.organizations') }}">
                            <span class="link-text">Organizations</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="item-link" href="#">
                            <span class="link-text">Prescribers</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="item-link" href="#">
                            <span class="link-text">Patients</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="item-link" href="#">
                            <span class="link-text">Regions</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="item-link" href="#">
                            <span class="link-text">Admins</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>


        <div class="navbar-skeleton vertical">
            <div class="top-part">
                <div class="sk-logo bg animated-bg"></div>
                <div class="sk-menu">
                    <span class="sk-menu-item menu-header bg-1 animated-bg"></span>
                    <span class="sk-menu-item bg animated-bg w-75"></span>
                    <span class="sk-menu-item bg animated-bg w-80"></span>
                    <span class="sk-menu-item bg animated-bg w-50"></span>
                    <span class="sk-menu-item bg animated-bg w-75"></span>
                    <span class="sk-menu-item bg animated-bg w-50"></span>
                    <span class="sk-menu-item bg animated-bg w-60"></span>
                </div>
                <div class="sk-menu">
                    <span class="sk-menu-item menu-header bg-1 animated-bg"></span>
                    <span class="sk-menu-item bg animated-bg w-60"></span>
                    <span class="sk-menu-item bg animated-bg w-40"></span>
                    <span class="sk-menu-item bg animated-bg w-60"></span>
                    <span class="sk-menu-item bg animated-bg w-40"></span>
                    <span class="sk-menu-item bg animated-bg w-40"></span>
                    <span class="sk-menu-item bg animated-bg w-40"></span>
                    <span class="sk-menu-item bg animated-bg w-40"></span>
                </div>
                <div class="sk-menu">
                    <span class="sk-menu-item menu-header bg-1 animated-bg"></span>
                    <span class="sk-menu-item bg animated-bg w-60"></span>
                    <span class="sk-menu-item bg animated-bg w-50"></span>
                </div>
                <div class="sk-button animated-bg w-90"></div>
            </div>

            <div class="bottom-part">
                <div class="sk-menu">
                    <span class="sk-menu-item bg-1 animated-bg w-60"></span>
                    <span class="sk-menu-item bg-1 animated-bg w-80"></span>
                </div>
            </div>

            <div class="horizontal-menu">
                <span class="sk-menu-item bg animated-bg"></span>
                <span class="sk-menu-item bg animated-bg"></span>
                <span class="sk-menu-item bg animated-bg"></span>
                <span class="sk-menu-item bg animated-bg"></span>
                <span class="sk-menu-item bg animated-bg"></span>
                <span class="sk-menu-item bg animated-bg"></span>
            </div>
        </div>

    </div>
</div>
