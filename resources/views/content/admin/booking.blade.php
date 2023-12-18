@extends('layout.admin')

@push('css')
  <!-- vendor css -->
  <link href="{{ asset('template') }}/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="{{ asset('template') }}/lib/Ionicons/css/ionicons.css" rel="stylesheet">
  <link href="{{ asset('template') }}/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
  <link href="{{ asset('template') }}/lib/jquery-switchbutton/jquery.switchButton.css" rel="stylesheet">
  <link href="{{ asset('template') }}/lib/highlightjs/github.css" rel="stylesheet">
  <link href="{{ asset('template') }}/lib/datatables/jquery.dataTables.css" rel="stylesheet">
  <link href="{{ asset('template') }}/lib/select2/css/select2.min.css" rel="stylesheet">

  <!-- Bracket CSS -->
  <link rel="stylesheet" href="{{ asset('template') }}/css/bracket.css">

  <style>
    .modal-dialog{
      width: 90%;
    }

    .category_img{
      width: 100px;
      height: 60px;
      border-radius: 2px;
      margin-right: 10px;
      object-fit: cover;
      box-shadow: rgba(0, 0, 0, 0.167) 0 0 5px;
    }
  </style>
@endpush

@section('content')
  <!-- ########## START: MAIN PANEL ########## -->
  <div class="br-mainpanel">
    <div class="br-pageheader pd-y-15 pd-l-20">
      <nav class="breadcrumb pd-0 mg-0 tx-12">
        <a class="breadcrumb-item" href="/dashboard">Admin Panel</a>
        <a class="breadcrumb-item" href="/manage/booking">Kelola Data</a>
        <span class="breadcrumb-item active">Pemesanan</span>
      </nav>
    </div><!-- br-pageheader -->
    
    @include('partials.crud-alert')

    <div class="pd-x-20 pd-sm-x-30 pd-t-2 d-flex align-items-center justify-content-between flex-wrap">
      <div>
        <h4 class="tx-gray-800 mg-b-5">Pengelolaan Data Pemesanan</h4>
        <p class="mg-b-0">Melihat, menambah, mengedit, dan menghapus data pemesanan</p>
      </div>
      
      <!-- BASIC MODAL -->
      <a href="" class="btn btn-teal" data-toggle="modal" data-target="#modalCreateBooking">Tambah Data <i class="bi bi-plus"></i></a>
      <div id="modalCreateBooking" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center" role="document">
          <form action="/manage/booking" method="POST" class="modal-content bd-0 tx-14" enctype="multipart/form-data">
            @csrf
            <div class="modal-header pd-y-20 pd-x-25">
              <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Tambah Data Pemesanan</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body pd-25">
              <div class="form-group">
                <label class="form-control-label">Pengguna: <span class="tx-danger">*</span></label>
                <select class="form-control" name="user_id" required>
                  <option>Pilih Pengguna</option>
                  @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label class="form-control-label">Tipe: <span class="tx-danger">*</span></label>
                <select class="form-control" name="category_id" required>
                  <option>Pilih Tipe</option>
                  @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->type }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label class="form-control-label">Jumlah Orang: <span class="tx-danger">*</span></label>
                <input class="form-control @error('number_of_people') is-invalid @enderror" type="number" min="0" name="number_of_people" placeholder="Masukkan jumlah orang" required>
                @error('number_of_people')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group">
                <label class="form-control-label">Tanggal: <span class="tx-danger">*</span></label>
                <input class="form-control" type="date" name="date" placeholder="Masukkan tanggal" required>
              </div>
              <div class="form-group">
                <label class="form-control-label">Jam: <span class="tx-danger">*</span></label>
                <input class="form-control" type="time" name="time" placeholder="Masukkan jam" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-teal tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Submit</button>
              <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
            </div>
          </form>
        </div><!-- modal-dialog -->
      </div><!-- modal -->

    </div>

    <div class="br-pagebody">
      <div class="br-section-wrapper">
        {{-- <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Basic Responsive DataTable</h6>
        <p class="mg-b-25 mg-lg-b-50">Searching, ordering and paging goodness will be immediately added to the table, as shown in this example.</p> --}}

        <div class="table-wrapper">
          <table id="datatable1" class="table display responsive nowrap">
            <thead>
              <tr>
                <th class="wd-5p text-center">No</th>
                <th class="wd-20p">Pengguna</th>
                <th class="wd-20p">Kategori</th>
                <th class="wd-20p">Jumlah</th>
                <th class="wd-20p">Total Harga</th>
                <th class="wd-20p">Tanggal</th>
                <th class="wd-20p">Jam</th>
                <th class="wd-20p">Keadaan</th>
                <th class="wd-15p text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($bookings as $booking)
                <tr>
                  <td class="text-center">{{ $loop->iteration }}</td>
                  <td>{{ $booking->user->name }}</td>
                  <td>{{ $booking->category->type }}</td>
                  <td>{{ $booking->number_of_people }} Orang</td>
                  <td>{{ $booking->formatRupiah('total_price') }}</td>
                  <td>{{ date('d M y', strtotime($booking->date)) }}</td>
                  <td>{{ date('H.i', strtotime($booking->time)) }}</td>
                  <td>{{ $booking->status }}</td>
                  <td>
                    <div class="d-flex justify-content-center">
                      {{-- Tombol Modal Update --}}
                      <a href="" class="btn btn-warning tx-10 pd-x-10 pd-y-5 mr-2" data-toggle="modal" data-target="#modalUpdateBooking{{ $booking->id }}"><i class="bi bi-pen mr-1"></i> Edit</a>
                      <div data-kode="{{ $booking->id }}" class="btn btn-danger tx-10 pd-x-10 pd-y-5 swal-confirm">
                        <form action="/manage/booking/{{ $booking->id }}" id="delete{{ $booking->id }}" method="post">
                            @csrf
                            @method('delete')
                        </form>
                        <i class="bi bi-trash mr-1"></i>
                        Delete
                      </div>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div><!-- table-wrapper -->
        
        @foreach ($bookings as $booking)
          {{-- Modal Update --}}
          <div id="modalUpdateBooking{{ $booking->id }}" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <form action="/manage/booking/{{ $booking->id }}" method="POST" class="modal-content bd-0 tx-14" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Perbarui Data Pemesanan</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body pd-25">
                  <div class="form-group">
                    <label class="form-control-label">Pengguna: <span class="tx-danger">*</span></label>
                    <select class="form-control" name="user_id" required>
                      <option value="{{ $booking->user_id }}">{{ $booking->user->name }}</option>
                      @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="form-control-label">Tipe: <span class="tx-danger">*</span></label>
                    <select class="form-control" name="category_id" required>
                      <option value="{{ $booking->category_id }}">{{ $booking->category->type }}</option>
                      @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->type }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="form-control-label">Jumlah Orang: <span class="tx-danger">*</span></label>
                    <input class="form-control @error('number_of_people') is-invalid @enderror" type="number" min="0" name="number_of_people" placeholder="Masukkan jumlah orang" required value="{{ $booking->number_of_people }}">
                    @error('number_of_people')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label class="form-control-label">Tanggal: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="date" name="date" placeholder="Masukkan tanggal" required value="{{ $booking->date }}">
                  </div>
                  <div class="form-group">
                    <label class="form-control-label">Jam: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="time" name="time" placeholder="Masukkan jam" required value="{{ $booking->time }}">
                  </div>
                  <div class="form-group">
                    <label class="form-control-label">Keadaan: <span class="tx-danger">*</span></label>
                    <select class="form-control" name="status" required>
                      <option value="{{ $booking->status }}">{{ $booking->status }}</option>
                      <option value="Ordered">Ordered</option>
                      <option value="On Process">On Process</option>
                      <option value="Finished">Finished</option>
                    </select>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-warning tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Update</button>
                  <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
                </div>
              </form>
            </div><!-- modal-dialog -->
          </div><!-- modal -->
        @endforeach

      </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->

    @include('partials.footer')

  </div><!-- br-mainpanel -->
  <!-- ########## END: MAIN PANEL ########## -->
