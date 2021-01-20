@extends('layout.dashboard')
@section('title', 'Supplier Page')

@section('content')
<div class="section-header text-capitalize d-flex justify-content-between">
  <h1>@yield('title')</h1>
  <a href="{{route('supplier.create.view')}}" class="btn btn-primary">create supplier</a>
</div>

<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped" id="data__table__supplier">
        <thead>
          <tr class="text-uppercase">
            <th class="text-center">#</th>
            <th class="text-center">nama</th>
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
    $('#data__table__supplier').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{route('datatables.supplier')}}",
      columns: [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'nama'
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
          data: 'ID_supplier',
          render: (data) => {
            let updateURL = "{{route('supplier.update.view', ':supplierId')}}";
            let deleteURL = "{{route('supplier.delete', ':supplierId')}}";
            updateURL = updateURL.replace(':supplierId', data);
            deleteURL = deleteURL.replace(':supplierId', data);

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