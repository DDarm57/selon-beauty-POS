<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : 'collapsed' }}"
                href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->
        @if (Auth::user()->role == '1')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('users') ? 'active' : 'collapsed' }}"
                    href="{{ route('users') }}">
                    <i class="bi bi-people"></i>
                    <span>Data User</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#data-produk" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-box-seam"></i><span>Produk</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="data-produk" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('categories') }}"
                            class="{{ request()->routeIs('categories') ? 'active' : 'collapsed' }}">
                            <i class="bi bi-circle"></i><span>Kategori</span>
                        </a>
                        <a href="{{ route('products') }}"
                            class=" {{ request()->routeIs('products') ? 'active' : 'collapsed' }}">
                            <i class="bi bi-circle"></i><span>Data Produk</span>
                        </a>
                        <a href="{{ route('stocks') }}"
                            class="{{ request()->routeIs('stocks') ? 'active' : 'collapsed' }}">
                            <i class="bi bi-circle"></i><span>Stok</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Components Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-cash-coin"></i><span>Keuangan</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a class="{{ request()->routeIs('incomes') ? 'active' : 'collapsed' }}"
                            href="{{ route('incomes') }}">
                            <i class="bi bi-circle"></i><span>Pemasukan</span>
                        </a>
                        <a class="{{ request()->routeIs('expenses') ? 'active' : '' }}"
                            href="{{ route('expenses') }}">
                            <i class="bi bi-circle"></i><span>Pengeluaran</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Components Nav -->
        @endif
        @if (Auth::user()->role == '2')
            <li class="nav-heading">Transaksi</li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('transaction') ? 'active' : 'collapsed' }}"
                    href="{{ route('transaction') }}">
                    <i class="bi bi-cart-plus"></i>
                    <span>Transaksi</span>
                </a>
            </li><!-- End Profile Page Nav -->
        @endif
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('transaction_history') ? 'active' : 'collapsed' }}"
                href="{{ route('transaction_history') }}">
                <i class="bi bi-cart-check"></i>
                <span>Riwayat Transaksi</span>
            </a>
        </li><!-- End Profile Page Nav -->
        @if (Auth::user()->role == '1')
            <li class="nav-heading">Pengaturan</li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('profile') ? 'active' : 'collapsed' }}"
                    href="{{ route('profile') }}">
                    <i class="bi bi-gear"></i>
                    <span>Profil Toko</span>
                </a>
            </li><!-- End Profile Page Nav -->
        @endif
    </ul>
</aside><!-- End Sidebar-->
