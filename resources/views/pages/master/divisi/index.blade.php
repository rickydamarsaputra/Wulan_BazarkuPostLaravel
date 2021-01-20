@extends('layout.dashboard')
@section('title', 'Divisi Page')

@section('content')
<div class="section-header text-capitalize d-flex justify-content-between">
  <h1>@yield('title')</h1>
  <a href="{{route('divisi.create.view')}}" class="btn btn-primary">create divisi</a>
</div>

<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped" id="data__table__divisi">
        <thead>
          <tr class="text-uppercase">
            <th class="text-center">#</th>
            <th class="text-center">kode divisi</th>
            <th class="text-center">nama divisi</th>
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
    $('#data__table__divisi').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{route('datatables.divisi')}}",
      columns: [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'kode_divisi'
        },
        {
          data: 'nama'
        },
        {
          data: 'no_telp'
        },
        {
          data: 'tanggal_input'
        },
        {
          data: 'ID_divisi',
          render: (data) => {
            let updateURL = "{{route('divisi.update.view', ':divisiId')}}";
            let deleteURL = "{{route('divisi.delete', ':divisiId')}}";
            updateURL = updateURL.replace(':divisiId', data);
            deleteURL = deleteURL.replace(':divisiId', data);

            return `
              <div class="d-flex">
                <a href="${updateURL}" class="btn btn-sm btn-success text-capitalize mr-2">update</a>
                <form action="${deleteURL}" method="POST" class="bazarku__delete__master__item">
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