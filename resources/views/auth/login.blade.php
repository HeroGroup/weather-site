    <!DOCTYPE html>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <head>
        <link href="/css/rtl/main.css" rel="stylesheet" type="text/css">
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/font-awesome/weather-icons.min.css" rel="stylesheet">
        <link href="/css/font-awesome/font-awesome.min.css" rel="stylesheet">
        <link href="/css/rtl/util.css" rel="stylesheet" type="text/css">
        <link href="/css/rtl/sb-admin-2.css" rel="stylesheet">
        <script src="/js/main.js" type="text/javascript"></script>
        <script src="/js/jquery-1.11.0.js" type="text/javascript"></script>
        <script src="/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="/js/animsition.min.js" type="text/javascript"></script>
        <style>
            @font-face {
                font-family: IRANSans;
                src: url('/fonts/IRANSansFaNum.ttf');

            }

            html,
            body,
            span {
                font-family: IRANSans;
            }

        </style>
    </head>

    <body>
        <div class="container-login100 "
            style="background-image: url('/image/abstract.jpg');background-size:cover;background-position:center;">
            <div class="wrap-login100 p-t-10 p-b-20 p-l-10 p-r-10"
                style="box-shadow: 2px 1px rgb(19, 191, 191), -1em 0 2em rgb(19, 191, 191);">
                <form method="POST" action="{{ route('login') }}" class="login100-form validate-form">
                    @csrf
                    <span class="login100-form-title p-b-10">
                        خوش آمدید
                    </span>
                    <span class="login100-form-avatar">
                        <img src="/image/weather.jpg" alt="AVATAR">
                    </span>
                    <div dir="rtl" class="wrap-input100 m-t-10 m-b-20" data-validate="Enter username">
                        <label>نام کاربری:</label>
                        <input id="mobile" class="input100" type="text" name="mobile" :value="old('mobile')" required
                            autofocus>
                        {{-- <span class="focus-input100" data-placeholder="نام کاربری"
                            for="email"></span> --}}
                    </div>

                    <div dir="rtl" class="wrap-input100 m-b-5" data-validate="Enter password">
                        <label>کلمه عبور:</label>
                        <input id="password" type="password" class="input100" type="password" name="password" required
                            autocomplete="current-password">
                        {{-- <span class="focus-input100" data-placeholder="کلمه عبور"
                            for="password"></span> --}}
                    </div>

                    <div class="block mt-4" style="float: right">
                        <label for="remember_me" class="flex items-center">
                            <span class="ml-2 text-sm text-gray-600">به خاطر بسپار</span>
                            <input id="remember_me" type="checkbox" class="form-checkbox" name="remember">
                        </label>
                    </div>
                    <br>
                    {{-- <div class="flex items-center justify-start mt-4"
                        style="float: right">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900"
                                href="{{ route('password.request') }}">
                                آیا کلمه عبور خود را فراموش کرده اید؟
                            </a>
                        @endif
                    </div> --}}
                    <div class="container-login100-form-btn">
                        <button class="btn btn-block btn-dark" style="font-size:x-large;">
                            ورود
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </body>
