@extends('layout.dashboard')
@section('sectionTitle', 'Tambah Penjualan')

@section('content')
<div class="section-header d-flex justify-content-between">
  <h1>@yield('sectionTitle')</h1>
  @if(auth()->user()->role->nama_role != "Kasir")
  <a href="{{route('penjualan.choose.divisi')}}" class="btn btn-info">Kembali</a>
  @endif
</div>

<div class="card">
  <div class="card-body overflow-scroll">
    <form action="{{route('penjualan.submit')}}" method="POST" id="bazarku__form__penjualan">
      @csrf
      <div class="bazarku__penjualan__section__one">
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-lg-2">Divisi</label>
          <div class="col-lg-4">
            <input type="text" class="form-control" readonly value="{{$divisi->nama}}" name="nama_divisi">
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-lg-2">Nomor Penjualan</label>
          <div class="col-lg-4">
            <input type="text" class="form-control" readonly value="{{$nomorPenjualan}}" name="nomor_penjualan">
          </div>
        </div>
        <div class="form-group row mb-4" id="bazarku__choose__sales__wrap">
          <label class="col-form-label text-md-right col-lg-2">Sales</label>
          <div class="col-lg-4">
            <select class="form-control choose__sales" id="bazarku__choose__sales" name="id_sales">
              <option>Pilih Sales</option>
              @foreach($sales as $sale)
              <option value="{{$sale->ID_sales}}">{{$sale->nama_sales}}</option>
              @endforeach
            </select>
            <small class="form-text text-danger text-capitalize"></small>
          </div>
        </div>
        <div class="form-group row mb-4" id="bazarku__choose__pelanggan__wrap">
          <label class="col-form-label text-md-right col-lg-2">Pelanggan</label>
          <div class="col-lg-4">
            <select class="form-control choose__pelanggan" id="bazarku__choose__pelanggan" name="id_pelanggan">
              <option>Pilih Pelanggan</option>
              @foreach($pelanggan as $pelang)
              <option value="{{$pelang->ID_pelanggan}}">{{$pelang->nama_pelanggan}}</option>
              @endforeach
            </select>
            <small class="form-text text-danger text-capitalize"></small>
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-lg-2">Tanggal Penjualan</label>
          <div class="col-lg-4">
            <input type="text" class="form-control tanggal__penjualan" name="tanggal_jual">
          </div>
        </div>
      </div>
      <div class="bazarku__line__break mb-4"></div>
      <div class="bazarku__penjualan__section__two">
        <div class="table-responsive">
          <table class="table table-bordered table-md bazarku__table__data text-center text-uppercase">
            <tr>
              <th>Produk</th>
              <th>Keterangan</th>
              <th>Jumlah</th>
              <th>Harga</th>
              <th>Total</th>
              <th></th>
            </tr>
            <tr id="bazarku__produk__1" class="bazarku__produk__item">
              <td style="width: 25vw;">
                <select class="form-control choose__produk" name="penjualan_detail_id_produk[]">
                  <option>Pilih Produk</option>
                  @foreach($produk as $pro)
                  <option value="{{$pro->ID_produk}}">{{$pro->nama_produk}}</option>
                  @endforeach
                </select>
              </td>
              <td>
                <input type="text" class="form-control" placeholder="Keterangan Penjualan" name="penjualan_detail_keterangan[]">
              </td>
              <td style="width: 100px;">
                <input type="text" class="form-control bazarku__jumlah" value="1" name="penjualan_detail_jumlah[]">
              </td>
              <td>
                <input type="text" class="form-control bazarku__harga" value="0" readonly name="penjualan_detail_harga[]">
              </td>
              <td>
                <input type="text" class="form-control bazarku__harga__total" value="0" readonly name="penjualan_detail_total[]">
              </td>
              <td>
                <button type="button" class="btn btn-danger bazarku__delete__produk" data-element-id="bazarku__produk__1"><i class="fas fa-times"></i></button>
              </td>
            </tr>
          </table>
        </div>
        <div class="d-flex justify-content-end mt-4">
          <button type="button" class="btn btn-primary bazarku__added__produk"><i class="far fa-plus-square mr-2"></i><span>Tambah baris</span></button>
        </div>
      </div>
      <div class="bazarku__line__break my-4"></div>
      <div class="bazarku__penjualan__section__three container">
        <div class="row">
          <div class="col-lg-4">
            <h6><i class="fas fa-paper-plane mr-2"></i><span>Penerima</span></h6>
            <div class="form-group row mb-4" id="bazarku__nama__penerima__wrap">
              <label class="col-form-label text-left col-lg-3">Nama</label>
              <div class="col-lg">
                <input type="text" class="form-control" id="bazarku__nama__penerima" name="nama_penerima" placeholder="Nama Penerima">
                <small class="form-text text-danger text-capitalize"></small>
              </div>
            </div>
            <div class="form-group row mb-4" id="bazarku__notel__penerima__wrap">
              <label class="col-form-label text-left col-lg-3">No.Telp</label>
              <div class="col-lg">
                <input type="text" class="form-control" id="bazarku__notel__penerima" name="notel_penerima" placeholder="No.Telp Penerima">
                <small class="form-text text-danger text-capitalize"></small>
              </div>
            </div>
            <div class="form-group row mb-4" id="bazarku__alamat__penerima__wrap">
              <label class="col-form-label text-left col-lg-3">Alamat</label>
              <div class="col-lg">
                <textarea class="form-control" id="bazarku__alamat__penerima" name="alamat_penerima" placeholder="Alamat Penerima" style="height: 100px;"></textarea>
                <small class="form-text text-danger text-capitalize"></small>
              </div>
            </div>
            <div class="bazarku__line__break my-4"></div>
            <div class="bazarku__dropship__content">
              <div class="form-group row mb-4">
                <label class="col-form-label text-left col-lg-4">Dropship</label>
                <div class="col-lg d-flex align-items-center">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="status_dropship" id="bazarku__dropshipping">
                    <label class="form-check-label" for="bazarku__dropshipping">
                      Dropshipping
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <h6><i class="fas fa-boxes mr-2"></i><span>Paket Order</span></h6>
            <div class="form-group row mb-4" id="bazarku__choose__ekspedisi__wrap">
              <label class="col-form-label text-left col-lg-4">Ekspedisi</label>
              <div class="col-lg">
                <select class="form-select form-select-sm choose__ekspedisi" id="bazarku__choose__ekspedisi" name="id_ekspedisi">
                  <option>Pilih Ekspedisi</option>
                  @foreach($ekspedisi as $ekspedi)
                  <option value="{{$ekspedi->ID_ekspedisi}}">{{$ekspedi->nama_ekspedisi}}</option>
                  @endforeach
                </select>
                <small class="form-text text-danger text-capitalize"></small>
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-left col-lg-4">Berat</label>
              <div class="col-lg">
                <div class="input-group">
                  <input type="text" class="form-control" value="1" name="berat">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <span>Kg</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-left col-lg-4">Keterangan</label>
              <div class="col-lg">
                <textarea class="form-control" name="keterangan" placeholder="Keterangan Penjualan" style="height: 100px;"></textarea>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <h6><i class="far fa-money-bill-alt mr-2"></i><span>Pembayaran</span></h6>
            <div class="form-group row mb-4">
              <label class="col-form-label text-left col-lg-4">Total</label>
              <div class="col-lg">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <span>Rp</span>
                    </div>
                  </div>
                  <input type="text" class="form-control" readonly value="0" id="bazarku__total__pembayaran" name="total">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <span>.-</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-left col-lg-4">Ongkos Kirim</label>
              <div class="col-lg">
                <div class="input-group" id="bazarku__ongkir__wrap">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <span>Rp</span>
                    </div>
                  </div>
                  <input type="text" class="form-control" value="0" id="bazarku__ongkir__pembayaran" name="ongkir">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <span>.-</span>
                    </div>
                  </div>
                  <small class="form-text text-danger text-capitalize"></small>
                </div>
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-left col-lg-4">Diskon</label>
              <div class="col-lg">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <span>Rp</span>
                    </div>
                  </div>
                  <input type="text" class="form-control" value="0" id="bazarku__diskon__pembayaran" name="diskon">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <span>.-</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-left col-lg-4">Pajak</label>
              <div class="col-lg">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <span>Rp</span>
                    </div>
                  </div>
                  <input type="text" class="form-control" value="0" id="bazarku__pajak__pembayaran" name="pajak">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <span>.-</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-left col-lg-4">Jumlah Total</label>
              <div class="col-lg">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <span>Rp</span>
                    </div>
                  </div>
                  <input type="text" class="form-control" readonly value="0" id="bazarku__grand__total__pembayaran" name="grand_total">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <span>.-</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-left col-lg-4">Dibayar</label>
              <div class="col-lg">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <span>Rp</span>
                    </div>
                  </div>
                  <input type="text" class="form-control" value="0" name="dibayar">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <span>.-</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row mb-4" id="bazarku__choose__bank__wrap">
              <label class="col-form-label text-left col-lg-4">Bank</label>
              <div class="col-lg">
                <select class="form-select form-select-sm choose__bank" id="bazarku__choose__bank" name="id_bank">
                  <option>Pilih Bank</option>
                  @foreach($banks as $bank)
                  <option value="{{$bank->ID_bank}}">{{$bank->nama_bank}}</option>
                  @endforeach
                </select>
                <small class="form-text text-danger text-capitalize"></small>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="bazarku__line__break my-4"></div>
      <div class="bazarku__penjualan__section__four">
        <button type="submit" class="btn btn-primary ml-2">Tambah</button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('styles')
