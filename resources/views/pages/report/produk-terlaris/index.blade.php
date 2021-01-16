@extends('layout.dashboard')
@section('title', 'Produk Terlaris Page')

@section('content')
<div class="section-header">
  <h1>@yield('title')</h1>
</div>
<div class="card">
  <div class="card-body">
    <form action="" method="POST" id="bazarku__form__filter__produk__terlaris">
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-1 mr-2">Divisi</label>
        <div class="col-lg">
          <select class="form-control choose__divisi" id="bazarku__choose__divisi" name="divisi_id">
            <option>Semua Divisi</option>
            @foreach($divisi as $loopItem)
            <option value="{{$loopItem->ID_divisi}}">{{$loopItem->nama}}</option>
            @endforeach
          </select>
          <small class="form-text text-danger text-capitalize"></small>
        </div>
      </div>
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-1 mr-2 text-nowrap">Pilih Tanggal</label>
        <div class="col-lg">
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">
                <i class="fas fa-calendar"></i>
              </div>
            </div>
            <input type="text" class="form-control daterange-cus" id="bazarku__date__range" name="date_range">
          </div>
        </div>
      </div>
      <!-- <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-1 mr-2">Sort By</label>
        <div class="col-lg">
          <select class="form-control choose__sort__by" id="bazarku__choose__sort__by" name="sort_by">
            <option>Urutkan</option>
            <option>No Retur</option>
            <option>Tanggal Retur</option>
          </select>
          <small class="form-text text-danger text-capitalize"></small>
        </div>
      </div> -->
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
<div class="card" id="bazarku__produk__terlaris__info">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped" id="data__table__produk__terlaris">
        <thead>
          <tr class="text-uppercase">
            <th class="text-center">#</th>
            <th class="text-center">id produk</th>
            <th class="text-center">kode produk</th>
            <th class="text-center">nama produk</th>
            <th class="text-center">divisi</th>
            <th class="text-center">total qty terjual</th>
            <th class="text-center">stok saat ini</th>
            <th class="text-center">tgl beli terakhir</th>
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
    $('#bazarku__produk__terlaris__info').hide();
    $('#bazarku__form__filter__produk__terlaris').on('submit', (e) => {
      e.preventDefault();
      const datatableColumn = [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'ID_produk'
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
          data: 'qty_saat_ini'
        },
        {
          data: 'qty_saat_ini'
        },
        {
          data: 'tgl_beli_terakhir'
        },
      ];

      const divisiId = $('#bazarku__choose__divisi').val();
      const dateRange = $('#bazarku__date__range').val();
      let requestURL = "{{route('datatables.produk.terlaris', [':divisiId', ':dateRange'])}}";
      requestURL = requestURL.replace(':divisiId', divisiId);
      requestURL = requestURL.replace(':dateRange', dateRange);

      if ($.fn.dataTable.isDataTable('#data__table__produk__terlaris')) {
        $('#data__table__produk__terlaris').DataTable().destroy();
        $('#data__table__produk__terlaris').DataTable({
          processing: true,
          serverSide: true,
          ajax: requestURL,
          columns: datatableColumn
        });
      } else {
        $('#data__table__produk__terlaris').DataTable({
          processing: true,
          serverSide: true,
          ajax: requestURL,
          columns: datatableColumn
        });
      }
      $('#bazarku__produk__terlaris__info').show();
    });

  });
</script>
@endpush