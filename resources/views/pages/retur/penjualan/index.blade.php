@extends('layout.dashboard')
@section('title', 'Retur Penjualan Page')

@section('content')
<div class="section-header d-flex justify-content-between">
  <h1>@yield('title')</h1>
  <a href="" class="btn btn-primary text-capitalize">tambah retur penjualan</a>
</div>
<div class="card">
  <div class="card-body">
    <form action="" method="POST" id="bazarku__form__filter__retur__penjualan">
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-1 mr-2">Divisi</label>
        <div class="col-lg">
          <select class="form-control" id="bazarku__choose__divisi" name="divisi">
            <option value="0">Semua Divisi</option>
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
            <th class="text-center">jumlah retur</th>
            <th class="text-center">nominal retur</th>
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
  $('#bazarku__retur__penjualan__info').hide();
  $(document).ready(() => {
    $('#bazarku__form__filter__retur__penjualan').on('submit', (e) => {
      e.preventDefault();
      const dateRange = $('#bazarku__date__range').val();
      const divisi = $('#bazarku__choose__divisi').val();

      let requestURL = "{{route('datatables.retur.penjualan', [':divisi', ':dateRange'])}}";
      requestURL = requestURL.replace(':divisi', divisi);
      requestURL = requestURL.replace(':dateRange', dateRange);

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
              data: 'jumlah_stok_retur',
              render: (data) => `${data} PCS`,
            },
            {
              data: 'nominal_retur',
              render: (data) => {
                return rupiahFormat(data);
              }
            },
            {
              data: 'ID_retur',
              render: (data) => {
                return `<a href="#" class="btn btn-warning text-uppercase">detail</a>`
              }
            }
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
              data: 'jumlah_stok_retur',
              render: (data) => `${data} PCS`,
            },
            {
              data: 'nominal_retur',
              render: (data) => {
                return rupiahFormat(data);
              }
            },
            {
              data: 'ID_retur',
              render: (data) => {
                return `<a href="#" class="btn btn-warning text-uppercase"><i class="fas fa-eye"></i> detail</a>`
              }
            }
          ]
        });
      }
      $('#bazarku__retur__penjualan__info').show();

      console.log(requestURL);
    });
  });
</script>
@endpush