@extends('layout.client')

@push('css')
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
  <div class="jumbotron">
    <div class="container d-flex flex-column justify-content-center align-items-center">
      <h1 class="headline">Best <span style="color: var(--mainColor)">Photography</span><br>Studio In Bengkalis</h1>
      <p class="subline">Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus saepe debitis totam nulla optio soluta natus corporis rem, laboriosam delectus.</p>
      @if (!Auth::user())
        <a href="/login/page" class="btn-order">Order Now</a>
      @else
        <a href="/service" class="btn-order">Order Now</a>
      @endif
    </div>
  </div>
@endsection

@push('js')
    
@endpush