@endsection

@push('js')
  {{-- sweetalert2 --}}
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <script src="{{ asset('template') }}/lib/jquery/jquery.js"></script>
  <script src="{{ asset('template') }}/lib/popper.js/popper.js"></script>
  <script src="{{ asset('template') }}/lib/bootstrap/bootstrap.js"></script>
  <script src="{{ asset('template') }}/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
  <script src="{{ asset('template') }}/lib/moment/moment.js"></script>
  <script src="{{ asset('template') }}/lib/jquery-ui/jquery-ui.js"></script>
  <script src="{{ asset('template') }}/lib/jquery-switchbutton/jquery.switchButton.js"></script>
  <script src="{{ asset('template') }}/lib/peity/jquery.peity.js"></script>
  <script src="{{ asset('template') }}/lib/highlightjs/highlight.pack.js"></script>
  <script src="{{ asset('template') }}/lib/datatables/jquery.dataTables.js"></script>
  <script src="{{ asset('template') }}/lib/datatables-responsive/dataTables.responsive.js"></script>
  <script src="{{ asset('template') }}/lib/select2/js/select2.min.js"></script>

  <script src="{{ asset('template') }}/js/bracket.js"></script>

  <script>
    $(function(){
      'use strict';

      $('#datatable1').DataTable({
        responsive: true,
        language: {
          searchPlaceholder: 'Search...',
          sSearch: '',
          lengthMenu: '_MENU_ items/page',
        }
      });

      $('#datatable2').DataTable({
        bLengthChange: false,
        searching: false,
        responsive: true
      });

      // Select2
      $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

    });
  </script>

  <script>
    $(".swal-confirm").click(function(e) {
        id = e.target.dataset.kode;
        if (id) {
            Swal.fire({
                title: 'Anda yakin ingin menghapus?',
                text: "Jika sudah terhapus data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#F5365C',
                cancelButtonColor: '#2DCE89',
                confirmButtonText: 'Iya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete' + id).submit();
                }
            });
        }
    });
  </script>
@endpush