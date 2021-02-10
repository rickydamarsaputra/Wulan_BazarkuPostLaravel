@extends('layout.dashboard')
@section('title', 'Transaksi Akuntansi Create Page')

@section('content')
<div class="section-header d-flex justify-content-between">
  <h1 class="text-capitalize">@yield('title')</h1>
  <a href="{{route('transaksi.akuntansi.index')}}" class="btn btn-primary text-capitalize">kembali</a>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{route('transaksi.akuntansi.create.process')}}" method="POST">
      @csrf
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-2">Tanggal Transaksi</label>
        <div class="col-lg">
          <input type="text" class="form-control tanggal__transaksi" name="tanggal_transaksi">
        </div>
      </div>
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
            <option value="">Pilih Akun</option>
          </select>
          @error('perkiraan')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
        </div>
      </div>
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-2">Divisi</label>
        <div class="col-lg">
          <select class="form-control" id="divisi" name="divisi">
            <option value="">Pilih Divisi</option>
            @foreach($divisi as $loopItem)
            <option value="{{$loopItem->ID_divisi}}">{{$loopItem->nama}}</option>
            @endforeach
          </select>
          @error('divisi')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
        </div>
      </div>
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-2">Nominal</label>
        <div class="col-lg">
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">
                <span>Rp</span>
              </div>
            </div>
            <input type="text" class="form-control" name="nominal" placeholder="0">
            <div class="input-group-prepend">
              <div class="input-group-text">
                <span>.-</span>
              </div>
            </div>
          </div>
          @error('nominal')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
        </div>
      </div>
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-2">Bank</label>
        <div class="col-lg">
          <select class="form-control" id="bank" name="bank">
            <option value="">Pilih Bank</option>
            @foreach($bank as $loopItem)
            <option value="{{$loopItem->ID_bank}}">{{$loopItem->nama_bank}}</option>
            @endforeach
          </select>
          @error('bank')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
        </div>
      </div>
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-2">Keterangan</label>
        <div class="col-lg">
          <input type="text" class="form-control" name="keterangan" placeholder="masukkan keterangan...">
          @error('keterangan')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
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
@endsection

@push('scripts')
<script>
  $(document).ready(() => {
    $(".tanggal__transaksi").daterangepicker({
      maxDate: new Date(),
      locale: {
        format: 'YYYY-MM-DD'
      },
      singleDatePicker: true,
    });

    $('#bazarku__pemasukan, #bazarku__pengeluaran').on('change', async (e) => {
      const tipeAkun = e.target.getAttribute('id') == 'bazarku__pemasukan' ? 1 : 2;
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
  });
</script>
@endpush