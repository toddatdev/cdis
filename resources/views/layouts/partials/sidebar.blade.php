<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img alt="image" class="rounded-circle d-md-none" src="{{asset('img/profile_small.jpg')}}"/>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">{{$user->name  }}</span>
                        <span class="text-muted text-xs block">{{ucfirst($user->role)}}<b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="dropdown-item" href="{{route('settings')}}">Profile</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="/logout">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    CDIS
                </div>
            </li>
            <li class="{{request()->routeIs('dashboard') ? 'active' : ''}}">
                <a href="{{route('dashboard')}}"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
            </li>
            <li class="{{ request()->routeIs('projects.show') || request()->routeIs('projects.edit')? 'active' : ''}}">
                <a href="{{ route('projects.show') }}"><i class="fa fa-save"></i> <span
                            class="nav-label">New Project</span></a>
            </li>

            <li class="{{request()->routeIs('projects.search.index') ? 'active' : ''}}">
                <a href="{{ route('projects.search.index') }}"><i class="fa fa-search"></i> <span
                            class="nav-label">Search Projects</span></a>
            </li>
            <li class="{{request()->routeIs('letter.show') ? 'active' : ''}}">
                <a href="{{route('letter.show')}}"><i class="fa fa-envelope-open"></i> <span class="nav-label">Generate Letters</span></a>
            </li>
            <li class="{{request()->routeIs('site.inspection') ? 'active' : ''}}">
                <a href="{{route('site.inspection')}}"><i class="fa fa-search-plus"></i> <span class="nav-label">Site Inspection</span></a>
            </li>
            <li class="{{request()->routeIs('admin') ? 'active' : ''}}">
                {{--                <a href="{{route('admin')}}"><i class="fa fa-save"></i> <span class="nav-label">Admin Panel</span></a>--}}
            </li>
            <li class="{{request()->routeIs('reports') ? 'active' : ''}}">
                <a href="{{route('reports')}}"><i class="fa fa-files-o"></i> <span class="nav-label">Reports</span></a>
            </li>
            <li class="{{request()->routeIs('contacts.search.index') || request()->routeIs('reviewers.signatures') ? 'active' : ''}}">
                <a href=""><i class="fa fa-cogs"></i> <span class="nav-label">Admin Panel</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse " aria-expanded="true" style="">
                    <li class=" {{request()->routeIs('contacts.search.index') ? 'active' : ''}}">
                        <a href="{{route('contacts.search.index')}}">Manage Contacts</a>
                    </li>
                    <li class="{{request()->routeIs('reviewers.signatures') ? 'active' : ''}}">
                        <a href="{{route('reviewers.signatures')}}" class="">Manage Signature</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="/logout"><i class="fa fa-sign-out"></i> <span class="nav-label">Logout</span></a>
            </li>
        </ul>
    </div>
</nav>
