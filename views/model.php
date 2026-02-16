<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Bootstrap, Consulting Template, Landing page, Template, Registration, Landing">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="author" content="GridTemplate">

    <!--====== Title ======-->
    <title>Takalo - Takalo</title>

    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="<?= BASE_URL ?>/assets/images/normal/favicon.svg" type="image/png">

    <!--====== Bootstrap css ======-->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/bootstrap.min.css">
    <!--====== flaticon Icons css ======-->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/fonts/flaticon.css">

    <!--====== animate CSS ======-->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/pricing-tab.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/animate.css">
    <!--====== nice-select CSS ======-->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/nice-select.css">

    <!--====== Slick CSS ======-->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/slick.css">
    <!--====== Default css ======-->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/default.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/demandecss.css">

    <!--====== Style css ======-->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>

<body data-current-user-id="<?= $_SESSION['user_id'] ?>">
    <!--[if lte IE 9]>
      <p class="browserupgrade">
        You are using an <strong>outdated</strong> browser. Please
        <a href="https://browsehappy.com/">upgrade your browser</a> to improve
        your experience and security.
      </p>
    <![endif]-->

    <!-- Preloader -->
    <div class="preloader">
        <div class="loader">
            <div id="inner-preloader">
                <div id="shadow"></div>
                <div id="box"></div>
            </div>
        </div>
    </div>
    <!-- End Preloader -->

    <!-- Start Header Area -->
    <header class="header navbar-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="nav-inner">
                        <nav class="navbar navbar-expand-lg">
                            <a class="navbar-brand" href="index.html">
                                <img src="<?= BASE_URL ?>/assets/images/normal/logo1.png" alt="Logo">
                            </a>
                            <button class="navbar-toggler mobile-menu-btn" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul id="nav" class="navbar-nav ms-auto">
                                    <li class="nav-item">
                                        <a class=" active dd-menu collapsed" href="javascript:void(0)"
                                            data-bs-toggle="collapse" data-bs-target="#submenu-list1"
                                            aria-controls="navbarSupportedContent" aria-expanded="false"
                                            aria-label="Toggle navigation"></a>
                                        <a href="<?= BASE_URL ?>/products/lists">Accueil</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class=" dd-menu collapsed" href="javascript:void(0)"
                                            data-bs-toggle="collapse" data-bs-target="#submenu-list2"
                                            aria-controls="navbarSupportedContent" aria-expanded="false"
                                            aria-label="Toggle navigation"></a>
                                        <a href="<?= BASE_URL ?>/categories/lists">Categories</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class=" dd-menu collapsed" href="javascript:void(0)"
                                            data-bs-toggle="collapse" data-bs-target="#submenu-list2"
                                            aria-controls="navbarSupportedContent" aria-expanded="false"
                                            aria-label="Toggle navigation"></a>
                                        <a href="<?= BASE_URL ?>/myproducts/lists">Mes Objets</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class=" dd-menu collapsed" href="javascript:void(0)"
                                            data-bs-toggle="collapse" data-bs-target="#submenu-list2"
                                            aria-controls="navbarSupportedContent" aria-expanded="false"
                                            aria-label="Toggle navigation"></a>
                                        <a href="<?= BASE_URL ?>/products/propositionLists">Listes des propositions</a>
                                    </li>
                                </ul>
                            </div> <!-- navbar collapse -->
                            <div class="button header-button">
                                <a href="<?= BASE_URL ?>/logout" class="btn">Log Out</a>
                            </div>
                        </nav> <!-- navbar -->
                    </div>
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </header>
    <!-- End Header Area -->

    <!-- Start Hero Area -->
    <section class="hero-area d-lg-flex align-items-center">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <!--Start Col  -->
                <div class="col-lg-10">
                    <div class="header_hero_content text-center">

                        <!-- Start Search Hero -->
                        <div class="hero-search-row wow fadeInUp" data-wow-delay=".7s">
                            <div class="row align-items-center justify-content-center">
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="search-input input-product-keword">
                                        <input type="search" class="form-control" name="keywords" placeholder="Product keywords">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-12">
                                    <div class="search-input">
                                        <select class="form-control wide">
                                            <option value="none" selected="" disabled="">Categories</option>
                                            <option value="none">Vehicle</option>
                                            <option value="none">Electronics</option>
                                            <option value="none">Mobiles</option>
                                            <option value="none">Furniture</option>
                                            <option value="none">Fashion</option>
                                            <option value="none">Jobs</option>
                                            <option value="none">Real Estate</option>
                                            <option value="none">Animals</option>
                                            <option value="none">Education</option>
                                            <option value="none">Matrimony</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-12">
                                    <div class="search-input">
                                        <select class="form-control wide">
                                            <option data-display="Locations">Locations</option>
                                            <option value="Uk, London">Uk, London</option>
                                            <option value="USA, Verginia">USA, Verginia</option>
                                            <option value="Canada">Canada</option>
                                            <option value="Austrilia">Austrilia</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-12">
                                    <div class="search-button">
                                        <button class="btn main-btn btn-inline-search"><i class="flaticon-search"></i> Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Search Hero -->
                    </div>
                </div>
                <!--End Col  -->
            </div>
        </div>
    </section>
    <!-- End Hero Area -->

    <!--====== UPCOMING BLOG POST PART START ======-->
    <?php
    define('VIEWS_PATH', realpath(__DIR__ . '/../views'));
    $allowedPages = [
        'productsLists' => 'products.php',
        'exchange' => 'exchange.php',
        'categoriesLists' => 'categories.php',
        'myProductsLists' => 'myProducts.php',
        'propositionLists' => 'propositionLists.php'
    ];
    if (isset($allowedPages[$page])) {
        $file = VIEWS_PATH . '/' . $allowedPages[$page];
        include $file;
    }
    ?>
    <!--====== UPCOMING BLOG POST PART ENDS ======-->

    <!--====== FOOTER PART START ======-->
    <footer class="footer-area">
        <div class="footer-widget pb-80">

            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="footer-link pt-35">
                            <h4 class="footer-title mb-25">Les ETU de l'equipe</h4>
                            <ul>
                                <li>ETU003895</li>
                                <li>ETU00XXXX</li>
                                <li>ETU00XXXX</li>
                            </ul>
                        </div> <!-- footer link -->
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="footer-link pt-35">
                            <h4 class="footer-title mb-25">Contacts</h4>
                            <ul>
                                <li>elienomenjanahary35@gmail.com</li>
                                <li>xxxxxxxxxxxxx@gmail.com</li>
                                <li>yyyyyyyyyyyyyy@gmail.com</li>
                            </ul>
                        </div> <!-- footer link -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- footer widget -->

        <div class="footer-copyright pt-10 pb-20">
            <div class="container">
                <div class="copyright-section d-md-flex align-items-center justify-content-between">
                    <div class="copyright text-center pt-10">
                        <p class="pt-2 text">All copyrights reserved © 2021 - Designed & Developed by <a target="_blank" href="https://gridtemplate.com/">GridTemplate</a> </p>
                    </div> <!-- copyright -->
                    <div class="footer-bottom text-lg-end pt-15">
                        <div class="payment-icons">
                            <img src="<?= BASE_URL ?>/assets/images/normal/payment.png" class="img-fluid">
                        </div>
                    </div> <!-- payment -->
                </div> <!-- copyright payment -->
            </div> <!-- container -->
        </div> <!-- footer copyright -->
    </footer>
    <!--====== FOOTER PART ENDS ======-->

    <!--====== BACK TOP TOP PART START ======-->
    <a href="#" class="back-to-top"><i class="flaticon-curve-thin-up-arrow"></i></a>
    <!--====== BACK TOP TOP PART ENDS ======-->

    <!--====== jquery js ======-->
    <script src="<?= BASE_URL ?>/assets/js/vendor/modernizr-3.6.0.min.js"></script>
    <script src="<?= BASE_URL ?>/assets/js/vendor/jquery-1.12.4.min.js"></script>

    <!--====== Bootstrap js ======-->
    <script src="<?= BASE_URL ?>/assets/js/bootstrap.min.js"></script>
    <script src="<?= BASE_URL ?>/assets/js/popper.min.js"></script>

    <!--====== Ajax Contact js ======-->
    <script src="<?= BASE_URL ?>/assets/js/waypoints.min.js"></script>
    <script src="<?= BASE_URL ?>/assets/js/lightcase.js"></script>
    <script src="<?= BASE_URL ?>/assets/js/jquery.counterup.min.js"></script>
    <script src="<?= BASE_URL ?>/assets/js/ajax-contact.js"></script>

    <!--====== pricing-tab js ======-->
    <script src="<?= BASE_URL ?>/assets/js/pricing-tab.js"></script>

    <!--====== typed js ======-->
    <script src="<?= BASE_URL ?>/assets/js/typed.js"></script>
    <!--====== Slick js ======-->
    <script src="<?= BASE_URL ?>/assets/js/slick.min.js"></script>
    <!--====== jquery.nice-select.min js ======-->
    <script src="<?= BASE_URL ?>/assets/js/jquery.nice-select.min.js"></script>
    <!--====== wow.min js ======-->
    <script src="<?= BASE_URL ?>/assets/js/wow.min.js"></script>

    <!--====== Main js ======-->
    <script src="<?= BASE_URL ?>/assets/js/main.js"></script>
    <script type="text/javascript">
        // lightcase 
        $('a[data-rel^=lightcase]').lightcase();

        // counterUp
        $('.counter').counterUp({
            delay: 100,
            time: 9000
        });

        // niceSelect 
        $(document).ready(function() {
            $('select:not(.ignore)').niceSelect();
            FastClick.attach(document.body);
        });
    </script>
</body>

</html>