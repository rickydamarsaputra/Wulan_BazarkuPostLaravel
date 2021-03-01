@extends('layout.dashboard')
@section('title', 'Tambah Penjualan')

@section('content')
<div class="section-header d-flex justify-content-between">
  <h1>@yield('title')</h1>
  @if(auth()->user()->role->nama_role != "Kasir")
  <a href="{{route('penjualan.choose.divisi')}}" class="btn btn-info">Kembali</a>
  @endif
</div>

<div class="card">
  <div class="card-body overflow-scroll">
    <form action="{{route('pembelian.submit')}}" method="POST">
      @csrf
      <div class="bazarku__penjualan__section__one">
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-lg-2">Divisi</label>
          <div class="col-lg-4">
            <input type="text" class="form-control" readonly value="{{$divisi->nama}}" name="divisi">
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-lg-2">Nomor Pembelian</label>
          <div class="col-lg-4">
            <input type="text" class="form-control" readonly value="{{$nomorPembelian}}" name="nomor_pembelian">
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-lg-2">Supplier</label>
          <div class="col-lg-4">
            <select class="form-control" name="supplier">
              <option value="">Pilih Supplier</option>
              @foreach($supplier as $loopItem)
              <option value="{{$loopItem->ID_supplier}}">{{$loopItem->nama}}</option>
              @endforeach
            </select>
            @error('supplier')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-lg-2">Tanggal Pembelian</label>
          <div class="col-lg-4">
            <input type="text" class="form-control tanggal__pembelian" name="tanggal_beli">
          </div>
        </div>
      </div>
      <div class="bazarku__line__break mb-4"></div>
      <div class="bazarku__penjualan__section__two">
        <div class="table-responsive">
          <table class="table table-bordered table-md bazarku__table__data text-center text-uppercase">
            <tr>
              <th>Produk</th>
              <th>Jumlah</th>
              <th>Harga</th>
              <th>Total</th>
              <th></th>
            </tr>
            <tr id="bazarku__produk__1" class="bazarku__produk__item">
              <td style="width: 25vw;">
                <select class="form-control" name="pembelian_detail_id_produk[]">
                  <option value="">Pilih Produk</option>
                  @foreach($produk as $loopItem)
                  <option value="{{$loopItem->ID_produk}}">{{$loopItem->nama_produk}} ({{$loopItem->qty_saat_ini}})</option>
                  @endforeach
                </select>
              </td>
              <td style="width: 100px;">
                <input type="text" class="form-control bazarku__jumlah" value="1" name="pembelian_detail_jumlah[]">
              </td>
              <td>
                <input type="text" class="form-control bazarku__harga" placeholder="0" name="pembelian_detail_harga[]">
              </td>
              <td>
                <input type="text" class="form-control bazarku__harga__total" value="0" readonly name="pembelian_detail_total[]">
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
        <div class="row d-flex justify-content-between">
          <div class="col-lg-4">
            <h6><i class="fas fa-paper-plane mr-2"></i><span>Tambahan</span></h6>
            <div class="form-group row mb-4" id="bazarku__penerima__wrap">
              <label class="col-form-label text-left col-lg-3 text-nowrap">Keterangan</label>
              <div class="col-lg">
                <textarea class="form-control" name="keterangan" style="height: 100px;" placeholder="keterangan pembelian..."></textarea>
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
              <label class="col-form-label text-left col-lg-4">Diskon</label>
              <div class="col-lg">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <span>Rp</span>
                    </div>
                  </div>
                  <input type="text" class="form-control" placeholder="0" id="bazarku__diskon__pembayaran" name="diskon">
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
                  <input type="text" class="form-control" placeholder="0" id="bazarku__pajak__pembayaran" name="pajak">
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
                  <input type="text" class="form-control" value="0" name="dibayar" readonly id="bazarku__dibayar">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <span>.-</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-left col-lg-4">Bank</label>
              <div class="col-lg">
                <select class="form-select form-select-sm" name="bank">
                  <option>Pilih Bank</option>
                  @foreach($bank as $loopItem)
                  <option value="{{$loopItem->ID_bank}}">{{$loopItem->nama_bank}}</option>
                  @endforeach
                </select>
                <small class="form-text text-danger text-capitalize"></small>
              </div>
            </div>
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(() => {
    let counterProduk = 2;
    $(".tanggal__pembelian").daterangepicker({
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

    const rupiahFormat = (nominal) => {
      return new Intl.NumberFormat("id-ID").format(nominal);
    }

    const countTotal = () => {
      let total = 0;
      const diskon = Number($('#bazarku__diskon__pembayaran').val());
      const pajak = Number($('#bazarku__pajak__pembayaran').val());
      console.log({
        diskon,
        pajak
      });

      $('.bazarku__harga__total').each((i, e) => {
        total += Number($(e).val());
      });

      $('#bazarku__total__pembayaran').val(Number(total));
      $('#bazarku__grand__total__pembayaran').val((Number(total) + pajak) - diskon);
      $('#bazarku__dibayar').val((Number(total) + pajak) - diskon);
    }

    const pembelianProdukChange = () => {
      $('.bazarku__produk__item').each((i, e) => {
        const itemID = $(e).attr('id');

        $(`#${itemID}`).find('.bazarku__harga').on('change', (e) => {
          const jumlahItem = $(`#${itemID}`).find('.bazarku__jumlah').val();
          const harga = e.target.value;

          $(`#${itemID}`).find('.bazarku__harga__total').val(jumlahItem * harga);
          countTotal();
        });

        $(`#${itemID}`).find('.bazarku__jumlah').on('change', (e) => {
          const jumlahItem = e.target.value;
          const harga = $(`#${itemID}`).find('.bazarku__harga').val();

          if (!jumlahItem || jumlahItem == 0) {
            $(`#${itemID}`).find('.bazarku__jumlah').val(1);
            $(`#${itemID}`).find('.bazarku__harga__total').val(harga);
            countTotal();
          } else {
            $(`#${itemID}`).find('.bazarku__harga__total').val(jumlahItem * harga);
            countTotal();
          }
        });
      });
    };
    pembelianProdukChange();

    $('.bazarku__added__produk').on('click', (e) => {
      const appendItem = `
      <tr id="bazarku__produk__${counterProduk}" class="bazarku__produk__item">
        <td style="width: 25vw;">
          <select class="form-control" name="pembelian_detail_id_produk[]">
            <option value="">Pilih Produk</option>
            @foreach($produk as $loopItem)
            <option value="{{$loopItem->ID_produk}}">{{$loopItem->nama_produk}} ({{$loopItem->qty_saat_ini}})</option>
            @endforeach
          </select>
        </td>
        <td style="width: 100px;">
          <input type="text" class="form-control bazarku__jumlah" value="1" name="pembelian_detail_jumlah[]">
        </td>
        <td>
          <input type="text" class="form-control bazarku__harga" placeholder="0" name="pembelian_detail_harga[]">
        </td>
        <td>
          <input type="text" class="form-control bazarku__harga__total" value="0" readonly name="pembelian_detail_total[]">
        </td>
        <td>
          <button type="button" class="btn btn-danger bazarku__delete__produk" data-element-id="bazarku__produk__${counterProduk}"><i class="fas fa-times"></i></button>
        </td>
      </tr>
      `;

      $('.bazarku__table__data').append(appendItem);
      checkIfProdukItemIsEmpty();
      pembelianProdukChange();
      $('select').select2();
      counterProduk++;
    });

    $('.bazarku__delete__produk').ready((e) => {
      $(e).on('click', (e) => {
        if (e.target.getAttribute('class') && e.target.getAttribute('class').includes('bazarku__delete__produk')) {
          Swal.fire({
            title: 'Hapus Produk Ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
              const produkItemId = e.target.getAttribute('data-element-id');
              $(`#${produkItemId}`).remove();
              checkIfProdukItemIsEmpty();
              countTotal();
              Swal.fire(
                'Produk Berhasil Dihapus!',
                '',
                'success'
              )
            }
          });
        }
      });
    });

    $('#bazarku__diskon__pembayaran, #bazarku__pajak__pembayaran').on('change', (e) => {
      countTotal();
    })
  });
</script>
@endpush

@push('styles')
<style>
  .bazarku__line__break {
    width: 100%;
    height: .5px;
    background-color: #e9ecef;
  }
</style>
@endpush