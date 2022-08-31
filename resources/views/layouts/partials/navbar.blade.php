<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">

                <img src="{{ asset('defautl-user.jpg') }}" class="user-image img-circle elevation-2" alt="User Image">


                <span class="d-none d-md-inline">  User name</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <!-- User image -->
              <li class="user-header bg-primary">
                    <img src="{{ asset('defautl-user.jpg') }}"
                        class="img-circle elevation-2" alt="User Image">
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
