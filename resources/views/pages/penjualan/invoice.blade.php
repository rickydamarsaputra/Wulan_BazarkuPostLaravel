<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice - {{$penjualan->nomor_penjualan}}</title>

  <style>
    * {
      font-family: Arial, Helvetica, sans-serif;
      margin: 0;
      padding: 0;
    }

    h4,
    p {
      margin-bottom: .5rem;
    }

    .bazarku__wrapper__invoice {
      margin: 1.5rem;
    }

    .bazarku__title {
      font-weight: bold;
    }

    .bazarku__title span {
      font-weight: normal;
    }

    .bazarku__invoice__section__three h4 {
      text-transform: uppercase;
      text-align: center;
    }

    .bazarku__invoice__section__three p {
      text-transform: capitalize;
      text-align: center;
    }

    .bazarku__invoice__break__line {
      width: 100%;
      height: 1.5px;
      background: #000;
    }

    .bazarku__invoice__section__three {
      margin: 1.5rem 0;
    }

    .bazarku__invoice__section__four {
      margin-top: 2rem;
    }

    .bazarku__invoice__section__four .info h4 {
      display: inline-block;
    }

    .bazarku__invoice__section__four .info .date {
      float: right;
    }

    .bazarku__invoice__section__four .table__penjualan table {
      width: 100%;
      border: 1.5px solid black;
      border-collapse: collapse;
    }

    .bazarku__invoice__section__four .table__penjualan table thead tr td {
      text-align: center;
    }

    .bazarku__invoice__section__four .table__penjualan table tr td {
      padding: .5rem;
      border: 1.5px solid black;
    }

    .bazarku__invoice__section__five {
      margin-top: 1.5rem;
    }

    .bazarku__invoice__section__five .keterangan__penjualan .one h4,
    .bazarku__invoice__section__five .keterangan__penjualan .two h4,
    .bazarku__invoice__section__five .keterangan__penjualan .three h4 {
      display: inline-block;
    }

    .bazarku__invoice__section__five .keterangan__penjualan .one h4 span,
    .bazarku__invoice__section__five .keterangan__penjualan .two h4 span,
    .bazarku__invoice__section__five .keterangan__penjualan .three h4 span {
      font-weight: normal;
    }

    .bazarku__invoice__section__five .keterangan__penjualan .one h4:nth-child(2),
    .bazarku__invoice__section__five .keterangan__penjualan .two h4:nth-child(2),
    .bazarku__invoice__section__five .keterangan__penjualan .three h4:nth-child(2) {
      float: right;
    }

    /* .bazarku__invoice__section__two {
      margin-top: 3rem;
    } */
  </style>

</head>

<body>
  <div class="bazarku__wrapper__invoice">
    <div class="bazarku__invoice__section__one">
      <h4 class="bazarku__title">Penerima</h4>
      <p>{{empty($penjualan->penerima->nama_pelanggan) ? "-" : $penjualan->penerima->nama_pelanggan}} - {{empty($penjualan->penerima->no_telp) ? "-" : $penjualan->penerima->no_telp}}</p>
      <p>{{empty($penjualan->penerima->alamat) ? "-" : $penjualan->penerima->alamat}}</p>
    </div>
    <div class="bazarku__invoice__section__two">
      <h4 class="bazarku__title">Keterangan</h4>
      <p>
        @if(empty($penjualan->keterangan))
        -
        @else
        {{$penjualan->keterangan}}
        @endif
      </p>
      <h4 class="bazarku__title">
        Pengirim : <span>{{empty($penjualan->nama_pengirim_dropship) ? "-" : $penjualan->nama_pengirim_dropship}} - {{empty($penjualan->divisi->no_telp) ? "-" : $penjualan->divisi->no_telp}}</span>
      </h4>
      <h4 class="bazarku__title">
        Ekspedisi : <span>{{empty($penjualan->ekspedisi->nama_ekspedisi) ? "-" : $penjualan->ekspedisi->nama_ekspedisi}} / Rp.{{number_format($penjualan->ongkir)}} / {{$penjualan->berat}}Kg</span>
      </h4>
    </div>
    <div class="bazarku__invoice__section__three">
      <h4>thanks you for shopping with us!</h4>
      <h4>firagile - jangan dibanting!!!</h4>
      <p>hanya melayani komplain yang melampirkan video unboxing paket.</p>
    </div>
    <div class="bazarku__invoice__break__line"></div>
    <div class="bazarku__invoice__section__four">
      <div class="info">
        <h4>{{$penjualan->nomor_penjualan}}</h4>
        <h4 class="date">{{$penjualan->tanggal_jual}}</h4>
      </div>
      <div class="table__penjualan">
        <table>
          <thead>
            <tr>
              <td>Produk</td>
              <td>Jml</td>
              <td>Harga</td>
              <td>Total</td>
            </tr>
          </thead>
          <tbody>
            @foreach($penjualan->penjualanDetail as $loopPenjual)
            <tr>
              <td>
                {{empty($loopPenjual->produk->nama_produk) ? "-" : $loopPenjual->produk->nama_produk}}
              </td>
              <td>{{$loopPenjual->qty}}</td>
              <td>Rp {{number_format($loopPenjual->harga_jual,0,'','.')}}</td>
              <td>Rp {{number_format($loopPenjual->total,0,'','.')}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="bazarku__invoice__section__five">
      <div class="keterangan__penjualan">
        <div class="one">
          <h4>Sales : <span>{{$penjualan->sales->nama_sales}}</span></h4>
          <h4>Total : <span>Rp {{number_format($penjualan->total,0,'','.')}}</span></h4>
        </div>
        <div class="two">
          <h4>Ongkos Kirim : <span>Rp {{number_format($penjualan->ongkir,0,'','.')}}</span></h4>
          <h4>Diskon : <span>Rp {{number_format($penjualan->diskon,0,'','.')}}</span></h4>
        </div>
        <div class="three">
          <h4>Pajak : <span>Rp {{number_format($penjualan->pajak,0,'','.')}}</span></h4>
          <h4>Jumlah Total : <span>Rp {{number_format($penjualan->grand_total,0,'','.')}}</span></h4>
        </div>
      </div>
    </div>
  </div>
</body>

</html>