@include('partials.head')
<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    @include('partials.app.header')
    <div class="app-body">
        @include('partials.app.sidebar')
        <main class="main">
            <div id="app">
                @include('components.alert')
                <div class="container-fluid">
                    <div class="animated fadeIn">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>
    @include('partials.app.footer')
    @include('partials.foot')