<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                @if (Auth::user()->avatar!=null)
                    @if ( config('app.env')=='production')
                        <img src="{{Storage::url('public/storage/'.Auth::user()->avatar)}}"
                                class="user-image img-circle elevation-2" alt="User Image">
                    @else
                        <img src="{{Storage::url(Auth::user()->avatar)}}"
                        class="user-image img-circle elevation-2" alt="User Image">
                    @endif

                @else
                    <img src="{{ asset('defautl-user.jpg') }}"
                    class="user-image img-circle elevation-2" alt="User Image">
                @endif
                <span class="d-none d-md-inline">{{Auth::user()->name}}<span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <!-- User image -->
              <li class="user-header bg-primary">
                @if (Auth::user()->avatar!=null)
                    @if (config('app.env')=='production')
                        <img src="{{Storage::url('public/storage/'.Auth::user()->avatar)}}"
                        class="img-circle elevation-2" alt="User Image">
                    @else
                        <img src="{{Storage::url(Auth::user()->avatar)}}"
                        class="img-circle elevation-2" alt="User Image">
                    @endif
                @else
                    <img src="{{ asset('defautl-user.jpg') }}"
                    class="img-circle elevation-2" alt="User Image">
                @endif

                <p>
                  <small>User name</small>
                </p>
              </li>

              <!-- Menu Footer-->
              <li class="user-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                        <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        this.closest('form').submit();" class="btn btn-default btn-flat float-right">Déconnexion</a>
                </form>

              </li>
            </ul>
          </li>
    </ul>
</nav>
