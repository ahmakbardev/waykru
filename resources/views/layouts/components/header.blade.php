<header>
    <div class="header">
        <a href="/" class="title bowlby-one-sc-regular">
            WAYKRU
        </a>
        <div class="all-menu">
            <ul class="menu-list">
                <a class="menu" href="html/features.html">
                    Features
                </a>
                <a class="menu" href="{{ route('article') }}">
                    Article
                </a>
                <a class="menu" href="{{ route('social') }}">
                    Social
                </a>

                @guest
                    <!-- Jika user belum login -->
                    <a class="sign-up-button" href="{{ route('login') }}">
                        Log In
                    </a>
                @endguest

                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="sign-up-button">
                            Log Out
                        </button>
                    </form>
                @endauth
            </ul>
        </div>
    </div>
</header>
