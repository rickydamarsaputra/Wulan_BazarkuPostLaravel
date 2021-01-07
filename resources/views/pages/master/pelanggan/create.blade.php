@extends('layout.dashboard')
@section('title', 'Pelanggan Create Page')

@section('content')
<div class="section-header d-flex justify-content-between">
  <h1 class="text-capitalize">@yield('title')</h1>
  <a href="{{route('pelanggan.index')}}" class="btn btn-primary text-capitalize">kembali</a>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{route('pelanggan.create.process')}}" method="POST">
      @csrf
      <div class="form-group">
        <label for="text">Nama Pelanggan</label>
        <input name="nama_pelanggan" id="nama_pelanggan" type="text" class="form-control" value="{{old('nama_pelanggan')}}" placeholder="masukkan nama pelanggan...">
        @error('nama_pelanggan')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
      </div>
      <div class="form-group">
        <label for="text">Alamat Pelanggan</label>
        <input name="alamat_pelanggan" id="alamat_pelanggan" type="text" class="form-control" value="{{old('alamat_pelanggan')}}" placeholder="masukkan alamat pelanggan...">
        @error('alamat_pelanggan')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
      </div>
      <div class="form-group">
        <label for="text">Email Pelanggan</label>
        <input name="email_pelanggan" id="email_pelanggan" type="text" class="form-control" value="{{old('email_pelanggan')}}" placeholder="masukkan email pelanggan...">
        @error('email_pelanggan')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
      </div>
      <div class="form-group">
        <label for="text">No Telp Pelanggan</label>
        <input name="notelp_pelanggan" id="notelp_pelanggan" type="text" class="form-control" value="{{old('notelp_pelanggan')}}" placeholder="masukkan no telp pelanggan...">
        @error('notelp_pelanggan')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
      </div>
      <div class="form-group">
        <label for="text">Divisi Pembelian</label>
        <select class="form-select" name="divisi_id">
          @foreach($divisi as $loopItem)
          <option value="{{$loopItem->ID_divisi}}">{{$loopItem->nama}}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="text">Status Mitra</label>
        <select class="form-select" name="status_mitra">
          @foreach($statusMitra as $loopItem)
          <option value="{{$loopItem['status']}}" class="text-capitalize">{{$loopItem['label']}}</option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="btn btn-primary text-capitalize">submit</button>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(() => {
    $("select").select2();
  });
</script>
@endpush