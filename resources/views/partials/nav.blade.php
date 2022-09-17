<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('about') ? 'active' : '' }}"
                       href="{{ route('page', 'about') }}">{{
                        __('About') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('services') ? 'active' : '' }}"
                       href="{{ route('page', 'services') }}">{{
                        __('Services') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}"
                       href="{{ route('page', 'contact') }}">{{
                        __('Contact') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('search') ? 'active' : '' }}" href="{{ route('search') }}">{{
                        __('Search Sign')
                        }}</a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest

                {{-- Login Link --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                {{-- Login Link --}}

                {{-- Registration Link --}}
                {{-- @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif --}}
                {{-- Registration Link --}}

                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    {{-- DEBUG --}}
                    {{-- @foreach (Auth::user()->roles as $role)
                    {{ $role->name }} ->
                    @foreach ($role->permissions as $perm)
                    {{ $perm->name }} |
                    @endforeach
                    <br>
                    @endforeach
                    {{ Auth::user()->hasRole('Super-Admin') }} --}}

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                        @canany(['create_signs', 'edit_signs', 'delete_signs'])
                        <a class="dropdown-item" href="{{ route('admin.signs.index') }}">
                            {{ __('Manage Signs') }}
                        </a>
                        @endcanany

                        @canany(['create_users', 'edit_users', 'delete_users'])
                        <a class="dropdown-item" href="{{ route('admin.users.index') }}">
                            {{ __('Manage Users') }}
                        </a>
                        @endcanany

                        @canany(['create_roles', 'edit_roles', 'delete_roles'])
                        <a class="dropdown-item" href="{{ route('admin.roles.index') }}">
                            {{ __('Manage Roles') }}
                        </a>
                        @endcanany

                        <a class="dropdown-item" href="{{ route('changePasswordForm') }}">
                            {{ __('Change Password') }}
                        </a>

                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>