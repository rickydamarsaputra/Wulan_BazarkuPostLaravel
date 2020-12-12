@extends('layout.dashboard')
@section('sectionTitle', 'Pilih Divisi Penjualan')

@section('content')
<div class="section-header d-flex justify-content-between">
  <h1>@yield('sectionTitle')</h1>
  <a href="{{route('penjualan.index')}}" class="btn btn-info">Kembali</a>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{route('penjualan.create')}}" method="POST" id="bazarku__form__choose__divisi">
      @csrf
      <div class="form-group" id="bazarku__choose__divisi__wrap">
        <select class="form-control choose__divisi" id="bazarku__choose__divisi" name="divisi_id">
          <option>Pilih Divisi</option>
          @foreach($divisi as $divi)
          <option value="{{$divi->ID_divisi}}">{{$divi->nama}}</option>
          @endforeach
        </select>
        <small class="form-text text-danger text-capitalize"></small>
      </div>
      <button type="submit" class="btn btn-primary">Pilih Divisi</button>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(() => {
    $(".choose__divisi").select2();
    $("#bazarku__form__choose__divisi").on("submit", (e) => {
      const divisi = $("#bazarku__choose__divisi").val();
      e.preventDefault();
      if (divisi != "Pilih Divisi") {
        e.currentTarget.submit();
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Silahkan Pilih Divisi!',
        });
      }
    });
  });
</script>
@endpush