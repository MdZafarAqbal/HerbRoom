@if ($message = session('success'))
  <div class="flash-success flash-message">
    <p>{{ $message }}</p>
  </div>
@endif
@if ($message = session('error'))
  <div class="flash-error flash-message">
    <p>{{ $message }}</p>
  </div>
@endif
@if ($message = session('warning'))
  <div class="flash-warning flash-message">
    <p>{{ $message }}</p>
  </div>
@endif
@if ($message = session('info'))
  <div class="flash-info flash-message">
    <p>{{ $message }}</p>
  </div>
@endif
