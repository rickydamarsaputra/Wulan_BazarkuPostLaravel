@extends('layout.dashboard')
@section('title', 'Sales Create Page')

@section('content')
<div class="section-header d-flex justify-content-between">
  <h1 class="text-capitalize">@yield('title')</h1>
  <a href="{{route('sales.index')}}" class="btn btn-primary text-capitalize">kembali</a>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{route('sales.create.process')}}" method="POST">
      @csrf
      <div class="form-group">
        <label for="text">Nama Sales</label>
        <input name="nama_sales" id="nama_sales" type="text" class="form-control" value="{{old('nama_sales')}}" placeholder="masukkan nama sales...">
        @error('nama_sales')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
      </div>
      <button type="submit" class="btn btn-primary text-capitalize">submit</button>
    </form>
  </div>
</div>
@endsection