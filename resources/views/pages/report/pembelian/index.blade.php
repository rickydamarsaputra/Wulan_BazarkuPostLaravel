@extends('layout.dashboard')
@section('sectionTitle', 'Pembelian Page')

@section('content')
<div class="section-header">
  <h1>@yield('sectionTitle')</h1>
</div>
<div class="card">
  <div class="card-body">
    <form action="" method="POST" id="bazarku__form__filter__pembelian">
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-1 mr-2">Supplier</label>
        <div class="col-lg">
          <select class="form-control choose__supplier" id="bazarku__choose__supplier" name="supplier_id">
            <option>Semua Supplier</option>
            @foreach($supplier as $supp)
            <option value="{{$supp->ID_supplier}}">{{$supp->nama}}</option>
            @endforeach
          </select>
          <small class="form-text text-danger text-capitalize"></small>
        </div>
      </div>
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
        <label class="col-form-label text-md-right col-lg-1 mr-2">Bank</label>
        <div class="col-lg">
          <select class="form-control choose__bank" id="bazarku__choose__bank" name="bank_id">
            <option>Semua Bank</option>
            @foreach($bank as $ban)
            <option value="{{$ban->ID_bank}}">{{$ban->nama_bank}}</option>
            @endforeach
          </select>
          <small class="form-text text-danger text-capitalize"></small>
        </div>
      </div>
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-1 mr-2 text-nowrap">Status Lunas</label>
        <div class="col-lg">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="bazarku__lunas" checked>
            <label class="form-check-label" for="bazarku__lunas">
              Lunas
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="bazarku__belum__lunas">
            <label class="form-check-label" for="bazarku__belum__lunas">
              Belum Lunas
            </label>
          </div>
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
<div class="card" id="bazarku__pembelian__info">
  <div class="card-body">
    <div class="bazarku__pembelian__count__info">
      <h6>total nilai<span id="bazarku__total__nilai"></span></h6>
      <h6>total diskon<span id="bazarku__total__diskon"></span></h6>
      <h6>total pajak<span id="bazarku__total__pajak"></span></h6>
      <h6>total grand total<span id="bazarku__grand__total"></span></h6>
    </div>
    <div class="table-responsive">
      <table class="table table-striped" id="data__table__pembelian">
        <thead>
          <tr class="text-uppercase">
            <th class="text-center">#</th>
            <th class="text-center">tanggal beli</th>
            <th class="text-center">no. pembelian</th>
            <th class="text-center">supplier</th>
            <th class="text-center">divisi</th>
            <th class="text-center">bank</th>
            <th class="text-center">total</th>
            <th class="text-center">diskon</th>
            <th class="text-center">pajak</th>
            <th class="text-center">grand total</th>
            <th class="text-center">dibayar</th>
            <th class="text-center">status lunas</th>
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

    $('#bazarku__pembelian__info').hide();
    $('#bazarku__form__filter__pembelian').on('submit', async (e) => {
      e.preventDefault();
      const supplierId = $('#bazarku__choose__supplier').val();
      const divisiId = $('#bazarku__choose__divisi').val();
      const bankId = $('#bazarku__choose__bank').val();
      const statusLunas = $('#bazarku__lunas').prop('checked') ? 1 : 0;
      const dateRange = $('#bazarku__date__range').val();
      const sortBy = $('#bazarku__choose__sort__by').val();
      const sort = $('#bazarku__choose__sort__asc__or__desc').val();

      let requestURL = "{{route('datatables.pembelian', [':supplierId', ':divisiId', ':bankId', ':status', ':dateRange', ':sortBy', ':sort'])}}"
      requestURL = requestURL.replace(':supplierId', supplierId);
      requestURL = requestURL.replace(':divisiId', divisiId);
      requestURL = requestURL.replace(':bankId', bankId);
      requestURL = requestURL.replace(':status', statusLunas);
      requestURL = requestURL.replace(':dateRange', dateRange);
      requestURL = requestURL.replace(':sortBy', sortBy);
      requestURL = requestURL.replace(':sort', sort);

      let requestPembelian = "{{route('helpers.pembelian.count', [':supplierId', ':divisiId', ':bankId', ':status', ':dateRange'])}}";
      requestPembelian = requestPembelian.replace(':supplierId', supplierId);
      requestPembelian = requestPembelian.replace(':divisiId', divisiId);
      requestPembelian = requestPembelian.replace(':bankId', bankId);
      requestPembelian = requestPembelian.replace(':status', statusLunas);
      requestPembelian = requestPembelian.replace(':dateRange', dateRange);

      const {
        data: {
          total_nilai,
          total_diskon,
          total_pajak,
          total_grand_total
        }
      } = await axios.get(requestPembelian);
      $('#bazarku__total__nilai').text(`Rp.${total_nilai}`);
      $('#bazarku__total__diskon').text(`Rp.${total_diskon}`);
      $('#bazarku__total__pajak').text(`Rp.${total_pajak}`);
      $('#bazarku__grand__total').text(`Rp.${total_grand_total}`);

      const rupiahFormat = (data) => {
        let reverse = data.toString().split('').reverse().join('');
        ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return `Rp.${ribuan}`;
      }

      if ($.fn.dataTable.isDataTable('#data__table__pembelian')) {
        $('#data__table__pembelian').DataTable().destroy();
        $('#data__table__pembelian').DataTable({
          processing: true,
          serverSide: true,
          ajax: requestURL,
          columns: [{
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
              data: 'supplier.nama',
              defaultContent: '-'
            },
            {
              data: 'divisi.nama',
              defaultContent: '-'
            },
            {
              data: 'bank.nama_bank',
              defaultContent: '-'
            },
            {
              data: 'total',
              render: (data) => {
                return rupiahFormat(data);
              }
            },
            {
              data: 'diskon',
              render: (data) => {
                return rupiahFormat(data);
              }
            },
            {
              data: 'pajak',
              render: (data) => {
                return rupiahFormat(data);
              }
            },
            {
              data: 'grand_total',
              render: (data) => {
                return rupiahFormat(data);
              }
            },
            {
              data: 'sudah_bayar',
              render: (data) => {
                return rupiahFormat(data);
              }
            },
            {
              data: 'status_pembayaran',
              render: (data) => {
                return data ? 'LUNAS' : 'BELUM LUNAS';
              }
            }
          ],
        });
      } else {
        $('#data__table__pembelian').DataTable({
          processing: true,
          serverSide: true,
          ajax: requestURL,
          columns: [{
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
              data: 'supplier.nama',
              defaultContent: '-'
            },
            {
              data: 'divisi.nama',
              defaultContent: '-'
            },
            {
              data: 'bank.nama_bank',
              defaultContent: '-'
            },
            {
              data: 'total',
              render: (data) => {
                return rupiahFormat(data);
              }
            },
            {
              data: 'diskon',
              render: (data) => {
                return rupiahFormat(data);
              }
            },
            {
              data: 'pajak',
              render: (data) => {
                return rupiahFormat(data);
              }
            },
            {
              data: 'grand_total',
              render: (data) => {
                return rupiahFormat(data);
              }
            },
            {
              data: 'sudah_bayar',
              render: (data) => {
                return rupiahFormat(data);
              }
            },
            {
              data: 'status_pembayaran',
              render: (data) => {
                return data ? 'LUNAS' : 'BELUM LUNAS';
              }
            }
          ],
        });
      }
      $('#bazarku__pembelian__info').show();

    });
  });
</script>
@endpush

@push('styles')
<style>
  .bazarku__pembelian__count__info {
    margin: 2rem 0;
  }

  .bazarku__pembelian__count__info h6 {
    text-transform: capitalize;
    position: relative;
  }

  .bazarku__pembelian__count__info h6::after {
    content: ":";
    position: absolute;
    left: 10rem;
  }

  .bazarku__pembelian__count__info h6 span {
    font-weight: normal;
    position: absolute;
    left: 12rem;
  }
</style>
@endpush