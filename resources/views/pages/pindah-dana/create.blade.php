@extends('layout.dashboard')
@section('title', 'Pindah Dana Create Page')

@section('content')
<div class="section-header d-flex justify-content-between">
  <h1 class="text-capitalize">@yield('title')</h1>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{route('pindah.dana.create.process')}}" method="POST">
      @csrf
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-2">Tanggal Transaksi</label>
        <div class="col-lg">
          <input type="text" class="form-control tanggal__transaksi" name="tanggal_transaksi">
        </div>
      </div>
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-2">Bank Asal</label>
        <div class="col-lg">
          <select class="form-control" id="bank_asal" name="bank_asal">
            <option value="">Pilih Bank Asal</option>
            @foreach($bank as $loopItem)
            <option value="{{$loopItem->ID_bank}}">{{$loopItem->nama_bank}}</option>
            @endforeach
          </select>
          @error('bank_asal')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
        </div>
      </div>
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-2">Divisi Asal</label>
        <div class="col-lg">
          <select class="form-control" id="divisi_asal" name="divisi_asal">
            <option value="">Pilih Divisi Asal</option>
            @foreach($divisi as $loopItem)
            <option value="{{$loopItem->ID_divisi}}">{{$loopItem->nama}}</option>
            @endforeach
          </select>
          @error('divisi_asal')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
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
        <label class="col-form-label text-md-right col-lg-2">Bank Tujuan</label>
        <div class="col-lg">
          <select class="form-control" id="bank_tujuan" name="bank_tujuan">
            <option value="">Pilih Bank Tujuan</option>
            @foreach($bank as $loopItem)
            <option value="{{$loopItem->ID_bank}}">{{$loopItem->nama_bank}}</option>
            @endforeach
          </select>
          @error('bank_tujuan')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
        </div>
      </div>
      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-lg-2">Divisi Tujuan</label>
        <div class="col-lg">
          <select class="form-control" id="divisi_tujuan" name="divisi_tujuan">
            <option value="">Pilih Divisi Tujuan</option>
            @foreach($divisi as $loopItem)
            <option value="{{$loopItem->ID_divisi}}">{{$loopItem->nama}}</option>
            @endforeach
          </select>
          @error('divisi_tujuan')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
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
  });
</script>
@endpush