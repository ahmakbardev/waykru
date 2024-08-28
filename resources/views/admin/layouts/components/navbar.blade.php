<nav class="navbar-vertical navbar">
    <div id="myScrollableElement" class="h-screen" data-simplebar>
        <!-- brand logo -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <img src="{{ asset('assets/images/logo/color.png')}}" class="w-32 object-contain" alt="" />
        </a>

        <!-- navbar nav -->
        <ul class="navbar-nav flex-col" id="sideNavbar">
            <li class="nav-item">
                <a class="nav-link  active " href="{{ route('dashboard') }}">
                    <i data-feather="home" class="w-4 h-4 mr-2"></i>
                    Dashboard
                </a>
            </li>
            <!-- nav item -->
            <li class="nav-item">
                <div class="navbar-heading">Fitur</div>
            </li>
            <!-- nav heading -->
            {{-- <li class="nav-item">
                <a class="nav-link" href="{{ route('chat-admin') }}">
                    <i data-feather="message-circle" class="w-4 h-4 mr-2"></i>
                    Chat
                </a>
            </li> --}}
            <!-- nav item -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#!" data-bs-toggle="collapse" data-bs-target="#navPages"
                    aria-expanded="false" aria-controls="navPages">
                    <i data-feather="message-circle" class="w-4 h-4 mr-2"></i>
                    Chat
                </a>
                <div id="navPages" class="collapse" data-bs-parent="#sideNavbar" style="">
                    <ul class="nav flex-col">
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('chat-menu') }}">
                                <i data-feather="message-circle" class="w-4 h-4 mr-2"></i>
                                Chat Menu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('chat-admin') }}">
                                <i data-feather="message-square" class="w-4 h-4 mr-2"></i>
                                User Chat</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
