@extends('layout.client')

@push('css')
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@section('content')
  <div class="jumbotron">
    <div class="container d-flex flex-column justify-content-center align-items-center">
      <form class="box-form" action="/register" method="POST">
        @csrf
        <h3 class="tagline">Register</h3>
        <p class="subline">Hallo!, fill in all forms below to register</p>
        <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" placeholder="Your Name" required>
        @error('name')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
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
        <input class="form-control @error('phone_number') is-invalid @enderror" type="number" min="0" name="phone_number" placeholder="Phone Number (62)" required>
        @error('phone_number')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
        <button type="submit" class="btn-login">Register <i class="bi bi-arrow-right-short"></i></button>
      </form>
    </div>
  </div>
@endsection

@push('js')
    
@endpush