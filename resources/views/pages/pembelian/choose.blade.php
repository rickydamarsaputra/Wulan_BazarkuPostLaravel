@extends('layout.dashboard')
@section('title', 'Pilih Divisi Pembelian')

@section('content')
<div class="section-header d-flex justify-content-between">
  <h1>@yield('title')</h1>
  <a href="{{route('pembelian.index')}}" class="btn btn-info">Kembali</a>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{route('pembelian.choose.submit')}}" method="POST">
      @csrf
      <div class="form-group">
        <select class="form-control" name="divisi">
          <option value="">Pilih Divisi</option>
          @foreach($divisi as $loopItem)
          <option value="{{$loopItem->ID_divisi}}">{{$loopItem->nama}}</option>
          @endforeach
        </select>
        @error('divisi')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
      </div>
      <button type="submit" class="btn btn-primary">Pilih Divisi</button>
    </form>
  </div>
</div>
@endsection