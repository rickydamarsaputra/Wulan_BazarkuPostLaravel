@extends('layout.dashboard')
@section('title', 'Perkiraan Akuntansi Page')

@section('content')
<div class="section-header text-capitalize d-flex justify-content-between">
  <h1>@yield('title')</h1>
  <a href="{{route('perkiraan.akuntansi.create.view')}}" class="btn btn-primary">create perkiraan akuntansi</a>
</div>

<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped" id="data__table__perkiraan__akuntansi">
        <thead>
          <tr class="text-uppercase">
            <th class="text-center">#</th>
            <th class="text-center">kode akun</th>
            <th class="text-center">nama akun</th>
            <th class="text-center">tipe akun</th>
            <th class="text-center">tanggal input</th>
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
    $('#data__table__perkiraan__akuntansi').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{route('datatables.perkiraan.akuntansi')}}",
      columns: [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'kode_perkiraan'
        },
        {
          data: 'nama_akun'
        },
        {
          data: 'tipe_akun',
          render: (data) => {
            const message = data == 1 ? 'Pemasukan' : 'Pengeluaran';
            return message;
          }
        },
        {
          data: 'tanggal_input'
        },
        {
          data: 'ID_perkiraan',
          render: (data) => {
            let updateURL = "{{route('perkiraan.akuntansi.update.view', ':perkiraanId')}}";
            let deleteURL = "{{route('perkiraan.akuntansi.delete', ':perkiraanId')}}";
            updateURL = updateURL.replace(':perkiraanId', data);
            deleteURL = deleteURL.replace(':perkiraanId', data);

            return `
              <div class="d-flex">
                <a href="${updateURL}" class="btn btn-sm btn-success text-capitalize mr-2">update</a>
                <form action="${deleteURL}" method="POST">
                  @csrf
                  @method('delete')
                  <button type="submit" class="btn btn-sm btn-danger text-capitalize">delete</button>
                </form>
              </div>
            `;
          }
        },
      ]
    });
  });
</script>
@endpush