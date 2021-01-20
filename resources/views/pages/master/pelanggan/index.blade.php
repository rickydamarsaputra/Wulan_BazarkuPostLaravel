@extends('layout.dashboard')
@section('title', 'Pelanggan Page')

@section('content')
<div class="section-header text-capitalize d-flex justify-content-between">
  <h1>@yield('title')</h1>
  <a href="{{route('pelanggan.create.view')}}" class="btn btn-primary">create pelanggan</a>
</div>

<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped" id="data__table__pelanggan">
        <thead>
          <tr class="text-uppercase">
            <th class="text-center">#</th>
            <th class="text-center">nama pelanggan</th>
            <th class="text-center">alamat</th>
            <th class="text-center">email</th>
            <th class="text-center">no telp</th>
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
    $('#data__table__pelanggan').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{route('datatables.pelanggan')}}",
      columns: [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'nama_pelanggan'
        },
        {
          data: 'alamat'
        },
        {
          data: 'email'
        },
        {
          data: 'no_telp'
        },
        {
          data: 'tanggal_input'
        },
        {
          data: 'ID_pelanggan',
          render: (data) => {
            let deleteURL = "{{route('pelanggan.delete', ':pelangganId')}}";
            deleteURL = deleteURL.replace(':pelangganId', data);

            return `
              <form action="${deleteURL}" method="POST" class="bazarku__delete__master__item">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger btn-sm text-capitalize">delete</button>
              </form>
            `;
          }
        }
      ]
    });
  });
</script>
@endpush