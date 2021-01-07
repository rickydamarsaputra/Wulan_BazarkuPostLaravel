@extends('layout.dashboard')
@section('title', 'Ekspedisi Page')

@section('content')
<div class="section-header text-capitalize d-flex justify-content-between">
  <h1>@yield('title')</h1>
  <a href="{{route('ekspedisi.create.view')}}" class="btn btn-primary">create bank</a>
</div>

<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped" id="data__table__ekspedisi">
        <thead>
          <tr class="text-uppercase">
            <th class="text-center">#</th>
            <th class="text-center">nama ekspedisi</th>
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
    $('#data__table__ekspedisi').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{route('datatables.ekspedisi')}}",
      columns: [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'nama_ekspedisi'
        },
        {
          data: 'tanggal_input'
        },
        {
          data: 'ID_ekspedisi',
          render: (data) => {
            let updateURL = "{{route('ekspedisi.update.view', ':ekspedisiId')}}";
            let deleteURL = "{{route('ekspedisi.delete', ':ekspedisiId')}}";
            updateURL = updateURL.replace(':ekspedisiId', data);
            deleteURL = deleteURL.replace(':ekspedisiId', data);

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