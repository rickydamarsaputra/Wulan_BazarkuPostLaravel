@extends('layout.dashboard')
@section('sectionTitle', 'Penjualan Page')

@section('content')
<div class="table-responsive">
  <table class="table table-striped text-uppercase" id="data__table__penjualan">
    <thead>
      <tr>
        <th class="text-center">#</th>
        <th>Tanggal Jual</th>
        <th>NO.Penjualan</th>
        <th>Nama Pelanggan</th>
        <th>Divisi</th>
        <th>Sales</th>
        <th>Ekspedisi</th>
        <th>Bank</th>
        <th>Grand Total</th>
        <th>Status</th>
      </tr>
    </thead>
  </table>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(() => {
    $("#data__table__penjualan").DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{route('dataTables.penjualan')}}",
      columns: [{
          data: "ID_penjualan",
          defaultContent: "Anonymous"
        },
        {
          data: "tanggal_jual",
          defaultContent: "Anonymous"
        },
        {
          data: "nomor_penjualan",
          defaultContent: "Anonymous"
        },
        {
          data: "nama_pelanggan",
          name: "pelanggan.nama_pelanggan",
          defaultContent: "Anonymous"
        },
        {
          data: "nama_divisi",
          name: "divisi.nama",
          defaultContent: "Anonymous"
        },
        {
          data: "nama_sales",
          name: "sales.nama_sales",
          defaultContent: "Anonymous"
        },
        {
          data: "nama_ekspedisi",
          name: "ekspedisi.nama_ekspedisi",
          defaultContent: "Anonymous"
        },
        {
          data: "nama_bank",
          name: "bank.nama_bank",
          defaultContent: "Anonymous"
        },
        {
          data: "grand_total_with_format",
          name: "grand_total",
          defaultContent: "Anonymous"
        },
        {
          data: "status_lunas",
          name: "status",
          defaultContent: "Anonymous"
        }
      ],
    });
  });
</script>
@endpush