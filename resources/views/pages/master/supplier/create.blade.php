@extends('layout.dashboard')
@section('title', 'Supplier Create Page')

@section('content')
<div class="section-header d-flex justify-content-between">
  <h1 class="text-capitalize">@yield('title')</h1>
  <a href="{{route('supplier.index')}}" class="btn btn-primary text-capitalize">kembali</a>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{route('supplier.create.process')}}" method="POST">
      @csrf
      <div class="form-group">
        <label for="text">Nama Supplier</label>
        <input name="nama_supplier" id="nama_supplier" type="text" class="form-control" value="{{old('nama_supplier')}}" placeholder="masukkan nama supplier...">
        @error('nama_supplier')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
      </div>
      <div class="form-group">
        <label for="text">Alamat Supplier</label>
        <input name="alamat_supplier" id="alamat_supplier" type="text" class="form-control" value="{{old('alamat_supplier')}}" placeholder="masukkan alamat supplier...">
        @error('alamat_supplier')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
      </div>
      <div class="form-group">
        <label for="text">Email Supplier</label>
        <input name="email_supplier" id="email_supplier" type="text" class="form-control" value="{{old('email_supplier')}}" placeholder="masukkan email supplier...">
        @error('email_supplier')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
      </div>
      <div class="form-group">
        <label for="text">No Telp Supplier</label>
        <input name="notelp_supplier" id="notelp_supplier" type="text" class="form-control" value="{{old('notelp_supplier')}}" placeholder="masukkan no telp supplier...">
        @error('notelp_supplier')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
      </div>
      <button type="submit" class="btn btn-primary text-capitalize">submit</button>
    </form>
  </div>
</div>
@endsection