<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <img src="{{ asset('adminbsb/images/user.png') }}" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">John Doe</div>
            <div class="email">john.doe@example.com</div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
                    <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
                    <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="javascript:void(0);"><i class="material-icons">input</i>Sign Out</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li>
                <a href="{{ route('users.index') }}">
                    <i class="active material-icons">person</i>
                    <span>User</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">account_box</i>
                    <span>Member</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="{{ route('members.index') }}">Member</a>
                    </li>
                    <li>
                        <a href="{{ route('memberCat.index') }}">Kategori Member</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">shopping_cart</i>
                    <span>Produk</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="{{ route('products.index') }}">Produk</a>
                    </li>
                    <li>
                        <a href="{{ route('product_categories.index') }}">Kategori Produk</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('stocks.index') }}">
                    <i class="active material-icons">assignment</i>
                    <span>Stok</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">local_offer</i>
                    <span>Promo</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="{{ route('promos.index') }}">Promo</a>
                    </li>
                    <li>
                        <a href="{{ route('codepromo.index') }}">Kode Promo</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">assessment</i>
                    <span>Laporan</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="{{ route('stocks.report') }}"><span>Stok</span></a>
                    </li>
                    <li>
                        <a href="{{ route('sales.index') }}"><span>Penjualan</span></a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <span>Transaksi</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="{{ route('transactions.index') }}">
                                    <span>Semua</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('transactions.member') }}">
                                    <span>Member</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- #Menu -->
</aside>
