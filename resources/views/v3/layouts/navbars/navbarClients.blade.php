@auth()
    @include('layouts.navbars.navs.clients.auth')
@endauth

@guest()
    @include('layouts.navbars.navs.clients.guest')
@endguest
