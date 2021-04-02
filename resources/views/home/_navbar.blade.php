@php
$menus = array(
    ['url' => '/', 'caption' => 'Home'],
    ['url' => 'ruangan', 'caption' => 'Meeting Room'],
    ['url' => 'produk', 'caption' => 'Produk'],
    ['url' => 'sembako', 'caption' => 'Sembako'],
    ['url' => 'tumpeng', 'caption' => 'Tumpeng'],
);
@endphp

<div class="container-wapper">
    <ul class="moorabi-clone-mobile-menu moorabi-nav main-menu " id="menu-main-menu">
        @foreach($menus as $menu)
        <li class="menu-item ">
            <a href="{{ route($menu['url']) }}" class="moorabi-menu-item-title">{{ $menu['caption'] }}</a>
        </li>
        @endforeach
    </ul>
</div>
