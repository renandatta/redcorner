@php
use Illuminate\Support\Facades\Session;
$fitur_program = array(
    ['url' => 'admin', 'caption' => 'Dashboard', 'icon' => 'home'],
    ['url' => 'admin.user', 'caption' => 'User', 'icon' => 'user'],
    ['url' => 'admin.kategori', 'caption' => 'Kategori Produk', 'icon' => 'tag'],
    ['url' => 'admin.produk', 'caption' => 'Produk', 'icon' => 'box'],
    ['url' => 'admin.transaksi', 'caption' => 'Transaksi', 'icon' => 'shopping-cart'],
    ['url' => 'admin.ruangan', 'caption' => 'Ruangan', 'icon' => 'home'],
    ['url' => 'admin.member', 'caption' => 'Member', 'icon' => 'user'],
    ['url' => 'admin.jenis_simpanan', 'caption' => 'Jenis Simpanan', 'icon' => 'tag'],
    ['url' => 'admin.simpanan', 'caption' => 'Simpanan', 'icon' => 'shield'],
    ['url' => 'admin.pinjaman', 'caption' => 'Pinjaman', 'icon' => 'shield'],
    ['url' => 'admin.neraca', 'caption' => 'Neraca', 'icon' => 'file'],
);
$menu_active = function($route) {
    $menu_active = Session::get('menu_active') ?? '';
    return $menu_active == $route ? ' active show ' : '';
};
$sub_menu_active = function($route) {
    $sub_menu_active = Session::get('sub_menu_active') ?? '';
    return $sub_menu_active == $route ? ' active ' : '';
};
@endphp
<ul class="nav">
    @foreach($fitur_program as $fitur)
    <li class="nav-item {{ $menu_active($fitur['url']) }}">
        <a href="{{ has_route($fitur['url']) }}" class="nav-link">
            <i class="link-icon" data-feather="{{ $fitur['icon'] }}"></i>
            <span class="link-title">{{ $fitur['caption'] }}</span>
        </a>
    </li>
    @endforeach
</ul>
