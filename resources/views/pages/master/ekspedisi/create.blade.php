@extends('layout.dashboard')
@section('title', 'Ekspedisi Create Page')

@section('content')
<div class="section-header d-flex justify-content-between">
  <h1 class="text-capitalize">@yield('title')</h1>
  <a href="{{route('ekspedisi.index')}}" class="btn btn-primary text-capitalize">kembali</a>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{route('ekspedisi.create.process')}}" method="POST">
      @csrf
      <div class="form-group">
        <label for="text">Nama Ekspedisi</label>
        <input name="nama_ekspedisi" id="nama_ekspedisi" type="text" class="form-control" value="{{old('nama_ekspedisi')}}" placeholder="masukkan nama ekspedisi...">
        @error('nama_ekspedisi')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
      </div>
      <button type="submit" class="btn btn-primary text-capitalize">submit</button>
    </form>
  </div>
</div>
@endsection