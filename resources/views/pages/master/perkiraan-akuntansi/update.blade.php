@extends('layout.dashboard')
@section('title', 'Bank Page')

@section('content')
<div class="section-header d-flex justify-content-between">
  <h1 class="text-capitalize">{{$perkiraanAkuntansi->nama_akun}} update</h1>
  <a href="{{route('perkiraan.akuntansi.index')}}" class="btn btn-primary text-capitalize">kembali</a>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{route('perkiraan.akuntansi.update.process', $perkiraanAkuntansi->ID_perkiraan)}}" method="POST">
      @csrf
      @method('put')
      <div class="form-group">
        <label for="text">Kode Akun Perkiraan</label>
        <input name="kode_akun_perkiraan" id="kode_akun_perkiraan" type="text" class="form-control" value="{{$perkiraanAkuntansi->kode_perkiraan}}" placeholder="masukkan kode akun perkiraan...">
        @error('kode_akun_perkiraan')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
      </div>
      <div class="form-group">
        <label for="text">Nama Akun Perkiraan</label>
        <input name="nama_akun" id="nama_akun" type="text" class="form-control" value="{{$perkiraanAkuntansi->nama_akun}}" placeholder="masukkan nama akun perkiraan...">
        @error('nama_akun')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
      </div>
      @foreach($tipeAkun as $loopItem)
      <div class="form-check">
        <input class="form-check-input tipe__akun" type="radio" name="tipe_akun" value="{{$loopItem['status']}}" id="status_{{$loopItem['label']}}">
        <label class="form-check-label text-capitalize" for="status_{{$loopItem['label']}}">
          {{$loopItem['label']}}
        </label>
      </div>
      @endforeach
      <button type="submit" class="btn btn-success text-capitalize mt-4">update</button>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
  const statusElement = document.querySelectorAll('.tipe__akun');
  const currentStatus = "{{$perkiraanAkuntansi->tipe_akun}}";

  statusElement.forEach((e) => {
    if (e.defaultValue == currentStatus) {
      e.defaultChecked = true;
    }
  });
</script>
@endpush