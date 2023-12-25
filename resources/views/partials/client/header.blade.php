<nav class="navbar navbar-expand-lg">
  <div class="container-fluid container">
    <a class="navbar-brand" href="/">Lensa <span style="color: var(--mainColor)">Photography</span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <i class="bi bi-list"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav ms-auto">
        <a class="nav-link" href="/">Home</a>
        <a class="nav-link" href="/service">Service</a>
        <a class="nav-link" href="/myorder">My Order</a>
        {{-- <a class="btn-contact" target="_blank" href="https://api.whatsapp.com/send?phone=6289669665015"><i class="bi bi-whatsapp"></i></a> --}}
        @if (!Auth::user())  
          <a class="btn-nav-login" href="/login/page">Login</a>
        @else
          <a class="btn-nav-login" href="/logout">Logout</a>
        @endif
      </div>
    </div>
  </div>
</nav>