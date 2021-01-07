@extends('layout.dashboard')
@section('title', 'Divisi Create Page')

@section('content')
<div class="section-header d-flex justify-content-between">
  <h1 class="text-capitalize">@yield('title')</h1>
  <a href="{{route('divisi.index')}}" class="btn btn-primary text-capitalize">kembali</a>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{route('divisi.create.process')}}" method="POST">
      @csrf
      <div class="form-group">
        <label for="text">Kode Divisi</label>
        <input name="kode_divisi" id="kode_divisi" type="text" class="form-control" value="{{old('kode_divisi')}}" placeholder="masukkan kode divisi...">
        @error('kode_divisi')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
      </div>
      <div class="form-group">
        <label for="text">Nama Divisi</label>
        <input name="nama_divisi" id="nama_divisi" type="text" class="form-control" value="{{old('nama_divisi')}}" placeholder="masukkan nama divisi...">
        @error('nama_divisi')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
      </div>
      <div class="form-group">
        <label for="text">No Telp Divisi</label>
        <input name="notel_divisi" id="notel_divisi" type="text" class="form-control" value="{{old('notel_divisi')}}" placeholder="masukkan no telp divisi...">
        @error('notel_divisi')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
      </div>
      <button type="submit" class="btn btn-primary text-capitalize">submit</button>
    </form>
  </div>
</div>
@endsection