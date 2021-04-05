<div class="block-account block-header moorabi-dropdown">
    <a href="javascript:void(0);" data-moorabi="moorabi-dropdown">
        <span class="flaticon-profile"></span>
    </a>
    <div class="header-account moorabi-submenu">
        <div class="header-user-form-tabs">
            @auth
                @php($user = \Illuminate\Support\Facades\Auth::user())
                <div class="text-center">
                    <h5 class="text-center pt-3">{{ $user->nama }}</h5>
                    <a href="{{ route('logout') }}" class="button py-2">Logout</a>
                    <br><br>
                </div>
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
                                <input type="email" placeholder="Email" name="email" class="input-text">
                            </p>
                            <p class="form-row form-row-wide">
                                <input type="password" class="input-text" name="password" placeholder="Password">
                            </p>
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
