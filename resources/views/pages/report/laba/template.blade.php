<div id="bazarku__report__laba__rugi">
  <div class="text-capitalize text-center">
    <h6>bazarku gadget</h6>
    <div class="bazarku__line__break"></div>
    <h6>laporan laba/rugi divisi {{$divisi->nama ?? 'Semua Divisi'}}</h6>
    <div class="bazarku__line__break"></div>
    <h6>periode {{$dateFirst}} - {{$dateLast}}</h6>
  </div>
  <div class="text-capitalize bazarku__laba__pendapatan">
    <div class="bazarku__line__break"></div>
    <h6 class="title">pendapatan</h6>
    <div class="bazarku__line__break"></div>
    @foreach($pemasukan as $loopItem)
    <h6>· {{$loopItem['kode']}} - {{$loopItem['nama_transaksi']}} <span>Rp.{{number_format($loopItem['nominal'])}}</span></h6>
    <div class="bazarku__line__break"></div>
    @endforeach
    <h6>· TOTAL PENJUALAN <span>Rp.{{number_format($totalPenjualan)}}</span></h6>
    <div class="bazarku__line__break"></div>
    <h6> · RETUR PEMBELIAN <span>Rp.{{number_format($returPembelian)}}</span></h6>
    <div class="bazarku__line__break"></div>
    <div class="d-flex justify-content-between text-success">
      <h6>TOTAL PENDAPATAN</h6>
      <h6><span>Rp.{{number_format($totalPemasukan)}}</span></h6>
    </div>
    <div class="bazarku__line__break"></div>
    <div class="bazarku__line__break mt-5"></div>
  </div>
  <div class="text-capitalize bazarku__laba__beban">
    <h6 class="title">beban usaha</h6>
    <div class="bazarku__line__break"></div>
    @foreach($pengeluaran as $loopItem)
    <h6>· {{$loopItem['kode']}} - {{$loopItem['nama_transaksi']}} <span>Rp.{{number_format($loopItem['nominal'])}}</span></h6>
    <div class="bazarku__line__break"></div>
    @endforeach
    <h6> · RETUR PENJUALAN <span>Rp.{{number_format($returPenjualan)}}</span></h6>
    <div class="bazarku__line__break"></div>
    <h6>· HARGA POKOK PENJUALAN <span>Rp.{{number_format($hpp)}}</span></h6>
    <div class="bazarku__line__break"></div>
    <div class="d-flex justify-content-between text-danger">
      <h6>TOTAL BEBAN</h6>
      <h6><span>Rp.{{number_format($totalPengeluaran)}}</span></h6>
    </div>
    <div class="bazarku__line__break"></div>
  </div>
  <div class="bazarku__laba__total__pendapatan mt-4">
    <div class="d-flex justify-content-between">
      <h6 class="title">LABA USAHA</h6>
      <h6><span>Rp.{{number_format($labaUsaha)}}</span></h6>
    </div>
  </div>
</div>