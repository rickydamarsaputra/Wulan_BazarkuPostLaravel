@extends('layout.dashboard')
@section('title', 'Penjualan Page')

@section('content')
<div x-data="{itemToggle: 'detail'}">
  <div class="section-header d-flex justify-content-between">
    <h1>@yield('title')</h1>
    <div>
      <button @click="itemToggle = 'detail'" :class="{'btn-primary' : itemToggle == 'detail', 'btn-info' : itemToggle != 'detail'}" class="btn text-uppercase mr-2">detail</button>
      <button @click="itemToggle = 'table'" :class="{'btn-primary' : itemToggle == 'table', 'btn-info' : itemToggle != 'table'}" class="btn text-uppercase">tabel</button>
    </div>
  </div>
  <div class="card" x-show="itemToggle == 'detail'">
    <div class="card-body">
      <h5 class="card-title">Detail Penjualan</h5>
      <ul class="list-group">
        <li class="list-group-item d-flex justify-content-between">
          <div>Total Nilai</div>
          <div>Rp.{{number_format($totalNilai)}}</div>
        </li>
        <li class="list-group-item d-flex justify-content-between">
          <div>Total Ongkos Kirim</div>
          <div>Rp.{{number_format($totalOngkir)}}</div>
        </li>
        <li class="list-group-item d-flex justify-content-between">
          <div>Total Diskon</div>
          <div>Rp.{{number_format($totalDiskon)}}</div>
        </li>
        <li class="list-group-item d-flex justify-content-between">
          <div>Total Pajak</div>
          <div>Rp.{{number_format($totalPajak)}}</div>
        </li>
        <li class="list-group-item d-flex justify-content-between">
          <div>Total Grand Total</div>
          <div>Rp.{{number_format($totalGrandTotal)}}</div>
        </li>
      </ul>
    </div>
  </div>
  <div class="card" x-show="itemToggle == 'table'">
    <div class="card-body">
      <div class="d-flex justify-content-end mb-4">
        <a href="{{route('penjualan.choose.divisi')}}" class="btn btn-primary"><i class="far fa-plus-square mr-2"></i><span>Tambah Penjualan</span></a>
      </div>
      <div class="table-responsive">
        <table class="table table-striped text-uppercase" id="data__table__penjualan">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th>Tanggal Jual</th>
              <th>NO.Penjualan</th>
              <!-- <th>Penerima</th> -->
              <th>Divisi</th>
              <th>Sales</th>
              <th>Ekspedisi</th>
              <th>Bank</th>
              <th>Grand Total</th>
              <th>Status</th>
              <th>Detail</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
  table#data__table__penjualan {
    width: -webkit-fill-available !important;
  }
</style>
@endpush

@push('scripts')
<script>
  $(document).ready(() => {
    $("#data__table__penjualan").DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      ajax: "{{route('datatables.penjualan')}}",
      columns: [{
          data: "DT_RowIndex",
          orderable: false,
          searchable: false
        },
        {
          data: "tanggal_jual"
        },
        {
          data: "nomor_penjualan"
        },
        {
          data: "divisi.nama"
        },
        {
          data: "sales.nama_sales",
          defaultContent: "-"
        },
        {
          data: "ekspedisi.nama_ekspedisi",
          defaultContent: "-"
        },
        {
          data: "bank.nama_bank",
          defaultContent: "-"
        },
        {
          data: "grand_total",
          render: (data) => {
            let reverse = data.toString().split('').reverse().join('');
            ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');
            return `Rp.${ribuan}`;
          }
        },
        {
          data: "status_pembayaran",
          render: (data) => {
            return data ? "Lunas" : "Belum Lunas";
          }
        },
        {
          data: "nomor_penjualan",
          render: (data) => {
            let requestURL = "{{route('penjualan.detail', ':nomorPenjualan')}}";
            requestURL = requestURL.replace(":nomorPenjualan", data);
            return `<a href="${requestURL}" class="btn btn-primary btn-sm">detail</a>`
          }
        }
      ],
    });
  });
</script>
@endpush