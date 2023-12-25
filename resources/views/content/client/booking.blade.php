@extends('layout.client')

@push('css')
  <link rel="stylesheet" href="{{ asset('css/booking.css') }}">
@endpush

@section('content')
  <div class="container d-flex justify-content-center mt-5">
    <form class="box-form" action="/booking" method="POST">
      @csrf
      <h3 class="tagline">Booking</h3>
      <p class="subline">Fill in the form below to place an order</p>
      <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
      <input type="hidden" name="category_id" value="{{ $category->id }}">
      <input class="form-control @error('number_of_people') is-invalid @enderror" type="number" min="1" name="number_of_people" placeholder="Number of People" required>
      @error('number_of_people')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
      <input class="form-control @error('date') is-invalid @enderror" type="date" name="date" placeholder="Date" required>
      @error('date')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
      <input class="form-control @error('time') is-invalid @enderror" type="time" name="time" placeholder="Time" required>
      @error('time')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
      <button type="submit" class="btn-login">Book Now <i class="bi bi-arrow-right-short"></i></button>
    </form>
  </div>
@endsection

@push('js')
    
@endpush