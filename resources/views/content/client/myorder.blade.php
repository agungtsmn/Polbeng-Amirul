@extends('layout.client')

@push('css')
  <link rel="stylesheet" href="{{ asset('css/service.css') }}">
@endpush

@section('content')
  <div class="container mt-5">
    <div class="box-content">
      <h3 class="tagline">My Order</h3>
      <p class="subline">list of orders I have made</p>
      @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Hore!</strong> {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      <div class="row">
        @foreach ($bookings as $booking)
          <div class="col-md-6 col-lg-4 mb-4">
            <div>
              <div class="box-service">
                <img class="img-service" src="{{ Storage::url($booking->category->category_img) }}" alt="">
                <b class="type">{{ $booking->number_of_people }} Orang</b><br>
                <span class="box-harga"><b class="harga">{{ $booking->formatRupiah('total_price') }}</b></span>
                <p class="date">{{ $booking->date }} - {{ $booking->time }}</p>
                @if ($booking->status == 'Ordered')
                  <b style="color: rgb(148, 220, 238)">{{ $booking->status }}</b>
                @elseif ($booking->status == 'On Process')
                  <b style="color: rgb(241, 241, 129)">{{ $booking->status }}</b>
                @elseif ($booking->status == 'Finished')
                  <b style="color: rgb(138, 216, 138)">{{ $booking->status }}</b>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
@endsection

@push('js')
    
@endpush