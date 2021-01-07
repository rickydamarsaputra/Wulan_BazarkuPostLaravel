@extends('layout.dashboard')
@section('sectionTitle', 'Penjualan Detail')

@section('content')
<div class="section-header d-flex justify-content-between">
  <h1>@yield('sectionTitle') - {{$penjualan->nomor_penjualan}}</h1>
  <div>
    <a href="{{route('penjualan.index')}}" class="btn btn-info">Kembali</a>
    <a href="{{route('penjualan.choose.divisi')}}" class="btn btn-primary mx-2">Tambah Penjualan</a>
    <a href="{{route('penjualan.print.invoice', $penjualan->nomor_penjualan)}}" class="btn btn-danger">Print Invoice</a>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="bazarku__penjualan__section__one text-capitalize">
      <h6>divisi <span>{{$penjualan->divisi->nama}}</span></h6>
      <h6>nomor penjualan <span>{{$penjualan->nomor_penjualan}}</span></h6>
      <h6>pelanggan <span>{{$penjualan->pelanggan->nama_pelanggan}}</span></h6>
      <h6>sales <span>{{$penjualan->sales->nama_sales}}</span></h6>
      <h6>tanggal penjualan <span>{{$penjualan->tanggal_jual}}</span></h6>
    </div>
    <div class="bazarku__line__break"></div>
    <div class="bazarku__penjualan__section__two">
      <table class="table table-bordered">
        <thead>
          <tr class="text-uppercase text-center">
            <td>produk</td>
            <td>keterangan</td>
            <td>jumlah</td>
            <td>harga</td>
            <td>total</td>
          </tr>
        </thead>
        <tbody>
          @foreach($penjualan->penjualanDetail as $loopItem)
          <tr>
            <td>{{empty($loopItem->produk->nama_produk) ? "-" : $loopItem->produk->nama_produk}}</td>
            <td class="text-center">{{empty($loopItem->keterangan) ? "-" : $loopItem->keterangan}}</td>
            <td class="text-center">{{$loopItem->qty}}</td>
            <td class="text-center">Rp {{number_format($loopItem->harga_jual,0,'','.')}}</td>
            <td class="text-center">Rp {{number_format($loopItem->total,0,'','.')}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="bazarku__penjualan__section__three">
      <div class="row">
        <div class="col-lg">
          <h6 class="title"><i class="fas fa-paper-plane mr-2"></i><span>Penerima</span></h6>
          <h6>{!! empty($penjualan->penerima) ? "-" : $penjualan->penerima !!}</h6>
          <div class="bazarku__line__break"></div>
          <div>
            <div class="d-flex justify-content-between">
              <h6>dropship</h6>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" disabled id="bazarku__dropshipping">
                <label class="form-check-label" for="bazarku__dropshipping">
                  Dropshipping
                </label>
              </div>
            </div>
            <h6>pengirim <span>{{$penjualan->nama_pengirim_dropship}}</span></h6>
          </div>
        </div>
        <div class="col-lg">
          <h6 class="title"><i class="fas fa-boxes mr-2"></i><span>Paket Order</span></h6>
          <h6>ekspedisi <span>{{empty($penjualan->ekspedisi->nama_ekspedisi) ? "-" : $penjualan->ekspedisi->nama_ekspedisi}}</span></h6>
          <h6>berat <span>{{$penjualan->berat}}Kg</span></h6>
          <h6>keterangan <span>{{$penjualan->keterangan}}</span></h6>
        </div>
        <div class="col-lg">
          <h6 class="title"><i class="far fa-money-bill-alt mr-2"></i><span>Pembayaran</span></h6>
          <h6>total <span>Rp {{number_format($penjualan->total,0,'','.')}}</span></h6>
          <h6>ongkos kirim <span>Rp {{number_format($penjualan->ongkir,0,'','.')}}</span></h6>
          <h6>diskon <span> - Rp {{number_format($penjualan->diskon,0,'','.')}}</span></h6>
          <h6>pajak <span>Rp {{number_format($penjualan->pajak,0,'','.')}}</span></h6>
          <h6>jumlah total <span class="font-weight-bold">Rp {{number_format($penjualan->grand_total,0,'','.')}}</span></h6>
          <h6>dibayar <span class="font-weight-bold">Rp {{number_format($penjualan->sudah_bayar,0,'','.')}}</span></h6>
          <h6>bank <span>{{$penjualan->bank->nama_bank}}</span></h6>
        </div>
      </div>
    </div>
  </div>
  @endsection

  @push('scripts')
  <script>
    $(document).ready(() => {
      const statusDropship = "{{$penjualan->status_dropship}}" == 0 ? false : true;
      $("#bazarku__dropshipping").prop("checked", statusDropship);
    });
  </script>
  @endpush

  @push('styles')
  <style>
    .bazarku__line__break {
      width: 100%;
      height: 2px;
      border-radius: 3px;
      background: #6c7989;
      margin: 1.5rem 0;
    }

    .bazarku__penjualan__section__one h6 {
      position: relative;
    }

    .bazarku__penjualan__section__one h6::after {
      content: ":";
      position: absolute;
      left: 10rem;
    }

    .bazarku__penjualan__section__one h6 span {
      position: absolute;
      left: 12rem;
      font-weight: 400;
    }

    .bazarku__penjualan__section__two {
      margin-bottom: 2.5rem;
    }

    /* .bazarku__penjualan__section__three .row .col-lg:nth-child(1) .title,
    .bazarku__penjualan__section__three .row .col-lg:nth-child(2) .title,
    .bazarku__penjualan__section__three .row .col-lg:nth-child(3) .title {
      display: inline-block;
      text-transform: capitalize;
    } */

    .bazarku__penjualan__section__three .row .col-lg:nth-child(1) h6,
    .bazarku__penjualan__section__three .row .col-lg:nth-child(2) h6,
    .bazarku__penjualan__section__three .row .col-lg:nth-child(3) h6 {
      display: flex;
      justify-content: space-between;
      text-align: right;
      margin-bottom: 1rem;
      text-transform: capitalize;
    }

    .bazarku__penjualan__section__three .row .col-lg:nth-child(1) .title span,
    .bazarku__penjualan__section__three .row .col-lg:nth-child(2) .title span,
    .bazarku__penjualan__section__three .row .col-lg:nth-child(3) .title span {
      font-weight: bold;
    }

    .bazarku__penjualan__section__three .row .col-lg:nth-child(1) h6 span,
    .bazarku__penjualan__section__three .row .col-lg:nth-child(2) h6 span,
    .bazarku__penjualan__section__three .row .col-lg:nth-child(3) h6 span {
      font-weight: normal;
    }
  </style>
  @endpush