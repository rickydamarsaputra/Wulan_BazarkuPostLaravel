@extends('layout.dashboard')
@section('title', 'Supplier Update Page')

@section('content')
<div class="section-header d-flex justify-content-between">
  <h1 class="text-capitalize">{{$supplier->nama}} update</h1>
  <a href="{{route('supplier.index')}}" class="btn btn-primary text-capitalize">kembali</a>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{route('supplier.update.process', $supplier->ID_supplier)}}" method="POST">
      @csrf
      @method('put')
      <div class="form-group">
        <label for="text">Nama Supplier</label>
        <input name="nama_supplier" id="nama_supplier" type="text" class="form-control" value="{{$supplier->nama}}" placeholder="masukkan nama supplier...">
        @error('nama_supplier')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
      </div>
      <div class="form-group">
        <label for="text">Alamat Supplier</label>
        <input name="alamat_supplier" id="alamat_supplier" type="text" class="form-control" value="{{$supplier->alamat}}" placeholder="masukkan alamat supplier...">
        @error('alamat_supplier')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
      </div>
      <div class="form-group">
        <label for="text">Email Supplier</label>
        <input name="email_supplier" id="email_supplier" type="text" class="form-control" value="{{$supplier->email}}" placeholder="masukkan email supplier...">
        @error('email_supplier')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
      </div>
      <div class="form-group">
        <label for="text">No Telp Supplier</label>
        <input name="notelp_supplier" id="notelp_supplier" type="text" class="form-control" value="{{$supplier->no_telp}}" placeholder="masukkan no telp supplier...">
        @error('notelp_supplier')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
      </div>
      <button type="submit" class="btn btn-success text-capitalize">update</button>
    </form>
  </div>
</div>
@endsection