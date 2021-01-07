@extends('layout.dashboard')
@section('title', 'Bank Page')

@section('content')
<div class="section-header d-flex justify-content-between">
  <h1 class="text-capitalize">{{$sales->nama_sales}} update</h1>
  <a href="{{route('divisi.index')}}" class="btn btn-primary text-capitalize">kembali</a>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{route('sales.update.process', $sales->ID_sales)}}" method="POST">
      @csrf
      @method('put')
      <div class="form-group">
        <label for="text">Nama Sales</label>
        <input name="nama_sales" id="nama_sales" type="text" class="form-control" value="{{$sales->nama_sales}}" placeholder="masukkan nama sales...">
        @error('nama_sales')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
      </div>
      <button type="submit" class="btn btn-success text-capitalize">update</button>
    </form>
  </div>
</div>
@endsection