<style>
  .bazarku__line__break {
    width: 100%;
    height: .5px;
    background-color: #e9ecef;
  }
</style>
@endpush

@push('scripts')
<script>
  $(document).ready(() => {
    let produkCounter = 1;
    $(".choose__sales, .choose__pelanggan, .choose__ekspedisi, .choose__bank").select2();
    $(".choose__produk").select2();
    $(".tanggal__penjualan").daterangepicker({
      maxDate: new Date(),
      locale: {
        format: 'YYYY-MM-DD'
      },
      singleDatePicker: true,
    });

    const checkIfProdukItemIsEmpty = () => {
      if (!$(".bazarku__produk__item").length) {
        const htmlElement = `
            <tr class="bazarku__empty__produk">
            <td colspan="6">
              <span class="text-center">Tidak Ada Produk Yang Mau Dibeli</span>
            </td>
            </tr>
            `;
        $(".bazarku__table__data tbody").append(htmlElement);
      } else {
        $(".bazarku__empty__produk").remove();
      }
    }
    const handleCountTotalAndGrandTotalPenjualan = () => {
      let bazarkuTotalPenjualan = 0;
      const diskon = Number($("#bazarku__diskon__pembayaran").val());
      const pajak = Number($("#bazarku__pajak__pembayaran").val());
      const ongkir = Number($("#bazarku__ongkir__pembayaran").val());
      $(".bazarku__harga__total").each((i, e) => {
        bazarkuTotalPenjualan += Number($(e).val());
      });
      $("#bazarku__total__pembayaran").val(bazarkuTotalPenjualan);
      $("#bazarku__grand__total__pembayaran").val((bazarkuTotalPenjualan + pajak + ongkir) - diskon);
    }
    const produkDetailChange = () => {
      $(".bazarku__produk__item").each((i, e) => {
        const elementID = $(e).attr("id");
        const jumlahQt = $(`#${elementID}`).find(".bazarku__jumlah").val();

        $(`#${elementID}`).find(".choose__produk").on("change", async (e) => {
          const idProduk = e.target.value;
          const idPelanggan = $("#bazarku__choose__pelanggan").val();

          if (idPelanggan == "Pilih Pelanggan") {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Silahkan Pilih Pelanggan!',
            });
          } else {
            if (idProduk == "Pilih Produk") {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Silahkan Pilih Produk!',
              });
            } else {
              let requestURL = "{{route('penjualan.produk.search', [':idProduk', ':idPelanggan'])}}";
              requestURL = requestURL.replace(":idProduk", idProduk);
              requestURL = requestURL.replace(":idPelanggan", idPelanggan);
              const {
                harga,
                qty
              } = await fetch(requestURL).then(res => res.json());
              if (jumlahQt > qty) {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Stok Barang Kurang / Habis!',
                });
              } else {
                $(`#${elementID}`).find(".bazarku__harga").val(harga);
                $(`#${elementID}`).find(".bazarku__harga__total").val(harga * jumlahQt);

                $(`#${elementID}`).find(".bazarku__jumlah").on("change", (e) => {
                  if (e.target.value > qty) {
                    Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Stok Barang Kurang / Habis!',
                    });
                    $(`#${elementID}`).find(".bazarku__jumlah").val(1);
                  } else {
                    $(`#${elementID}`).find(".bazarku__harga__total").val(harga * e.target.value);
                    handleCountTotalAndGrandTotalPenjualan();
                  }
                });
                handleCountTotalAndGrandTotalPenjualan();
              }
            }

          }
        });
      });
    };
    const produkDetailAdd = () => {
      const htmlElement = `
      <tr id="bazarku__produk__${produkCounter + 1}" class="bazarku__produk__item">
          <td style="width: 25vw;">
            <select class="form-control choose__produk" name="penjualan_detail_id_produk[]">
              <option>Pilih Produk</option>
              @foreach($produk as $pro)
              <option value="{{$pro->ID_produk}}">{{$pro->nama_produk}}</option>
              @endforeach
            </select>
          </td>
          <td>
            <input type="text" class="form-control" placeholder="Keterangan Penjualan" name="penjualan_detail_keterangan[]">
          </td>
          <td style="width: 100px;">
            <input type="text" class="form-control bazarku__jumlah" value="1" name="penjualan_detail_jumlah[]">
          </td>
          <td>
            <input type="text" class="form-control bazarku__harga" value="0" readonly name="penjualan_detail_harga[]">
          </td>
          <td>
            <input type="text" class="form-control bazarku__harga__total" value="0" readonly name="penjualan_detail_total[]">
          </td>
          <td>
            <button type="button" class="btn btn-danger bazarku__delete__produk" data-element-id="bazarku__produk__${produkCounter + 1}"><i class="fas fa-times"></i></button>
          </td>
        </tr>
      `;
      $(".bazarku__table__data tbody").append(htmlElement);
      $(".choose__produk").select2();
      produkDetailChange();
      checkIfProdukItemIsEmpty();
      produkCounter++;
    };

    produkDetailChange();

    $(".bazarku__added__produk").on("click", (e) => {
      e.preventDefault();
      produkDetailAdd();
    });
    $("#bazarku__diskon__pembayaran, #bazarku__pajak__pembayaran, #bazarku__ongkir__pembayaran").on("change", (e) => {
      handleCountTotalAndGrandTotalPenjualan();
    });
    $(document).keyup((e) => {
      const keyCode = (e.keyCode ? e.keyCode : e.which);
      if (keyCode == 13) {
        produkDetailAdd();
        checkIfProdukItemIsEmpty();
        return false;
      }
    });
    $(".bazarku__delete__produk").each(() => {
      $(this).on("click", (e) => {
        if (e.target.classList[2] == "bazarku__delete__produk") {
          e.preventDefault();
          Swal.fire({
            title: 'Hapus Produk Ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
              const produkID = e.target.getAttribute("data-element-id");
              $(`#${produkID}`).remove();
              handleCountTotalAndGrandTotalPenjualan();
              checkIfProdukItemIsEmpty();
              Swal.fire(
                'Produk Berhasil Dihapus!',
                '',
                'success'
              )
            }
          })
        }
      });
    });
    $("#bazarku__dropshipping").on("change", (e) => {
      if (e.target.checked) {
        const htmlElement = `
        <div class="form-group row mb-4 bazarku__dropship__pengirim">
          <label class="col-form-label text-left col-lg-4">Pengirim</label>
          <div class="col-lg">
            <input type="text" class="form-control" placeholder="Nama Pengirim" name="nama_pengirim_dropship">
          </div>
        </div>
        `;
        $(".bazarku__dropship__content").append(htmlElement);
      } else {
        $(".bazarku__dropship__pengirim").remove();
      }
    });

    const errorMessage = (name) => {
      return `field ${name} harus di isi!`;
    }

    const checkAllFieldBeforeSubmit = ({
      sales,
      pelanggan,
      namaPenerima,
      notelPenerima,
      alamatPenerima,
      ekspedisi,
      ongkir,
      bank
    }) => {
      if (sales == "Pilih Sales") {
        $("#bazarku__choose__sales__wrap").find(".text-danger").text(errorMessage("sales"));
      } else {
        $("#bazarku__choose__sales__wrap").find(".text-danger").text("");
      }
      if (pelanggan == "Pilih Pelanggan") {
        $("#bazarku__choose__pelanggan__wrap").find(".text-danger").text(errorMessage("pelanggan"));
      } else {
        $("#bazarku__choose__pelanggan__wrap").find(".text-danger").text("");
      }
      if (ongkir == 0) {
        $("#bazarku__ongkir__wrap").find(".text-danger").text(errorMessage("ongkir"));
      } else {
        $("#bazarku__ongkir__wrap").find(".text-danger").text("");
      }
      if (!namaPenerima) {
        $("#bazarku__nama__penerima__wrap").find(".text-danger").text(errorMessage("nama penerima"));
      } else {
        $("#bazarku__nama__penerima__wrap").find(".text-danger").text("");
      }
      if (!notelPenerima) {
        $("#bazarku__notel__penerima__wrap").find(".text-danger").text(errorMessage("no telp"));
      } else {
        $("#bazarku__notel__penerima__wrap").find(".text-danger").text("");
      }
      if (!alamatPenerima) {
        $("#bazarku__alamat__penerima__wrap").find(".text-danger").text(errorMessage("alamat"));
      } else {
        $("#bazarku__alamat__penerima__wrap").find(".text-danger").text("");
      }
      if (ekspedisi == "Pilih Ekspedisi") {
        $("#bazarku__choose__ekspedisi__wrap").find(".text-danger").text(errorMessage("ekspedisi"));
      } else {
        $("#bazarku__choose__ekspedisi__wrap").find(".text-danger").text("");
      }
      if (bank == "Pilih Bank") {
        $("#bazarku__choose__bank__wrap").find(".text-danger").text(errorMessage("bank"));
      } else {
        $("#bazarku__choose__bank__wrap").find(".text-danger").text("");
      }
    };

    $("#bazarku__form__penjualan").on("submit", (e) => {
      const sales = $("#bazarku__choose__sales").val();
      const pelanggan = $("#bazarku__choose__pelanggan").val();
      const namaPenerima = $("#bazarku__nama__penerima").val();
      const notelPenerima = $("#bazarku__notel__penerima").val();
      const alamatPenerima = $("#bazarku__alamat__penerima").val();
      const ekspedisi = $("#bazarku__choose__ekspedisi").val();
      const ongkir = $("#bazarku__ongkir__pembayaran").val();
      const bank = $("#bazarku__choose__bank").val();

      checkAllFieldBeforeSubmit({
        sales,
        pelanggan,
        namaPenerima,
        notelPenerima,
        alamatPenerima,
        ekspedisi,
        ongkir,
        bank
      });

      e.preventDefault();
      if (sales != "Pilih Sales" && pelanggan != "Pilih Pelanggan" && ongkir != 0 && namaPenerima && notelPenerima && alamatPenerima && ekspedisi != "Pilih Ekspedisi" && bank != "Pilih Bank") {
        e.currentTarget.submit();
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Coba Periksa Inputan Anda!',
        });
      }
    });
  });
</script>
@endpush