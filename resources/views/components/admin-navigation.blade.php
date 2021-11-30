@props(['mobile'])

<div id="navbar2" class="app-navbar horizontal horizontal-vertical {{ $mobile ?? '' }}">
    <div class="navbar-wrap">

        <button class="no-style navbar-toggle navbar-close icofont-close-line d-lg-none"></button>

        <div class="app-logo">
            <div class="logo-wrap">
                <img src="{{ asset('assets/img/logo.png') }}" alt="" width="147" height="33" class="logo-img">
            </div>
        </div>

        <div class="main-menu">
            <nav class="main-menu-wrap">
                <ul class="menu-ul">
                    <li class="menu-item {{ request()->routeIs('admin.organizations*') ? 'active' : '' }}">
                        <a class="item-link" href="{{ route('admin.organizations') }}">
                            <span class="link-text">Home</span>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.appointments*') ? 'active' : '' }}">
                        <a class="item-link" href="{{ route('admin.appointments.all',) }}">
                            <span class="link-text">Appointments</span>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.regions*') ? 'active' : '' }}">
                        <a class="item-link" href="{{ route('admin.regions') }}">
                            <span class="link-text">Regions</span>
                        </a>
                    </li>
                    <li class="menu-item has-sub {{ request()->routeIs('admin.types*') ? 'active' : '' }}">
                        <spam class="item-link" href="#">
                            <span class="link-text">Types</span>
                            <span class="link-caret icofont-thin-right"></span>
                        </spam>
                        <ul class="sub">
                            <li class="menu-item {{ request()->routeIs('admin.types.org') ? 'active' : '' }}">
                                <a class="item-link" href="{{ route('admin.types.org') }}"><span
                                        class="link-text">Organization
                                        Types</span></a>
                            </li>
                            <li class="menu-item {{ request()->routeIs('admin.types.prescriber') ? 'active' : '' }}">
                                <a class="item-link" href="{{ route('admin.types.prescriber') }}"><span
                                        class="link-text">Prescriber
                                        Types</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.admins*') ? 'active' : '' }}">
                        <a class="item-link" href="{{ route('admin.admins') }}">
                            <span class="link-text">Admins</span>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                        <a class="item-link" href="{{ route('admin.users') }}">
                            <span class="link-text">Users</span>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.invoices*') ? 'active' : '' }}">
                        <a class="item-link" href="{{ route('admin.invoices') }}">
                            <span class="link-text">Invoices</span>
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
