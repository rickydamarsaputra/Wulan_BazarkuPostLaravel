@extends('layout.dashboard')
@section('title', 'Bank Page')

@section('content')
<div class="section-header text-capitalize d-flex justify-content-between">
  <h1>@yield('title')</h1>
  <a href="{{route('bank.create.view')}}" class="btn btn-primary">create bank</a>
</div>

<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped" id="data__table__bank">
        <thead>
          <tr class="text-uppercase">
            <th class="text-center">#</th>
            <th class="text-center">nama bank</th>
            <th class="text-center">kategori bank</th>
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
    $('#data__table__bank').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{route('datatables.bank')}}",
      columns: [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'nama_bank'
        },
        {
          data: 'kategori_bank',
          render: (data) => {
            const status = data == 1 ? 'cash' : data == 2 ? 'pending in' : 'pending out';
            return status.toUpperCase();
          }
        },
        {
          data: 'tanggal_input'
        },
        {
          data: 'ID_bank',
          render: (data) => {
            let updateURL = "{{route('bank.update.view', ':bankId')}}";
            let deleteURL = "{{route('bank.delete', ':bankId')}}";
            updateURL = updateURL.replace(':bankId', data);
            deleteURL = deleteURL.replace(':bankId', data);

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