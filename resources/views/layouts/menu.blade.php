<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
    <a href="{{ route('master_barang.index') }}" class="nav-link {{ Request::is('master_barang') ? 'active' : '' }}">
        <i class="nav-icon fa-solid fa-box-archive"></i>
        <p>Master Barang</p>
    </a>

    <a href="{{ route('penjualan.index') }}" class="nav-link {{ Request::is('penjualan') ? 'active' : '' }}">
        <i class="nav-icon fa-solid fa-basket-shopping"></i>
        <p>Penjualan</p>
    </a>
</li>
