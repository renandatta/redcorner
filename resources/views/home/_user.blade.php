<div class="block-account block-header moorabi-dropdown">
    <a href="javascript:void(0);" data-moorabi="moorabi-dropdown">
        <span class="flaticon-profile"></span>
    </a>
    <div class="header-account moorabi-submenu">
        <div class="header-user-form-tabs">
            @auth
                @php($user = \Illuminate\Support\Facades\Auth::user())
                <ul class="list-group text-right" style="margin-bottom: 0;">
                    <li class="list-group-item text-center">
                        <h5 style="margin-bottom: 1rem;margin-top: 1rem">{{ $user->nama }}</h5>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('alamat') }}">Alamat</a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('transaksi') }}">Riwayat Transaksi</a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('wishlist') }}">Wishlist</a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('logout') }}">Logout</a>
                    </li>
                </ul>
            @endauth
            @guest
                <ul class="tab-link">
                    <li class="active">
                        <a data-toggle="tab" aria-expanded="true" href="#header-tab-login">Login</a>
                    </li>
                    <li>
                        <a data-toggle="tab" aria-expanded="true" href="#header-tab-rigister">Register</a>
                    </li>
                </ul>
                <div class="tab-container">
                    <div id="header-tab-login" class="tab-panel active">
                        <form method="post" class="login form-login" action="{{ route('login.proses') }}">
                            @csrf
                            <p class="form-row form-row-wide">
                                <input type="text" placeholder="Email" name="email" class="input-text">
                            </p>
                            <p class="form-row form-row-wide">
                                <input type="password" class="input-text" name="password" placeholder="Password">
                            </p>
                            <a href="{{ asset('privacy_policy.pdf') }}">Kebijakan Privasi Mega Pay</a><br>
                            <a href="{{ asset('term_agreement.pdf') }}">Syarat dan Ketentuan Pelanggan</a>
                            <br><br>
                            <p class="form-row">
                                <label class="form-checkbox">
                                    <input type="checkbox" class="input-checkbox" name="remember">
                                    <span>Remember me</span>
                                </label>
                                <br>
                                <button type="submit" class="button">Login</button>
                            </p>
                        </form>
                    </div>
                    <div id="header-tab-rigister" class="tab-panel">
                        <form method="post" class="register form-register" action="{{ route('register.proses') }}">
                            @csrf
                            <p class="form-row form-row-wide">
                                <input type="text" name="nama" placeholder="Nama" class="input-text">
                            </p>
                            <p class="form-row form-row-wide">
                                <input type="email" name="email" placeholder="Email" class="input-text">
                            </p>
                            <p class="form-row form-row-wide">
                                <input type="password" name="password" class="input-text" placeholder="Password">
                            </p>
                            <a href="{{ asset('privacy_policy.pdf') }}">Kebijakan Privasi Mega Pay</a>
                            <br><br>
                            <p class="form-row">
                                <button type="submit" class="button">Register</button>
                            </p>
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </div>
</div>
