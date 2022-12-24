@php
$menus = array(
    ['url' => '/', 'caption' => 'Home']
);
@endphp

<div class="container-wapper">
    <ul class="moorabi-clone-mobile-menu moorabi-nav main-menu " id="menu-main-menu">
        @foreach($menus as $menu)
        <li class="menu-item ">
            <a href="{{ route($menu['url']) }}" class="moorabi-menu-item-title">{{ $menu['caption'] }}</a>
        </li>
        @endforeach
        @foreach ($kategori_all as $key => $value)
                <li class="menu-item ">
                    <a href="{{ route('kategori', $value->slug) }}" class="moorabi-menu-item-title">{{ $value->nama }}</a>
                </li>
        @endforeach
    </ul>
</div>
