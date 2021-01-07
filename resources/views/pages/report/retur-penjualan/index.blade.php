@extends('layout.dashboard')
@section('sectionTitle', 'Retur Penjualan Page')

@section('content')
<div class="section-header">
  <h1>@yield('sectionTitle')</h1>
</div>
<div class="card">
  <div class="card-body">
    <form action="" method="POST" id="bazarku__form__filter__retur__penjualan">
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
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-1 mr-2">Sort By</label>
        <div class="col-lg">
          <select class="form-control choose__sort__by" id="bazarku__choose__sort__by" name="sort_by">
            <option>Urutkan</option>
            <option>No Retur</option>
            <option>Tanggal Retur</option>
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
<div class="card" id="bazarku__retur__penjualan__info">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped" id="data__table__retur__penjualan">
        <thead>
          <tr class="text-uppercase">
            <th class="text-center">#</th>
            <th class="text-center">no. retur</th>
            <th class="text-center">tanggal retur</th>
            <th class="text-center">no. penjualan</th>
            <th class="text-center">jumlah stok retur</th>
            <th class="text-center">nominal retur</th>
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
    $('.daterange-cus').daterangepicker({
      locale: {
        format: 'YYYY-MM-DD'
      },
      drops: 'down',
      opens: 'right'
    });

    $('#bazarku__form__filter__retur__penjualan').on('submit', (e) => {
      e.preventDefault();
      const dateRange = $('#bazarku__date__range').val();
      const sortBy = $('#bazarku__choose__sort__by').val();
      const sort = $('#bazarku__choose__sort__asc__or__desc').val();

      let requestURL = "{{route('datatables.retur-penjualan', [':dateRange', ':sortBy', ':sort'])}}";
      requestURL = requestURL.replace(':dateRange', dateRange);
      requestURL = requestURL.replace(':sortBy', sortBy);
      requestURL = requestURL.replace(':sort', sort);

      const rupiahFormat = (data) => {
        let reverse = data.toString().split('').reverse().join('');
        ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return `Rp. ${ribuan}`;
      }

      if ($.fn.dataTable.isDataTable('#data__table__retur__penjualan')) {
        $('#data__table__retur__penjualan').DataTable().destroy();
        $('#data__table__retur__penjualan').DataTable({
          processing: true,
          serverSide: true,
          ajax: requestURL,
          columns: [{
              data: 'DT_RowIndex',
              orderable: false,
              searchable: false
            },
            {
              data: 'nomor_retur'
            },
            {
              data: 'tanggal_retur'
            },
            {
              data: 'ID_invoice'
            },
            {
              data: 'jumlah_stok_retur'
            },
            {
              data: 'nominal_retur',
              render: (data) => {
                return rupiahFormat(data);
              }
            },
          ]
        });
      } else {
        $('#data__table__retur__penjualan').DataTable({
          processing: true,
          serverSide: true,
          ajax: requestURL,
          columns: [{
              data: 'DT_RowIndex',
              orderable: false,
              searchable: false
            },
            {
              data: 'nomor_retur'
            },
            {
              data: 'tanggal_retur'
            },
            {
              data: 'ID_invoice'
            },
            {
              data: 'jumlah_stok_retur'
            },
            {
              data: 'nominal_retur',
              render: (data) => {
                return rupiahFormat(data);
              }
            },
          ]
        });
      }

      console.log(requestURL);
    });
  });
</script>
@endpush