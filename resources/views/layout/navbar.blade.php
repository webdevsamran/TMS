<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">TMS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                @if (auth()->user()->role == 2 or auth()->user()->role == 1)
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('project') ? 'active' : '' }}"
                            href="{{ route('project') }}">Project</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('task') ? 'active' : '' }}"
                        href="{{ route('task') }}">Task</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('contribution') ? 'active' : '' }}"
                        href="{{ route('contribution') }}">Contribution</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('feedback') ? 'active' : '' }}"
                        href="{{ route('feedback') }}">Feedback</a>
                </li>
                @if (auth()->user()->role == 2)
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('user') ? 'active' : '' }}"
                            href="{{ route('user') }}">User</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('profile') ? 'active' : '' }}"
                        href="{{ route('profile') }}">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="{{ route('logout') }}">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
