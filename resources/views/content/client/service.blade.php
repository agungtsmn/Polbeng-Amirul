@extends('layout.client')

@push('css')
  <link rel="stylesheet" href="{{ asset('css/service.css') }}">
@endpush

@section('content')
  <div class="container mt-5">
    <div class="box-content">
      <h3 class="tagline">Our Service</h3>
      <p class="subline">list of services we provide for you</p>
      <div class="row">
        @foreach ($categories as $category)
          <div class="col-md-6 col-lg-4 mb-4">
            <a href="/booking/page/{{ $category->id }}" class="text-decoration-none">
              <div class="box-service">
                <img class="img-service" src="{{ Storage::url($category->category_img) }}" alt="">
                <b class="type">{{ $category->type }}</b><br>
                <span class="box-harga"><b class="harga">{{ $category->formatRupiah('price') }}</b> / Orang</span>
              </div >
            </a>
          </div>
        @endforeach
      </div>
    </div>
  </div>
@endsection

@push('js')
    
@endpush