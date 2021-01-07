@extends('layout.dashboard')
@section('title', 'Bank Page')

@section('content')
<div class="section-header d-flex justify-content-between">
  <h1 class="text-capitalize">{{$ekspedisi->nama_ekspedisi}} update</h1>
  <a href="{{route('ekspedisi.index')}}" class="btn btn-primary text-capitalize">kembali</a>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{route('ekspedisi.update.process', $ekspedisi->ID_ekspedisi)}}" method="POST">
      @csrf
      @method('put')
      <div class="form-group">
        <label for="text">Nama Ekspedisi</label>
        <input name="nama_ekspedisi" id="nama_ekspedisi" type="text" class="form-control" value="{{$ekspedisi->nama_ekspedisi}}" placeholder="masukkan nama ekspedisi...">
        @error('nama_ekspedisi')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
      </div>
      <button type="submit" class="btn btn-success text-capitalize">update</button>
    </form>
  </div>
</div>
@endsection