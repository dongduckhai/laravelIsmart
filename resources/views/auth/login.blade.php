<!DOCTYPE HTML>
<html lang="en">

<head>
    <title>ISMART Đăng nhập</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords"
        content="Online Login Form Responsive Widget,Login form widgets, Sign up Web forms , Login signup Responsive web form,Flat Pricing table,Flat Drop downs,Registration Forms,News letter Forms,Elements" />
    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }

    </script>
    <!-- Meta tag Keywords -->
    <!-- css files -->
    <link rel="stylesheet" href="{{ url('public/css/styleLogin.css') }}" type="text/css" media="all" />
    <!-- Style-CSS -->
    <link rel="stylesheet" href="{{ url('public/css/font-awesome.css') }}"> <!-- Font-Awesome-Icons-CSS -->
    <!-- //css files -->
    <!-- online-fonts -->
    <link
        href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese"
        rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Dosis:200,300,400,500,600,700,800&amp;subset=latin-ext"
        rel="stylesheet">
    <!-- //online-fonts -->
</head>

<body>
    <!-- main -->
    <div class="center-container">
        <!--header-->
        <div class="header-w3l">
            <h1>Quản lý hệ thống</h1>
        </div>
        <!--//header-->
        <div class="main-content-agile">
            <div class="sub-main-w3">
                <div class="wthree-pro">
                    <h2>Đăng nhập</h2>
                </div>
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="pom-agile">
                        <input placeholder="Email..." @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email" autofocus class="user"
                            type="email" required="">
                        <span class="icon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="pom-agile">
                        <input placeholder="Mật khẩu..." @error('password') is-invalid @enderror" name="password"
                            required autocomplete="current-password" class="pass" type="password" required="">
                        <span class="icon2"><i class="fa fa-unlock" aria-hidden="true"></i></span>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="sub-w3l">
                        @if (Route::has('password.request'))
                            <h6><a href="{{ route('password.request') }}">Quên mật khẩu?</a></h6>
                        @endif
                        <div class="right-w3l">
                            <input type="submit" value="Đăng nhập">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--//main-->
    </div>
</body>

</html>
