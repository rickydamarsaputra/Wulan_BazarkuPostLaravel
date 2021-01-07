@extends('layout.dashboard')
@section('title', 'Bank Create Page')

@section('content')
<div class="section-header d-flex justify-content-between">
  <h1 class="text-capitalize">@yield('title')</h1>
  <a href="{{route('bank.index')}}" class="btn btn-primary text-capitalize">kembali</a>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{route('bank.create.process')}}" method="POST">
      @csrf
      <div class="form-group">
        <label for="text">Nama Bank</label>
        <input name="nama_bank" id="nama_bank" type="text" class="form-control" value="{{old('nama_bank')}}" placeholder="masukkan nama bank...">
        @error('nama_bank')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
      </div>
      @foreach($statusBank as $loopItem)
      <div class="form-check">
        <input class="form-check-input bank__status" type="radio" name="status_bank" value="{{$loopItem['status']}}" id="status_{{$loopItem['label']}}">
        <label class="form-check-label text-capitalize" for="status_{{$loopItem['label']}}">
          {{$loopItem['name']}}
        </label>
      </div>
      @endforeach
      <button type="submit" class="btn btn-primary text-capitalize mt-4">submit</button>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(() => {});
</script>
@endpush