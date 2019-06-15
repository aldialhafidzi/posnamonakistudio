@if (Auth::guard('web')->check())
  <p class="text-success">
    You are Logged In as a User
  </p>
@else
  <p class="text-danger">
    You are Logged Out as a User
  </p>
@endif

@if (Auth::guard('admin')->check())
  <p class="text-success">
    You are Logged In as a Admin
  </p>
@else
  <p class="text-danger">
    You are Logged Out as a Admin
  </p>
@endif
