@extends('layout.dashboard')
@section('title', 'Profile Page')

@section('content')
<div class="section-header d-flex justify-content-between">
  <h1>@yield('title')</h1>
  <a href="{{route('penjualan.index')}}" class="btn btn-info">Kembali</a>
</div>

<div class="card">
  <div class="card-body">
    <div class="bazarku__info__user">
      <h6>nama <span>{{auth()->user()->nama_user}}</span></h6>
      <h6>username <span>{{auth()->user()->username}}</span></h6>
      <h6>role <span>{{auth()->user()->role->nama_role}}</span></h6>
      <h6>tanggal join <span>{{auth()->user()->tanggal_input}}</span></h6>
    </div>
  </div>
</div>
<div class="card">
  <div class="card-body">
    <div class="bazarku__change__password">
      <h6 class="card-title text-capitalize text-dark">change password</h6>
      <form action="{{route('change.user.password')}}" method="POST" id="bazarku__change__password">
        @csrf
        <div class="form-group" x-data="{show: false}">
          <label for="password">password lama</label>
          <div class="position-relative">
            <input id="bazarku__old__password" :type="show ? 'text' : 'password'" class="form-control" name="old_password" value="{{old('old_password')}}" placeholder="masukan password lama anda...">
            <i @click="show = !show" x-show="show === false" class="fas fa-eye position-absolute" style="font-size: 18px; bottom: 12px; right: 10px; cursor: pointer;"></i>
            <i @click="show = !show" x-show="show === true" class="fas fa-eye-slash position-absolute" style="font-size: 18px; bottom: 12px; right: 10px; cursor: pointer;"></i>
          </div>
          @error('old_password')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
        </div>
        <div class="form-group" x-data="{show: false}">
          <label for="password">password baru</label>
          <div class="position-relative">
            <input id="bazarku__new__password" :type="show ? 'text' : 'password'" class="form-control" name="new_password" value="{{old('new_password')}}" placeholder="masukan password baru anda...">
            <i @click="show = !show" x-show="show === false" class="fas fa-eye position-absolute" style="font-size: 18px; bottom: 12px; right: 10px; cursor: pointer;"></i>
            <i @click="show = !show" x-show="show === true" class="fas fa-eye-slash position-absolute" style="font-size: 18px; bottom: 12px; right: 10px; cursor: pointer;"></i>
          </div>
          @error('new_password')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
        </div>
        <div>
          <button type="submit" class="btn btn-primary text-capitalize">change password</button>
          <button type="button" class="btn btn-success text-capitalize" id="bazarku__generate__password">
            <i class="fas fa-random mr-2"></i><span>generate password</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(() => {
    $("#bazarku__generate__password").on("click", async (e) => {
      const randomURL = "{{route('generate.password')}}";
      const {
        password
      } = await fetch(randomURL).then((res) => res.json());
      $("#bazarku__new__password").val(password);
    });

    $("#bazarku__change__password").on("submit", (e) => {
      e.preventDefault();
      Swal.fire({
        title: 'Change Password {{auth()->user()->nama_user}}?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, change it!'
      }).then((result) => {
        if (result.isConfirmed) {
          e.currentTarget.submit();
        }
      })
    });
  });
</script>
@endpush

@push('styles')
<style>
  .bazarku__info__user h6 {
    text-transform: capitalize;
    position: relative;
  }

  .bazarku__info__user h6::after {
    content: ":";
    position: absolute;
    left: 10rem;
  }

  .bazarku__info__user h6 span {
    font-weight: normal;
    position: absolute;
    left: 12rem;
  }
</style>
@endpush