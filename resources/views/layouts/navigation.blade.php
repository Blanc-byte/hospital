<nav class="nav-container">
    <style>
        .nav-container {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 200px;
            background-color: #B2F5E1;
            border-right: 1px solid #e2e8f0;
            padding: 16px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .nav-links {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .nav-link {
            color: #000000;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 4px;
            transition: color 0.2s, background-color 0.2s;
        }

        .nav-link:hover {
            color: #000000;
            background-color: #51a8ff;
        }

        .nav-link.active {
            color: #2d3748;
            background-color: #ffffff;
        }

        .logout-form {
            display: inline;
        }
    </style>

    <!-- Navigation Menu -->
    <div class="nav-links">
        <!-- Profile -->
        <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            {{ __('Profile') }}
        </a>

        <!-- Appointments -->
        <a href="{{ route('admin.appointments') }}" class="nav-link {{ request()->routeIs('admin.appointments') ? 'active' : '' }}">
            {{ __('Appointments') }}
        </a>

        <!-- Doctors -->
        <a href="{{ route('admin.doctors') }}" class="nav-link {{ request()->routeIs('admin.doctors') ? 'active' : '' }}">
            {{ __('Doctors') }}
        </a>

        <!-- HISTORY -->
        <a href="{{ route('admin.history') }}" class="nav-link {{ request()->routeIs('admin.history') ? 'active' : '' }}">
            {{ __('History') }}
        </a>

        <!-- Users -->
        <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
            {{ __('Users') }}
        </a>

        <!-- Log Out -->
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); this.closest('form').submit();">
                {{ __('Log Out') }}
            </a>
        </form>
    </div>
</nav>
