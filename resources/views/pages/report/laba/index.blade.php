@extends('layout.dashboard')
@section('sectionTitle', 'Laba Rugi Page')

@section('content')
<div class="section-header">
  <h1>@yield('sectionTitle')</h1>
</div>
<div class="card">
  <div class="card-body">
    <form action="" method="POST" id="bazarku__form__filter__laba">
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-1">Divisi</label>
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
        <label class="col-form-label text-md-right col-lg-1">Sales</label>
        <div class="col-lg">
          <select class="form-control choose__sales" id="bazarku__choose__sales" name="sales_id">
            <option>Semua Sales</option>
            @foreach($sales as $sale)
            <option value="{{$sale->ID_sales}}">{{$sale->nama_sales}}</option>
            @endforeach
          </select>
          <small class="form-text text-danger text-capitalize"></small>
        </div>
      </div>
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-1 text-nowrap">Pilih Tanggal</label>
        <div class="col-lg">
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">
                <i class="fas fa-calendar"></i>
              </div>
            </div>
            <input type="text" class="form-control daterange-cus" id="date__range" name="date_range">
          </div>
        </div>
      </div>
      <button class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>
<div class="card" id="bazarku__laba__info">
  <div class="card-body">
    <div class="text-capitalize text-center">
      <h6>bazarku gadget</h6>
      <div class="bazarku__line__break"></div>
      <h6>laporan laba/rugi divisi <span id="divisi"></span></h6>
      <div class="bazarku__line__break"></div>
      <h6>periode <span id="date__range__laba"></span></h6>
    </div>
    <div class="text-capitalize bazarku__laba__pendapatan">
      <div class="bazarku__line__break"></div>
      <h6 class="title">pendapatan</h6>
      <div class="bazarku__line__break"></div>
      <h6>· 0000 - PAJAK (MASUK) <span id="bazarku__pajak"></span></h6>
      <div class="bazarku__line__break"></div>
      <h6>· 0000 - ONGKIR (MASUK) <span id="bazarku__ongkir"></span></h6>
      <div class="bazarku__line__break"></div>
      <h6>· PENJUALAN <span id="bazarku__total__penjualan"></span></h6>
      <div class="bazarku__line__break"></div>
      <h6> · RETUR PENJUALAN <span id="bazarku__retur__penjualan"></span></h6>
      <div class="bazarku__line__break"></div>
      <div class="d-flex justify-content-between text-success">
        <h6>TOTAL PENDAPATAN</h6>
        <h6><span id="bazarku__total__pendapatan"></span></h6>
      </div>
      <div class="bazarku__line__break"></div>
      <div class="bazarku__line__break mt-5"></div>
    </div>
    <div class="text-capitalize bazarku__laba__beban">
      <h6 class="title">beban usaha</h6>
      <div class="bazarku__line__break"></div>
      <h6>· 0000 - PINDAH DANA (KELUAR) <span id="bazarku__pindah__dana__keluar"></span></h6>
      <div class="bazarku__line__break"></div>
      <h6>· 0000 - DISKON <span id="bazarku__diskon"></span></h6>
      <div class="bazarku__line__break"></div>
      <h6>· 0000 - PENGELUARAN DLL <span id="bazarku__pengeluaran__dll"></span></h6>
      <div class="bazarku__line__break"></div>
      <h6>· HARGA POKOK PENJUALAN <span id="bazarku__hpp__penjualan"></span></h6>
      <div class="bazarku__line__break"></div>
      <div class="d-flex justify-content-between text-danger">
        <h6>TOTAL BEBAN</h6>
        <h6><span id="bazarku__total__beban"></span></h6>
      </div>
      <div class="bazarku__line__break"></div>
    </div>
    <div class="bazarku__laba__total__pendapatan mt-4">
      <div class="d-flex justify-content-between">
        <h6 class="title">LABA USAHA</h6>
        <h6><span id="bazarku__laba__usaha"></span></h6>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
  .bazarku__line__break {
    width: 100%;
    height: .2rem;
    margin-bottom: .5rem;
    background-color: #e9ecef;
  }

  .bazarku__laba__pendapatan h6,
  .bazarku__laba__beban h6 {
    font-weight: normal;
    font-size: .8rem;
    display: flex;
    justify-content: space-between;
  }

  .bazarku__laba__pendapatan h6.title,
  .bazarku__laba__beban h6.title,
  .bazarku__laba__total__pendapatan h6.title {
    font-weight: 800;
    font-size: 1rem;
  }
</style>
@endpush

@push('scripts')
<script>
  $(document).ready(() => {
    $("select").select2();
    $(".daterange-cus").daterangepicker({
      locale: {
        format: 'YYYY-MM-DD'
      },
      drops: 'down',
      opens: 'right'
    });

    $("#bazarku__laba__info").hide();
    $("#bazarku__form__filter__laba").on("submit", async (e) => {
      e.preventDefault();
      const divisiId = $("#bazarku__choose__divisi").val() == "Semua Divisi" ? 0 : $("#bazarku__choose__divisi").val();
      const salesId = $("#bazarku__choose__sales").val() == "Semua Sales" ? 0 : $("#bazarku__choose__sales").val();
      const dateRange = $("#date__range").val();
      let requestURL = "{{route('helpers.laba.filter', [':divisiId', ':salesId', ':dateRange'])}}";
      requestURL = requestURL.replace(":divisiId", divisiId);
      requestURL = requestURL.replace(":salesId", salesId);
      requestURL = requestURL.replace(":dateRange", dateRange);
      // const response = await axios.get(requestURL);
      // console.log(response.data);
      const {
        data: {
          divisi,
          date_range,
          pajak,
          ongkir,
          total_penjualan,
          nominal_retur,
          total_pendapatan,
          pindah_dana_keluar,
          diskon,
          pengeluaran_dll,
          hpp_penjualan,
          total_beban,
          laba_usaha
        }
      } = await axios.get(requestURL);

      $("#divisi").text(divisi);
      $("#date__range__laba").text(date_range);
      $("#bazarku__pajak").text(`Rp.${pajak}`);
      $("#bazarku__ongkir").text(`Rp.${ongkir}`);
      $("#bazarku__total__penjualan").text(`Rp.${total_penjualan}`);
      $("#bazarku__retur__penjualan").text(`Rp.${nominal_retur}`);
      $("#bazarku__total__pendapatan").text(`Rp.${total_pendapatan}`);
      $("#bazarku__pindah__dana__keluar").text(`Rp.${pindah_dana_keluar}`);
      $("#bazarku__diskon").text(`Rp.${diskon}`);
      $("#bazarku__pengeluaran__dll").text(`Rp.${pengeluaran_dll}`);
      $("#bazarku__hpp__penjualan").text(`Rp.${hpp_penjualan}`);
      $("#bazarku__total__beban").text(`Rp.${total_beban}`);
      $("#bazarku__laba__usaha").text(`Rp.${laba_usaha}`);

      $("#bazarku__laba__info").show();
    });
  });
</script>
@endpush