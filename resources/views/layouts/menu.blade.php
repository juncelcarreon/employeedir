@auth
    @if(Auth::user()->isAdmin())
        @include('layouts.menu.admin')
    @elseif(Auth::user()->isHR())
        @include('layouts.menu.hr')
    @else
        @include('layouts.menu.normal')
    @endif 
@endauth
@guest
    @include('layouts.menu.normal')
@endguest