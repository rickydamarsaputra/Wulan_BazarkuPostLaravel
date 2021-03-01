<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice - {{$pembelian->nomor_pembelian}}</title>

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

    .bazarku__invoice__section__four .table__pembelian table {
      width: 100%;
      border: 1.5px solid black;
      border-collapse: collapse;
    }

    .bazarku__invoice__section__four .table__pembelian table thead tr td {
      text-align: center;
    }

    .bazarku__invoice__section__four .table__pembelian table tr td {
      padding: .5rem;
      border: 1.5px solid black;
    }

    .keterangan__pembelian {
      margin-top: 1.5rem;
    }

    .keterangan__pembelian div:nth-child(1) {
      float: left;
    }

    .keterangan__pembelian div:nth-child(2) {
      float: right;
    }
  </style>

</head>

<body>
  <div class="bazarku__wrapper__invoice">
    <div class="bazarku__invoice__section__four">
      <div class="info">
        <h4>{{$pembelian->nomor_pembelian}}</h4>
        <h4 class="date">{{$pembelian->tanggal_beli}}</h4>
      </div>
      <div class="table__pembelian">
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
            @foreach($pembelian->pembelianDetail as $loopPenjual)
            <tr>
              <td>
                {{empty($loopPenjual->produk->nama_produk) ? "-" : $loopPenjual->produk->nama_produk}}
              </td>
              <td>{{$loopPenjual->qty}}</td>
              <td>Rp {{number_format($loopPenjual->harga_beli,0,'','.')}}</td>
              <td>Rp {{number_format($loopPenjual->total,0,'','.')}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="bazarku__invoice__section__five">
      <div class="keterangan__pembelian">
        <div class="two">
          <h4>Supplier : <span>{{$pembelian->supplier->nama}}</span></h4>
          <h4>Divisi : <span>{{$pembelian->divisi->nama}}</span></h4>
          <h4>Keterangan : <span>{{empty($pembelian->keterangan) ? '-' : $pembelian->keterangan}}</span></h4>
        </div>
        <div class="two">
          <h4>Ongkos Kirim : <span>Rp {{number_format($pembelian->ongkir,0,'','.')}}</span></h4>
          <h4>Diskon : <span>Rp {{number_format($pembelian->diskon,0,'','.')}}</span></h4>
          <h4>Pajak : <span>Rp {{number_format($pembelian->pajak,0,'','.')}}</span></h4>
          <h4>Jumlah Total : <span>Rp {{number_format($pembelian->grand_total,0,'','.')}}</span></h4>
        </div>
      </div>
    </div>
  </div>
</body>

</html>