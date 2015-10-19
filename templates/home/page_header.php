<div id="loader">
    <div class="loader-container">
        <img src="/templates/home/images/loader.gif" alt="" class="loader-site">
    </div>
</div>

<div id="wrapper">
    <!-- Modal -->
    <div class="modal fade modalexample" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body row">
                    <div class="col-md-6">
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner" role="listbox">
                                <div class="item active">
                                    <img src="/templates/home/upload/shop_single_01.png" class="img-responsive" alt="">
                                </div>
                                <div class="item">
                                    <img src="/templates/home/upload/shop_single_02.png" class="img-responsive" alt="">
                                </div>
                            </div>
                            <a class="left carousel-control" href="#carousel-example-generic" role="button"
                               data-slide="prev">
                                <i class="fa fa-angle-left"></i>
                                <i class="sr-only">Previous</i>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" role="button"
                               data-slide="next">
                                <i class="fa fa-angle-right"></i>
                                <i class="sr-only">Next</i>
                            </a>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-6">
                        <div class="pull-left">
                            <h4>Advanced Classic Pants</h4>
                        </div>
                        <div class="pull-right">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <span>$31.12</span>

                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-o"></i>
                        </div>
                        <!-- end rating -->

                        <p>Lorem ipsum dolor sit amet isse potenti. Vesquam ante aliquet lacusemper elit. Cras neque
                            nulla, convallis non commodo et, euismod nonsese. At vero.</p>

                        <div class="btn-group">
                            <a href="shop-cart.html" class="btn btn-primary" title="">ADD TO CART</a>
                        </div>
                        <div class="addw">
                            <a href="shop-wishlist.html"><i class="fa fa-heart-o"></i> Add to Wishlist</a>
                        </div>
                        <!-- end add -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end modal-body -->
            </div>
            <!-- end modal-content -->
        </div>
        <!-- end modal-diolog -->
    </div>
    <!-- end modal -->

    <div class="container">
        <div class="topbar">
            <div class="topbar-wrapper">
                <div class="text-left">
                    <div id="btn-cart-group" class="btn-group">
                        <?php $this->render("home/cart"); ?>
                    </div>
                </div>
                <!-- end right -->
            </div>
            <!-- end topbar-wrapper -->
        </div>
        <!-- end topbar -->

        <header class="header">
            <div class="container-wrapper">
                <div class="hovermenu ttmenu">
                    <div class="headerbg hidden-xs hidden-sm"></div>
                    <div class="navbar navbar-default" role="navigation">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                    data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="fa fa-bars"></span>
                            </button>
                            <div class="logo">
                                <a class="navbar-brand" href="<?php echo DOMAIN_NAME; ?>"><img
                                        src="/templates/home/images/logo.png" alt=""></a>
                            </div>
                        </div>
                        <!-- end navbar-header -->

                        <div class="navbar-collapse collapse">
                            <ul class="nav navbar-nav">
                                <li>
                                    <a href="/">Trang Chủ</a>
                                </li>
                                <li class="dropdown">
                                    <a href="/" class="dropdown-toggle" data-toggle="dropdown">Sản Phẩm &nbsp;<b
                                            class="fa fa-angle-down"></b></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="index-default.html">Thời Trang Bé Trai</a></li>
                                        <li><a href="index-one.html">Thời Trang Bé Gái</a></li>
                                    </ul>
                                </li>
                                <!-- end mega menu -->
                                <li><a href="about.html">Giới thiệu</a></li>
                                <li><a href="/tin-tuc.html">Tin tức</a></li>
                                <li><a href="/lien-he.html">Liên hệ</a></li>
                            </ul>
                            <!-- end nav navbar-nav -->
                        </div>
                        <!--/.nav-collapse -->
                    </div>
                    <!-- end navbar navbar-default clearfix -->
                </div>
                <!-- end menu 1 -->
            </div>
            <!-- end container -->
        </header>

        <div class="header-bottom">
            <div class="row">
                <div class="col-md-9">
                    <div class="custom-menu">
                        <?php
                        if (isset($_SESSION['user_id'])) {
                            ?>
                            <p>Chào <a class="btn-login" href="#"><?php echo $_SESSION['user_name'] ?></a>,
                                <a href="<?php echo $this->url->getUrlPage("logout"); ?>">Đăng xuất</a></p>
                            <?php
                        } else {
                            ?>
                            <p>Chào mừng bạn đến với Quần áo trẻ em Hà Nội, Vui lòng <a class="btn-login" href="#">Đăng
                                    nhập</a> hoặc <a class="btn-register" href="#">Đăng ký tài khoản</a></p>
                            <?php
                        }
                        ?>
                    </div>
                    <!-- end menu -->
                </div>
                <!-- end col -->

                <div class="col-md-3">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for products..."/>
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button">
                                <span class="fa fa-search"></span>
                            </button>
                        </span>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end header-bottom -->