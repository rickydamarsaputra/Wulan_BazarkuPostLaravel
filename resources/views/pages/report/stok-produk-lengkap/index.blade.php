@extends('layout.dashboard')
@section('title', 'Stok Produk Lengkap Page')

@section('content')
<div class="section-header">
  <h1>@yield('title')</h1>
</div>
<div class="card">
  <div class="card-body">
    <form action="" method="POST" id="bazarku__form__filter__stok__barang">
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-1 mr-2">Divisi</label>
        <div class="col-lg">
          <select class="form-control choose__divisi" id="bazarku__choose__divisi" name="divisi_id">
            <option>Semua Divisi</option>
            @foreach($divisi as $divi)
            <option value="{{$divi->ID_divisi}}">{{$divi->nama}}</option>
            @endforeach
          </select>
          <small class="form-text text-danger text-capitalize"></small>
        </div>
      </div>
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-1 mr-2">Sort By</label>
        <div class="col-lg">
          <select class="form-control choose__sort__by" id="bazarku__choose__sort__by" name="sort_by">
            <option>Urutkan</option>
            <option>Kode Produk</option>
            <option>Nama Produk</option>
            <option>Qty</option>
          </select>
          <small class="form-text text-danger text-capitalize"></small>
        </div>
      </div>
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-1 text-nowrap mr-2">Sort Asc/Desc</label>
        <div class="col-lg">
          <select class="form-control choose__sort__asc__or__desc" id="bazarku__choose__sort__asc__or__desc" name="sort_by_asc_desc">
            <option>ASC Or DESC</option>
            <option>Ascending</option>
            <option>Descending</option>
          </select>
          <small class="form-text text-danger text-capitalize"></small>
        </div>
      </div>
      <button class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>
<div class="card" id="bazarku__stok__produk__lengkap__info">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped" id="data__table__stok__produk__lengkap">
        <thead>
          <tr class="text-uppercase">
            <th class="text-center">#</th>
            <th class="text-center">Kode</th>
            <th class="text-center">Nama</th>
            <th class="text-center">Divisi</th>
            <th class="text-center">Qty Min</th>
            <th class="text-center">Qty</th>
            <th class="text-center">Hpp</th>
            <th class="text-center">Nilai</th>
            <th class="text-center">Harga Normal</th>
            <th class="text-center">Harga Instagram</th>
            <th class="text-center">Harga Dropship</th>
            <th class="text-center">Harga Reseller</th>
            <th class="text-center">Harga Grosir</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(() => {

    $('#bazarku__stok__produk__lengkap__info').hide();
    $('#bazarku__form__filter__stok__barang').on('submit', (e) => {
      e.preventDefault();
      const divisiId = $('#bazarku__choose__divisi').val();
      const sortBy = $('#bazarku__choose__sort__by').val();
      const sort = $("#bazarku__choose__sort__asc__or__desc").val();
      let requestURL = "{{route('datatables.stok-produk-lengkap', [':divisiId', ':sortBy', ':sort'])}}";
      requestURL = requestURL.replace(':divisiId', divisiId);
      requestURL = requestURL.replace(':sortBy', sortBy);
      requestURL = requestURL.replace(':sort', sort);
      const rupiahFormat = (data) => {
        let reverse = data.toString().split('').reverse().join('');
        ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return ribuan;
      }

      if ($.fn.dataTable.isDataTable('#data__table__stok__produk__lengkap')) {
        $('#data__table__stok__produk__lengkap').DataTable().destroy();
        $('#data__table__stok__produk__lengkap').DataTable({
          processing: true,
          serverSide: true,
          ajax: requestURL,
          columns: [{
              data: 'DT_RowIndex',
              orderable: false,
              searchable: false
            },
            {
              data: 'kode_produk'
            },
            {
              data: 'nama_produk'
            },
            {
              data: 'divisi.nama',
              defaultContent: '-'
            },
            {
              data: 'qty_min'
            },
            {
              data: 'qty_saat_ini'
            },
            {
              data: 'HPP',
              render: (data) => {
                return `Rp.${rupiahFormat(data)}`;
              }
            },
            {
              data: 'HPP'
            },
            {
              data: 'harga_normal',
              render: (data) => {
                return `Rp.${rupiahFormat(data)}`;
              }
            },
            {
              data: 'harga_instagram',
              render: (data) => {
                return `Rp.${rupiahFormat(data)}`;
              }
            },
            {
              data: 'harga_dropship',
              render: (data) => {
                return `Rp.${rupiahFormat(data)}`;
              }
            },
            {
              data: 'harga_reseller',
              render: (data) => {
                return `Rp.${rupiahFormat(data)}`;
              }
            },
            {
              data: 'harga_grosir',
              render: (data) => {
                return `Rp.${rupiahFormat(data)}`;
              }
            },
          ]
        });
      } else {
        $('#data__table__stok__produk__lengkap').DataTable({
          processing: true,
          serverSide: true,
          ajax: requestURL,
          columns: [{
              data: 'DT_RowIndex',
              orderable: false,
              searchable: false
            },
            {
              data: 'kode_produk'
            },
            {
              data: 'nama_produk'
            },
            {
              data: 'divisi.nama',
              defaultContent: '-'
            },
            {
              data: 'qty_min'
            },
            {
              data: 'qty_saat_ini'
            },
            {
              data: 'HPP',
              render: (data) => {
                return `Rp.${rupiahFormat(data)}`;
              }
            },
            {
              data: 'HPP'
            },
            {
              data: 'harga_normal',
              render: (data) => {
                return `Rp.${rupiahFormat(data)}`;
              }
            },
            {
              data: 'harga_instagram',
              render: (data) => {
                return `Rp.${rupiahFormat(data)}`;
              }
            },
            {
              data: 'harga_dropship',
              render: (data) => {
                return `Rp.${rupiahFormat(data)}`;
              }
            },
            {
              data: 'harga_reseller',
              render: (data) => {
                return `Rp.${rupiahFormat(data)}`;
              }
            },
            {
              data: 'harga_grosir',
              render: (data) => {
                return `Rp.${rupiahFormat(data)}`;
              }
            },
          ]
        });
      }

      $('#bazarku__stok__produk__lengkap__info').show();
    });
  });
</script>
@endpush

<style>
  table#data__table__stok__produk__lengkap {
    width: -webkit-fill-available !important;
  }
</style>