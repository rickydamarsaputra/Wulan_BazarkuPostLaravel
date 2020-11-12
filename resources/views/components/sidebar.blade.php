<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Bazarku</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">BZ</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item dropdown {{request()->is('penjualan') ? 'active' : ''}}">
                <a href="{{route('penjualan.index')}}" class="nav-link has-dropdown"><i class="fas fa-shopping-cart"></i><span>Penjualan</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="index-0.html"><i class="far fa-chart-bar"></i><span>Semua Penjualan</span></a>
                    </li>
                    <li><a class="nav-link" href="index.html"><i class="fas fa-cart-plus"></i><span>Tambah Penjualan</span></a></li>
                </ul>
            </li>
            <li class="nav-item dropdown {{request()->is('master/pelanggan') ? 'active' : ''}}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-align-justify"></i><span>Master</span></a>
                <ul class="dropdown-menu">
                    <li class="{{request()->is('master/pelanggan') ? 'active' : ''}}">
                        <a class="nav-link" href="{{route('pelanggan.index')}}"><i class="fas fa-male"></i><span>Pelanggan</span></a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{route('pelanggan.index')}}"><i class="fas fa-money-check-alt"></i><span>Bank</span></a>
                    </li>
                </ul>
            </li>
            <li class="menu-header">Starter</li>
            <li>
                <a class="nav-link" href="credits.html"><i class="fas fa-pencil-ruler"></i> <span>Credits</span></a>
            </li>
        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
            </a>
        </div>
    </aside>
</div>