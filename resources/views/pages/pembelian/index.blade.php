@extends('layout.dashboard')
@section('title', 'Pembelian Page')

@section('content')
<div class="section-header d-flex justify-content-between">
  <h1>@yield('title')</h1>
</div>

<div class="card">
  <div class="card-body overflow-scroll">
    <form action="" method="POST" id="bazarku__pembelian">
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-2">Supplier</label>
        <div class="col-lg-4">
          <select class="form-control" name="supplier">
            <option value="0">Pilih Supplier</option>
            @foreach($supplier as $loopItem)
            <option value="{{$loopItem->ID_supplier}}">{{$loopItem->nama}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-2">Divisi</label>
        <div class="col-lg-4">
          <select class="form-control" name="divisi">
            <option value="0">Pilih Divisi</option>
            @foreach($divisi as $loopItem)
            <option value="{{$loopItem->ID_divisi}}">{{$loopItem->nama}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-2">Bank</label>
        <div class="col-lg-4">
          <select class="form-select form-select-sm" name="bank">
            <option value="0">Pilih Bank</option>
            @foreach($bank as $loopItem)
            <option value="{{$loopItem->ID_bank}}">{{$loopItem->nama_bank}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-2 mr-2 text-nowrap">Status Lunas</label>
        <div class="col-lg">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="status_lunas" value="1" id="lunas">
            <label class="form-check-label" for="lunas">
              Lunas
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="status_lunas" value="2" id="belum_lunas">
            <label class="form-check-label" for="belum_lunas">
              Belum Lunas
            </label>
          </div>
          <small class="form-text text-danger text-capitalize"></small>
        </div>
      </div>
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-2">Pilih Tanggal</label>
        <div class="col-lg-4">
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
        <div class="col-lg-2"></div>
        <div class="col-lg">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="card" id="bazarku__pembelian__info">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped" id="data__table__pembelian">
        <thead>
          <tr class="text-uppercase">
            <th class="text-center">#</th>
            <th class="text-center">tanggal beli</th>
            <th class="text-center">nomor pembelian</th>
            <th class="text-center">supplier</th>
            <th class="text-center">divisi</th>
            <th class="text-center">total</th>
            <th class="text-center">status lunas</th>
            <th class="text-center">tagihan</th>
            <th class="text-center"></th>
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
    $('#bazarku__pembelian__info').hide();
    $('#bazarku__pembelian').on('submit', async (e) => {
      e.preventDefault();
      $('#bazarku__pembelian__info').show();

      const idSupplier = $('select[name=supplier]').val();
      const idDivisi = $('select[name=divisi]').val();
      const idBank = $('select[name=bank]').val();
      const dateRange = $('#bazarku__date__range').val();
      let statusLunas = 0;
      const statusLunasElements = document.querySelectorAll('input[name=status_lunas]');
      statusLunasElements.forEach(e => {
        if (e.checked) {
          statusLunas = e.value;
        }
      });

      let requestURL = "{{route('datatables.filter.pembelian', [':idSupplier', ':idDivisi', ':idBank', ':statusLunas', ':dateRange'])}}";
      requestURL = requestURL.replace(':idSupplier', idSupplier);
      requestURL = requestURL.replace(':idDivisi', idDivisi);
      requestURL = requestURL.replace(':idBank', idBank);
      requestURL = requestURL.replace(':statusLunas', statusLunas);
      requestURL = requestURL.replace(':dateRange', dateRange);

      const datatablesColumn = [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'tanggal_beli'
        },
        {
          data: 'nomor_pembelian'
        },
        {
          data: 'supplier.nama'
        },
        {
          data: 'divisi.nama'
        },
        {
          data: 'grand_total'
        },
        {
          data: 'status_pembayaran',
          render: (data) => {
            return data == 1 ? 'Lunas' : 'Belum Lunas';
          }
        },
        {
          data: 'ID_divisi',
          render: (data) => {
            return 'Rp.0';
          }
        },
        {
          data: 'nomor_pembelian',
          render: (data) => {
            let requestURL = "{{route('pembelian.detail', ':nomorPembelian')}}";
            requestURL = requestURL.replace(':nomorPembelian', data);

            return `<a href="${requestURL}" class="btn btn-info btn-sm">Detail</a>`
          }
        }
      ];

      if ($.fn.dataTable.isDataTable('#data__table__pembelian')) {
        $('#data__table__pembelian').DataTable().destroy();
        $('#data__table__pembelian').DataTable({
          processing: true,
          serverSide: true,
          ajax: requestURL,
          columns: datatablesColumn
        });
      } else {
        $('#data__table__pembelian').DataTable({
          processing: true,
          serverSide: true,
          ajax: requestURL,
          columns: datatablesColumn
        });
      }
    });
  });
</script>
@endpush