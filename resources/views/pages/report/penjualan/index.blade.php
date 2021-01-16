@extends('layout.dashboard')
@section('title', 'Penjualan Page')

@section('content')
<div class="section-header">
  <h1>@yield('title')</h1>
</div>
<div class="card">
  <div class="card-body">
    <form action="" method="POST" id="bazarku__form__filter__penjualan">
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-1 mr-2 text-nowrap">Pelanggan</label>
        <div class="col-lg">
          <select class="form-control choose__pelanggan" id="bazarku__choose__pelanggan" name="pelanggan_id">
            <option>Semua Pelanggan</option>
            @foreach($pelanggan as $loopItem)
            <option value="{{$loopItem->ID_pelanggan}}">{{$loopItem->nama_pelanggan}}</option>
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
        <label class="col-form-label text-md-right col-lg-1 mr-2">Sales</label>
        <div class="col-lg">
          <select class="form-control choose__sales" id="bazarku__choose__sales" name="sales_id">
            <option>Semua Sales</option>
            @foreach($sales as $loopItem)
            <option value="{{$loopItem->ID_sales}}">{{$loopItem->nama_sales}}</option>
            @endforeach
          </select>
          <small class="form-text text-danger text-capitalize"></small>
        </div>
      </div>
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-1 mr-2 text-nowrap">Ekspedisi</label>
        <div class="col-lg">
          <select class="form-control choose__ekspedisi" id="bazarku__choose__ekspedisi" name="ekspedisi_id">
            <option>Semua Ekspedisi</option>
            @foreach($ekspedisi as $loopItem)
            <option value="{{$loopItem->ID_ekspedisi}}">{{$loopItem->nama_ekspedisi}}</option>
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
<div class="card" id="bazarku__penjualan__info">
  <div class="card-body">
    <div class="bazarku__penjualan__count__info">
      <h6>total nilai<span id="bazarku__total__nilai"></span></h6>
      <h6>total ongkos kirim<span id="bazarku__total__ongkos__kirim"></span></h6>
      <h6>total diskon<span id="bazarku__total__diskon"></span></h6>
      <h6>total pajak<span id="bazarku__total__pajak"></span></h6>
      <h6>total grand total<span id="bazarku__grand__total"></span></h6>
    </div>
    <div class="table-responsive">
      <table class="table table-striped" id="data__table__penjualan">
        <thead>
          <tr class="text-uppercase">
            <th class="text-center">#</th>
            <th class="text-center">tanggal jual</th>
            <th class="text-center">no. penjualan</th>
            <!-- <th class="text-center">pelanggan</th>
            <th class="text-center">penerima</th> -->
            <th class="text-center">divisi</th>
            <th class="text-center">sales</th>
            <th class="text-center">ekspedisi</th>
            <th class="text-center">bank</th>
            <th class="text-center">total</th>
            <th class="text-center">diskon</th>
            <th class="text-center">ongkos kirim</th>
            <th class="text-center">pajak</th>
            <th class="text-center">grand total</th>
            <th class="text-center">dibayar</th>
            <th class="text-center">status lunas</th>
            <!-- <th class="text-center">tagihan</th> -->
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
    const rupiahFormat = (data) => {
      let reverse = data.toString().split('').reverse().join('');
      ribuan = reverse.match(/\d{1,3}/g);
      ribuan = ribuan.join('.').split('').reverse().join('');
      return `Rp.${ribuan}`;
    }
    const datatablesColumn = [{
        data: 'DT_RowIndex',
        orderable: false,
        searchable: false
      },
      {
        data: 'tanggal_jual'
      },
      {
        data: 'nomor_penjualan'
      },
      {
        data: 'divisi.nama',
        defaultContent: '-'
      },
      {
        data: 'sales.nama_sales',
        defaultContent: '-'
      },
      {
        data: 'ekspedisi.nama_ekspedisi',
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
        data: 'ongkir',
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
          return data ? 'Lunas' : 'Belum Lunas';
        }
      },
      {
        data: "nomor_penjualan",
        render: (data) => {
          let requestURL = "{{route('penjualan.detail', ':nomorPenjualan')}}";
          requestURL = requestURL.replace(":nomorPenjualan", data);
          return `<a href="${requestURL}" class="btn btn-primary btn-sm text-capitalize">detail</a>`
        }
      }
    ];

    $('.daterange-cus').daterangepicker({
      locale: {
        format: 'YYYY-MM-DD'
      },
      drops: 'down',
      opens: 'right'
    });

    $('#bazarku__penjualan__info').hide();
    $('#bazarku__form__filter__penjualan').on('submit', async (e) => {
      e.preventDefault();
      const pelangganId = $('#bazarku__choose__pelanggan').val();
      const divisiId = $('#bazarku__choose__divisi').val();
      const salesId = $('#bazarku__choose__sales').val();
      const ekspedisiId = $('#bazarku__choose__ekspedisi').val();
      const bankId = $('#bazarku__choose__bank').val();
      const statusLunas = $('#bazarku__lunas').prop('checked') ? 1 : 0;
      const dateRange = $('#bazarku__date__range').val();
      // const sortBy = $('#bazarku__choose__sort__by').val();
      // const sort = $('#bazarku__choose__sort__asc__or__desc').val();

      let requestURL = "{{route('datatables.report.penjualan', [':pelangganId', ':divisiId', ':salesId', ':ekspedisiId', ':bankId', ':status', ':dateRange'])}}";
      requestURL = requestURL.replace(':pelangganId', pelangganId);
      requestURL = requestURL.replace(':divisiId', divisiId);
      requestURL = requestURL.replace(':salesId', salesId);
      requestURL = requestURL.replace(':ekspedisiId', ekspedisiId);
      requestURL = requestURL.replace(':bankId', bankId);
      requestURL = requestURL.replace(':status', statusLunas);
      requestURL = requestURL.replace(':dateRange', dateRange);

      let requestPenjualan = "{{route('helpers.penjualan.count', [':pelangganId', ':divisiId', ':salesId', ':ekspedisiId', ':bankId', ':status', ':dateRange'])}}";
      requestPenjualan = requestPenjualan.replace(':pelangganId', pelangganId);
      requestPenjualan = requestPenjualan.replace(':divisiId', divisiId);
      requestPenjualan = requestPenjualan.replace(':salesId', salesId);
      requestPenjualan = requestPenjualan.replace(':ekspedisiId', ekspedisiId);
      requestPenjualan = requestPenjualan.replace(':bankId', bankId);
      requestPenjualan = requestPenjualan.replace(':status', statusLunas);
      requestPenjualan = requestPenjualan.replace(':dateRange', dateRange);

      const {
        data
      } = await axios.get(requestPenjualan);
      $('#bazarku__total__nilai').text(rupiahFormat(data.total_nilai));
      $('#bazarku__total__ongkos__kirim').text(rupiahFormat(data.total_ongkos_kirim));
      $('#bazarku__total__diskon').text(rupiahFormat(data.total_diskon));
      $('#bazarku__total__pajak').text(rupiahFormat(data.total_pajak));
      $('#bazarku__total__pajak').text(rupiahFormat(data.total_pajak));
      $('#bazarku__grand__total').text(rupiahFormat(data.total_grand_total));

      if ($.fn.dataTable.isDataTable('#data__table__penjualan')) {
        $('#data__table__penjualan').DataTable().destroy();
        $('#data__table__penjualan').DataTable({
          processing: true,
          serverSide: true,
          ajax: requestURL,
          columns: datatablesColumn
        });
      } else {
        $('#data__table__penjualan').DataTable({
          processing: true,
          serverSide: true,
          ajax: requestURL,
          columns: datatablesColumn
        });
      }
      $('#bazarku__penjualan__info').show();
    });

  });
</script>
@endpush

@push('styles')
<style>
  .bazarku__penjualan__count__info {
    margin: 2rem 0;
  }

  .bazarku__penjualan__count__info h6 {
    text-transform: capitalize;
    position: relative;
  }

  .bazarku__penjualan__count__info h6::after {
    content: ":";
    position: absolute;
    left: 10rem;
  }

  .bazarku__penjualan__count__info h6 span {
    font-weight: normal;
    position: absolute;
    left: 12rem;
  }
</style>
@endpush