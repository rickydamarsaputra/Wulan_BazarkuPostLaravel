@extends('layout.dashboard')
@section('title', 'Divisi Update Page')

@section('content')
<div class="section-header d-flex justify-content-between">
  <h1 class="text-capitalize">{{$divisi->nama}} update</h1>
  <a href="{{route('divisi.index')}}" class="btn btn-primary text-capitalize">kembali</a>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{route('divisi.update.process', $divisi->ID_divisi)}}" method="POST">
      @csrf
      @method('put')
      <div class="form-group">
        <label for="text">Kode Divisi</label>
        <input name="kode_divisi" id="kode_divisi" type="text" class="form-control" value="{{$divisi->kode_divisi}}" placeholder="masukkan kode divisi...">
        @error('kode_divisi')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
      </div>
      <div class="form-group">
        <label for="text">Nama Divisi</label>
        <input name="nama_divisi" id="nama_divisi" type="text" class="form-control" value="{{$divisi->nama}}" placeholder="masukkan nama divisi...">
        @error('nama_divisi')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
      </div>
      <div class="form-group">
        <label for="text">No Telp Divisi</label>
        <input name="notel_divisi" id="notel_divisi" type="text" class="form-control" value="{{$divisi->no_telp}}" placeholder="masukkan no telp divisi...">
        @error('notel_divisi')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
      </div>
      <button type="submit" class="btn btn-success text-capitalize">update</button>
    </form>
  </div>
</div>
@endsection