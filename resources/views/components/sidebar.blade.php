<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{route('dashboard.index')}}">Bazarku</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{route('dashboard.index')}}">BZ</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li>
                <a class="nav-link" href="{{route('dashboard.index')}}"><i class="fas fa-pencil-ruler"></i> <span>Dashboard</span></a>
            </li>
            @if(auth()->user()->role->nama_role != "Kasir")
            <li class="menu-header">Starter</li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-shopping-cart"></i><span>Penjualan</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="{{route('penjualan.index')}}"><i class="far fa-chart-bar"></i><span>Semua Penjualan</span></a>
                    </li>
                    @if(auth()->user()->role->nama_role != "Kasir")
                    <li>
                        <a class="nav-link" href="{{route('penjualan.choose.divisi')}}"><i class="fas fa-cart-plus"></i><span>Tambah Penjualan</span></a>
                    </li>
                    @endif
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-align-justify"></i><span>Master</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="{{route('bank.index')}}"><i class="fas fa-money-check-alt"></i><span>Bank</span></a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{route('divisi.index')}}"><i class="fas fa-user-md"></i><span>Divisi</span></a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{route('sales.index')}}"><i class="fas fa-comments-dollar"></i><span>Sales</span></a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{route('ekspedisi.index')}}"><i class="fas fa-shipping-fast"></i><span>Ekspedisi</span></a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{route('perkiraan.akuntansi.index')}}"><i class="fas fa-sort-amount-up-alt"></i><span>Perkiraan Akuntansi</span></a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{route('supplier.index')}}"><i class="fas fa-user-tag"></i><span>Supplier</span></a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{route('pelanggan.index')}}"><i class="fas fa-male"></i><span>Pelanggan</span></a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-book"></i><span>Report</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="{{route('report.stok-produk.index')}}"><i class="fas fa-cubes"></i><span>A. Stok Produk</span></a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{route('report.pembelian.index')}}"><i class="fas fa-cart-arrow-down"></i><span>D. Pembelian</span></a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{route('report.penjualan.index')}}"><i class="fas fa-cart-arrow-down"></i><span>E. Penjualan</span></a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{route('report.retur-penjualan.index')}}"><i class="fas fa-undo"></i><span>F. Retur Penjualan</span></a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{route('report.laba.index')}}"><i class="fas fa-balance-scale"></i><span>L. Laba Rugi</span></a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{route('report.produk.terlaris.index')}}"><i class="fab fa-dropbox"></i><span class="text-nowrap">H. Produk Terlaris</span></a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{route('report.stok-produk-lengkap.index')}}"><i class="fas fa-box-open"></i><span class="text-nowrap">W. Stok Produk Lengkap</span></a>
                    </li>
                </ul>
            </li>
            @endif
        </ul>

        <!-- <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
            </a>
        </div> -->
    </aside>
</div>