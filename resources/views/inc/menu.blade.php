<div class="navbar-custom-menu pull-left">
    <ul class="nav navbar-nav">
        <!-- =================================================== -->
        <!-- ========== Top menu items (ordered left) ========== -->
        <!-- =================================================== -->

        <!-- <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> <span>Home</span></a></li> -->

        <!-- ========== End of top menu left items ========== -->
    </ul>
</div>


<div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <!-- ========================================================= -->
      <!-- ========== Top menu right items (ordered left) ========== -->
      <!-- ========================================================= -->

      <!-- <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> <span>Home</span></a></li> -->

        @if (Auth::guest())
            <li><a href="{{ url('').'/login' }}">Login</a></li>
            @if (config('backpack.base.registration_open'))
            <li><a href="{{ url('').'/register' }}">Register</a></li>
            @endif
        @else
            <li>
            <a href="{{ url('').'/logout' }}" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
              <i class="fa fa-btn fa-sign-out"></i>Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
           </li>
        @endif

       <!-- ========== End of top menu right items ========== -->
    </ul>
</div>
