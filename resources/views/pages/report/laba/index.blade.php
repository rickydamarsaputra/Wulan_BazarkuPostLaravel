@extends('layout.dashboard')
@section('title', 'Laba Rugi Page')

@section('content')
<div class="section-header">
  <h1>@yield('title')</h1>
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
  <div class="bazarku__loading">
    <!-- <h1>harap tunggu...</h1> -->
    <i class="fas fa-spinner fa-pulse"></i>
  </div>
  <div class="card-body"></div>
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

  #bazarku__laba__info .bazarku__loading {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 2.5rem 0;
  }

  #bazarku__laba__info .bazarku__loading i {
    font-size: 2.5rem !important;
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
    $("#bazarku__laba__info .card-body").hide();
    $("#bazarku__laba__info .bazarku__loading").hide();
    $("#bazarku__form__filter__laba").on("submit", async (e) => {
      $("#bazarku__laba__info .card-body").hide();
      $("#bazarku__laba__info .bazarku__loading").show();
      e.preventDefault();
      const divisiId = $("#bazarku__choose__divisi").val() == "Semua Divisi" ? 0 : $("#bazarku__choose__divisi").val();
      const salesId = $("#bazarku__choose__sales").val() == "Semua Sales" ? 0 : $("#bazarku__choose__sales").val();
      const dateRange = $("#date__range").val();
      let requestURL = "{{route('helpers.laba.filter', [':divisiId', ':salesId', ':dateRange'])}}";
      requestURL = requestURL.replace(":divisiId", divisiId);
      requestURL = requestURL.replace(":salesId", salesId);
      requestURL = requestURL.replace(":dateRange", dateRange);
      const response = await axios.get(requestURL);

      $('#bazarku__report__laba__rugi').remove();
      $('#bazarku__laba__info .card-body').append(response.data);

      $("#bazarku__laba__info .card-body").show();
      $("#bazarku__laba__info .bazarku__loading").hide();
      // console.log(response.data);

      // const {
      //   data: {
      //     divisi,
      //     date_range,
      //     pajak,
      //     ongkir_masuk,
      //     ongkir,
      //     total_penjualan,
      //     total_pendapatan,
      //     pindah_dana_keluar,
      //     pindah_dana_masuk,
      //     retur_penjualan,
      //     retur_pembelian,
      //     transaksi_akuntansi_masuk,
      //     transaksi_akuntansi_keluar,
      //     diskon,
      //     pengeluaran_dll,
      //     hpp_penjualan,
      //     total_beban,
      //     laba_usaha,
      //     promosi_ig,
      //     promosi_toped,
      //     promosi_shopee,
      //     gaji,
      //     operasional
      //   }
      // } = await axios.get(requestURL);

      // $("#divisi").text(divisi);
      // $("#date__range__laba").text(date_range);
      // $("#bazarku__pajak").text(`Rp.${pajak}`);
      // $("#bazarku__ongkir__masuk").text(`Rp.${ongkir_masuk}`);
      // $("#bazarku__ongkir").text(`Rp.${ongkir}`);
      // $("#bazarku__promosi__ig").text(`Rp.${promosi_ig}`);
      // $("#bazarku__promosi__tokopedia").text(`Rp.${promosi_toped}`);
      // $("#bazarku__promosi__shopee").text(`Rp.${promosi_shopee}`);
      // $("#bazarku__total__penjualan").text(`Rp.${total_penjualan}`);
      // $("#bazarku__retur__penjualan").text(`Rp.${retur_penjualan}`);
      // $("#bazarku__retur__pembelian").text(`Rp.${retur_pembelian}`);
      // $("#bazarku__transaksi__akuntansi__masuk").text(`Rp.${transaksi_akuntansi_masuk}`);
      // $("#bazarku__transaksi__akuntansi__keluar").text(`Rp.${transaksi_akuntansi_keluar}`);
      // $("#bazarku__total__pendapatan").text(`Rp.${total_pendapatan}`);
      // $("#bazarku__pindah__dana__masuk").text(`Rp.${pindah_dana_masuk}`);
      // $("#bazarku__pindah__dana__keluar").text(`Rp.${pindah_dana_keluar}`);
      // $("#bazarku__diskon").text(`Rp.${diskon}`);
      // $("#bazarku__pengeluaran__dll").text(`Rp.${pengeluaran_dll}`);
      // $("#bazarku__hpp__penjualan").text(`Rp.${hpp_penjualan}`);
      // $("#bazarku__total__beban").text(`Rp.${total_beban}`);
      // $("#bazarku__laba__usaha").text(`Rp.${laba_usaha}`);
      // $("#bazarku__gaji").text(`Rp.${gaji}`);
      // $("#bazarku__operasional").text(`Rp.${operasional}`);
    });
  });
</script>
@endpush