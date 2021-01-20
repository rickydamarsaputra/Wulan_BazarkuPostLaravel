@extends('layout.dashboard')
@section('title', 'Sales Page')

@section('content')
<div class="section-header text-capitalize d-flex justify-content-between">
  <h1>@yield('title')</h1>
  <a href="{{route('sales.create.view')}}" class="btn btn-primary">create sales</a>
</div>

<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped" id="data__table__sales">
        <thead>
          <tr class="text-uppercase">
            <th class="text-center">#</th>
            <th class="text-center">nama sales</th>
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
    $('#data__table__sales').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{route('datatables.sales')}}",
      columns: [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'nama_sales',
        },
        {
          data: 'tanggal_input'
        },
        {
          data: 'ID_sales',
          render: (data) => {
            let updateURL = "{{route('sales.update.view', ':salesId')}}";
            let deleteURL = "{{route('sales.delete', ':salesId')}}";
            updateURL = updateURL.replace(':salesId', data);
            deleteURL = deleteURL.replace(':salesId', data);

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
      ],
    });
  });
</script>
@endpush