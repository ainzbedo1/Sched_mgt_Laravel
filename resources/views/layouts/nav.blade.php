<nav class="navbar navbar-expand-md navbar-dark bg-dark static-top">
  <a class="navbar-brand" href="{{ url('/main/successlogin') }}">
    <img src="/pics/calendar_icon.png" width="50" height="50" class="d-inline-block " alt="">  SCHED MGT</a>
  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <div class="navbar-nav mr-auto">
    </div>
    <div class="form-inline my-2 my-lg-0">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hi! {{ Auth::user()->name }} </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="{{ route('user.edit') }}">Account Settings</a>
            <a class="dropdown-item" href="{{ url('/main/logout') }}">Log Out</a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>