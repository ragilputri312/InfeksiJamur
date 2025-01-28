<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]>
<!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>

    <!-- Basic Page Needs
 ================================================== -->
    <meta charset="utf-8">
    <title>DIAGNOSIS INFEKSI JAMUR</title>
    <meta name="description" content="Professional Creative Template" />
    <meta name="author" content="IG Design">
    <meta name="keywords"
        content="ig design, website, design, html5, css3, jquery, creative, clean, animated, portfolio, blog, one-page, multi-page, corporate, business," />
    <meta property="og:title" content="Professional Creative Template" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <meta property="og:image:width" content="470" />
    <meta property="og:image:height" content="246" />
    <meta property="og:site_name" content="" />
    <meta property="og:description" content="Professional Creative Template" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="https://twitter.com/IvanGrozdic" />
    <meta name="twitter:domain" content="http://ivang-design.com/" />
    <meta name="twitter:title" content="" />
    <meta name="twitter:description" content="Professional Creative Template" />
    <meta name="twitter:image" content="http://ivang-design.com/" />

    <!-- Mobile Specific Metas
 ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="theme-color" content="#212121" />
    <meta name="msapplication-navbutton-color" content="#212121" />
    <meta name="apple-mobile-web-app-status-bar-style" content="#212121" />

    <!-- Web Fonts
 ================================================== -->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet" />

    <!-- CSS
 ================================================== -->
    <link rel="stylesheet" href="landing/css/bootstrap.min.css" />
    <link rel="stylesheet" href="landing/css/font-awesome.min.css" />
    <link rel="stylesheet" href="landing/css/style.css" />
    <link rel="stylesheet" href="landing/css/colors/color.css" />
    <link rel="stylesheet" href="landing/css/ionicons.min.css" />
    <link rel="stylesheet" href="landing/css/owl.carousel.css" />
    <link rel="stylesheet" href="landing/css/owl.transitions.css" />

    <!-- Favicons
 ================================================== -->
    <link rel="icon" type="image/png" href="favicon.png">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114.png">


</head>

<body class="royal_preloader">

    <!-- <div id="royal_preloader"></div> -->


    <!-- Nav and Logo
 ================================================== -->


    <!-- MENU
    ================================================== -->

    <nav id="menu-wrap" class="menu-back cbp-af-header">
    <div class="menu">
        <ul>
            <!-- Menu yang tersedia untuk semua pengguna -->
            <li>
                <a class="shadow-hover" href="/">Dashboard</a>
            </li>
            <li>
                <a class="shadow-hover" href="/form-diagnosa">Diagnosis</a>
            </li>

            @if(session('user_role') == 1)
            <li>
                <a class="shadow-hover" href="/dashboard">Halaman Admin</a>
            </li>
            @endif

            <!-- Menu untuk user yang belum login -->
            @if (!session()->has('user_id'))
                <li>
                    <a class="shadow-hover" href="{{ route('user.showlogin') }}">Login</a>
                </li>
            @else
                <!-- Menu untuk user yang sudah login -->
                <li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a class="shadow-hover" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>



    <!-- Primary Page Layout
 ================================================== -->

    <main>

        <!-- Hero Section -->

        <div class="section full-height mob-height">
            <div class="background-parallax" style="background-image: url('landing/img/bg_infeksi.PNG')"
                data-enllax-ratio=".5" data-enllax-type="background" data-enllax-direction="vertical"></div>
            <div class="hero-center-text-wrap">
                <div class="container text-left">
                    <div class="row">
                        <div class="col-md-12">
                            <br>
                            <br>
                            <h1 class="parallax-fade-top-2 typed">
                                @if(session()->has('user_name'))
                                    Hi, {{ session('user_name') }}! <br>
                                @endif
                                Cek Tingkat <strong>Infeksi Jamur</strong> Sekarang!<br>
                                <span id="typed-1"></span>
                            </h1>
                            <br>
                            <style>
                                .btn-glow:hover {
                                  box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
                                  transition: box-shadow 0.5s;
                                }
                              </style>
                              <div style="margin-left: 12px">

                                <a href="/form-diagnosa"  class="btn btn-dark btn-glow" role="button" style="color: rgb(218, 116, 22);">
                                  Isi form
                                </a>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#top-scroll" data-gal="m_PageScroll2id">
                <div class="scroll-to-next">ke bawah <i class="fa fa-long-arrow-down"></i></div>
            </a>
        </div>

        <!-- Portfolio -->


        <!-- Hero Section -->

        <div class="section padding-top-big padding-bottom-big">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 page-center-text-wrap text-center">
                        <h1 class="parallax"><strong>-</strong> DIAGNOSIS PENYAKIT KULIT AKIBAT INFEKSI JAMUR
                            <strong>-</strong><br><br>Sistem Pakar Menggunakan Metode Certainty Factor
                            <br> Sumber Pakar : Dokter Spesialis Kulit dan Kelamin RSUD Margono
                        </h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="section footer padding-top-big background-image-cover">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <p>Maria Pasya Saragih</p>
                    </div>
                    <div class="col-md-12 my-4">
                        <ul class="footer-social">
                            <li>
                                <a href="#">Tw</a>
                            </li>
                            <li>
                                <a href="#">Fb</a>
                            </li>
                            <li>
                                <a href="#">Ig</a>
                            </li>
                            <li>
                                <a href="#">Yt</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-12 mt-5">
                        <div class="footer-line"></div>
                    </div>
                    <div class="col-md-12 rights my-3">
                    </div>
                </div>
            </div>
        </div>

    </main>


    <!-- JAVASCRIPT
    ================================================== -->
    <script src="landing/js/jquery.js"></script>
    <script src="landing/js/royal_preloader.min.js"></script>
    <script src="landing/js/popper.min.js"></script>
    <script src="landing/js/bootstrap.min.js"></script>
    <script src="landing/js/plugins.js"></script>
    <script src="landing/js/custom.js"></script>
    <script>
        // Type text

        var typed = new Typed('#typed-1', {
            strings: ['Diagnosis', 'Penyakit', 'Kulit'],
            typeSpeed: 45,
            backSpeed: 0,
            startDelay: 200,
            backDelay: 2200,
            loop: true,
            loopCount: false,
            showCursor: true,
            cursorChar: "_",
            attr: null
        });
    </script>
    <!-- End Document
================================================== -->
</body>

</html>
