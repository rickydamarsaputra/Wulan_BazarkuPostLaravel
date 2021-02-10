@extends('layout.dashboard')
@section('title', 'Transaksi Akuntansi Page')

@section('content')
<div class="section-header">
  <h1>@yield('title')</h1>
</div>
<div class="card">
  <div class="card-body">
    <form action="" method="POST" id="bazarku__form__filter__produk__terlaris">
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-2 mr-2 text-nowrap">Tipe Akun Perkiraan</label>
        <div class="col-lg">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="tipe_akun" value="1" id="bazarku__pemasukan">
            <label class="form-check-label" for="bazarku__pemasukan">
              Pemasukan
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="tipe_akun" value="2" id="bazarku__pengeluaran">
            <label class="form-check-label" for="bazarku__pengeluaran">
              Pengeluaran
            </label>
          </div>
          <small class="form-text text-danger text-capitalize"></small>
        </div>
      </div>
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-2">Akun Perkiraan</label>
        <div class="col-lg">
          <select class="form-control choose__akun__perkiraan" id="akun__perkiraan" name="perkiraan">
            <option value="0">Pilih Akun</option>
          </select>
        </div>
      </div>
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-2">Divisi</label>
        <div class="col-lg">
          <select class="form-control" id="divisi" name="divisi">
            <option value="0">Pilih Divisi</option>
            @foreach($divisi as $loopItem)
            <option value="{{$loopItem->ID_divisi}}">{{$loopItem->nama}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-2">Bank</label>
        <div class="col-lg">
          <select class="form-control" id="bank" name="bank">
            <option value="0">Pilih Bank</option>
            @foreach($bank as $loopItem)
            <option value="{{$loopItem->ID_bank}}">{{$loopItem->nama_bank}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-2">Pilih Tanggal</label>
        <div class="col-lg">
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">
                <i class="fas fa-calendar"></i>
              </div>
            </div>
            <input type="text" class="form-control daterange-cus" id="bazarku__date__range" name="date_range">
          </div>
        </div>
      </div>
      <div class="form-group row mb-4">
        <div class="col-lg-2"></div>
        <div class="col-lg">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="card" id="bazarku__transaksi__akuntansi__info">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped" id="data__table__transaksi__akuntansi">
        <thead>
          <tr class="text-uppercase">
            <th class="text-center">#</th>
            <th class="text-center">tanggal transaksi</th>
            <th class="text-center">tipe</th>
            <th class="text-center">akun</th>
            <th class="text-center">bank</th>
            <th class="text-center">divisi</th>
            <th class="text-center">nominal</th>
            <th class="text-center">keterangan</th>
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
    $('#bazarku__pemasukan, #bazarku__pengeluaran').on('change', async (e) => {
      const tipeAkun = e.target.value;
      let requestURL = "{{route('helpers.filter.perkiraan.akuntansi', ':tipeAkun')}}";
      requestURL = requestURL.replace(':tipeAkun', tipeAkun);
      const {
        data
      } = await axios.get(requestURL);
      let html = '';

      data.forEach((loopItem) => {
        html += `
          <option value="${loopItem.ID_perkiraan}" data-type-akun="${loopItem.tipe_akun}">${loopItem.nama_akun}</option>
        `
      });
      $('.choose__akun__perkiraan').find('option[data-type-akun]').remove();
      $('#akun__perkiraan').append(html);
    });

    $('#bazarku__transaksi__akuntansi__info').hide();
    $('#bazarku__form__filter__produk__terlaris').on('submit', async (e) => {
      e.preventDefault();
      $('#bazarku__transaksi__akuntansi__info').show();
      const tipeAkunElements = document.querySelectorAll('input[name=tipe_akun]');
      let tipeAkun = 0;
      tipeAkunElements.forEach(e => {
        if (e.checked) {
          tipeAkun = e.value;
        }
      });

      const idPerkiraan = $('#akun__perkiraan').val();
      const idDivisi = $('#divisi').val();
      const idBank = $('#bank').val();
      const dateRange = $('#bazarku__date__range').val();
      let requestURL = "{{route('datatables.transaksi.akuntansi', [':tipeAkun', ':idPerkiraan', ':idDivisi', ':idBank', ':dateRange'])}}";
      requestURL = requestURL.replace(':tipeAkun', tipeAkun);
      requestURL = requestURL.replace(':idPerkiraan', idPerkiraan);
      requestURL = requestURL.replace(':idDivisi', idDivisi);
      requestURL = requestURL.replace(':idBank', idBank);
      requestURL = requestURL.replace(':dateRange', dateRange);

      const datatablesColumn = [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'tanggal_transaksi'
        },
        {
          data: 'tipe_akun',
          render: (data) => {
            return data == 1 ? 'Pemasukan' : 'Pengeluaran';
          }
        },
        {
          data: 'nama_akun'
        },
        {
          data: 'bank.nama_bank'
        },
        {
          data: 'divisi.nama'
        },
        {
          data: 'nominal'
        },
        {
          data: 'keterangan'
        },
        {
          data: 'ID_transaksi',
          render: (data) => {
            let requestURL = "{{route('transaksi.akuntansi.delete', ':idTransaksi')}}";
            requestURL = requestURL.replace(':idTransaksi', data);
            return `
              <form action="${requestURL}" method="POST" class="bazarku__delete__master__item">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger btn-sm text-capitalize">delete</button>
              </form>
            `;
          }
        }
      ];

      if ($.fn.dataTable.isDataTable('#data__table__transaksi__akuntansi')) {
        $('#data__table__transaksi__akuntansi').DataTable().destroy();
        $('#data__table__transaksi__akuntansi').DataTable({
          processing: true,
          serverSide: true,
          ajax: requestURL,
          columns: datatablesColumn
        });
      } else {
        $('#data__table__transaksi__akuntansi').DataTable({
          processing: true,
          serverSide: true,
          ajax: requestURL,
          columns: datatablesColumn
        });
      }
    });

    $('.bazarku__delete__transaksi__akuntansi').ready(event => {
      $(event).on('submit', (e) => {
        e.preventDefault();
        const formClass = e.target.getAttribute("class");
        console.log(formClass);
      });
    });
  });
</script>
@endpush