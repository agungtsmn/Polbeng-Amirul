@extends('layout.client')

@push('css')
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@section('content')
  <div class="jumbotron">
    <div class="container d-flex flex-column justify-content-center align-items-center">
      <form class="box-form" action="/login" method="POST">
        @csrf
        <h3 class="tagline">Login</h3>
        <p class="subline">Welcome back!, login to access Lensa Photography Website, do you <a class="register-text" href="/register/page">not have an account yet?</a></p>
        <input class="form-control @error('username') is-invalid @enderror" type="text" name="username" placeholder="Username" required>
        @error('username')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="Password" required>
        @error('password')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
        <button type="submit" class="btn-login">Login <i class="bi bi-arrow-right-short"></i></button>
      </form>
    </div>
  </div>
@endsection

@push('js')
    
@endpush