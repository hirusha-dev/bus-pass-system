<nav class="navbar">
    @auth
        @if (Auth::user()->role === 'admin')
            <div class="logo">
                <a href="#">Bus Pass Management</a>
            </div>
        @else
            <div class="logo">
                <a href="/">Bus Pass Management</a>
            </div>
        @endif
    @else
        <div class="logo">
            <a href="/">Bus Pass Management</a>
        </div>
    @endauth
    <ul class="nav-links">

        @auth
            @if (Auth::user()->role === 'admin')
                <li><a href="/admin/user-management">User Management</a></li>
                <li><a href="/admin/pass-management">Pass Management</a></li>
            @else
                <li><a href="/">Home</a></li>
                <li><a href="/#generate">Generate Bus Pass</a></li>
                <li><a href="/#view-pass">View Pass</a></li>
                <li><a href="/#contact">Contact Us</a></li>
            @endif
            <li><a class="logout-btn" href="{{ route('logout') }}">Logout</a></li>
        @else
            <li><a href="/">Home</a></li>
            <li><a href="/#generate">Generate Bus Pass</a></li>
            <li><a href="/#view-pass">View Pass</a></li>
            <li><a href="/#contact">Contact Us</a></li>
            <li><a href="/login" class="login-btn">Login</a></li>
        @endauth
    </ul>
</nav>
