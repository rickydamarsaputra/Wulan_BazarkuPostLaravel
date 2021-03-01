@extends('layout.dashboard')
@section('title', 'Pembelian Detail Page')

@section('content')
<div class="section-header d-flex justify-content-between">
  <h1>@yield('title')</h1>
  <div>
    <a href="{{route('pembelian.index')}}" class="btn btn-info">Kembali</a>
    @if(auth()->user()->role->nama_role != "Kasir")
    <a href="{{route('pembelian.choose.divisi')}}" class="btn btn-primary mx-2">Tambah Pembelian</a>
    @endif
    <a href="{{route('pembelian.print.invoice', $pembelian->nomor_pembelian)}}" target="BLANK" class="btn btn-danger">Print Invoice</a>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="bazarku__pembelian__section__one text-capitalize">
      <h6>divisi <span>{{$pembelian->divisi->nama}}</span></h6>
      <h6>nomor pembelian <span>{{$pembelian->nomor_pembelian}}</span></h6>
      <h6>supplier <span>{{$pembelian->supplier->nama}}</span></h6>
      <h6>tanggal pembelian <span>{{$pembelian->tanggal_beli}}</span></h6>
    </div>
    <div class="bazarku__line__break"></div>
    <div class="bazarku__pembelian__section__two">
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
          @foreach($pembelian->pembelianDetail as $loopItem)
          <tr>
            <td>{{$loopItem->produk->nama_produk}}</td>
            <td class="text-center">{{empty($loopItem->keterangan) ? "-" : $loopItem->keterangan}}</td>
            <td class="text-center">{{$loopItem->qty}}</td>
            <td class="text-center">Rp {{number_format($loopItem->harga_beli,0,'','.')}}</td>
            <td class="text-center">Rp {{number_format($loopItem->total,0,'','.')}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="bazarku__pembelian__section__three">
      <div class="row justify-content-between">
        <div class="col-lg-5">
          <h6 class="title"><i class="fas fa-paper-plane mr-2"></i><span>Tambahan</span></h6>
          <h6>keterangan <span>{{empty($pembelian->keterangan) ? '-' : $pembelian->keterangan}}</span></h6>
        </div>
        <div class="col-lg-5">
          <h6 class="title"><i class="far fa-money-bill-alt mr-2"></i><span>Pembayaran</span></h6>
          <h6>total <span>Rp {{number_format($pembelian->total,0,'','.')}}</span></h6>
          <h6>diskon <span> - Rp {{number_format($pembelian->diskon,0,'','.')}}</span></h6>
          <h6>pajak <span>Rp {{number_format($pembelian->pajak,0,'','.')}}</span></h6>
          <h6>jumlah total <span class="font-weight-bold">Rp {{number_format($pembelian->grand_total,0,'','.')}}</span></h6>
          <h6>dibayar <span class="font-weight-bold">Rp {{number_format($pembelian->sudah_bayar,0,'','.')}}</span></h6>
          <h6>bank <span>{{$pembelian->bank->nama_bank}}</span></h6>
        </div>
      </div>
    </div>
    @endsection

    @push('styles')
    <style>
      .bazarku__line__break {
        width: 100%;
        height: 2px;
        border-radius: 3px;
        background: #6c7989;
        margin: 1.5rem 0;
      }

      .bazarku__pembelian__section__one h6 {
        position: relative;
      }

      .bazarku__pembelian__section__one h6::after {
        content: ":";
        position: absolute;
        left: 10rem;
      }

      .bazarku__pembelian__section__one h6 span {
        position: absolute;
        left: 12rem;
        font-weight: 400;
      }

      .bazarku__pembelian__section__two {
        margin-bottom: 2.5rem;
      }

      .bazarku__pembelian__section__three .row .col-lg-5:nth-child(1) h6,
      .bazarku__pembelian__section__three .row .col-lg-5:nth-child(2) h6,
      .bazarku__pembelian__section__three .row .col-lg-5:nth-child(3) h6 {
        display: flex;
        justify-content: space-between;
        text-align: right;
        margin-bottom: 1rem;
        text-transform: capitalize;
      }

      .bazarku__pembelian__section__three .row .col-lg-5:nth-child(1) .title span,
      .bazarku__pembelian__section__three .row .col-lg-5:nth-child(2) .title span,
      .bazarku__pembelian__section__three .row .col-lg-5:nth-child(3) .title span {
        font-weight: bold;
      }

      .bazarku__pembelian__section__three .row .col-lg-5:nth-child(1) h6 span,
      .bazarku__pembelian__section__three .row .col-lg-5:nth-child(2) h6 span,
      .bazarku__pembelian__section__three .row .col-lg-5:nth-child(3) h6 span {
        font-weight: normal;
      }
    </style>
    @endpush