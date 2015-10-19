<?php include '/templates/home/template_start.php'; ?>
<?php include '/templates/home/page_header.php'; ?>

    <div class="page-wrapper white-section clearfix">
        <?php
        if (isset($this->breadcrumb)) {
            echo $this->breadcrumb->toString();
        }
        ?>

        <hr>

        <!-- START BUILDER -->
        <div class="row">
            <div id="content" class="col-md-9 col-sm-12 pull-right">
                <div id="single-shop" class="row">
                    <div class="col-md-5">
                        <div class="relative owhidden">
                            <div id="single-carousel" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner" role="listbox">
                                    <?php
                                    if (count($this->images) > 0) {
                                        $pro_rating = 0;
                                        if ($this->product['pro_rating'] > 0) {
                                            $pro_rating = $this->product['pro_rating'];
                                        }
                                        foreach ($this->images as $key => $images) {
                                            $active = "";
                                            if ($key == 0) {
                                                $active = " active";
                                            }
                                            ?>
                                            <div class="item<?php echo $active; ?>">
                                                <img src="<?php echo $images['img_url']; ?>" class="img-responsive"
                                                     alt="<?php echo $images['img_alt']; ?>">
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                                <a class="left carousel-control" href="#single-carousel" role="button"
                                   data-slide="prev">
                                    <i class="fa fa-angle-left"></i>
                                    <i class="sr-only">Previous</i>
                                </a>
                                <a class="right carousel-control" href="#single-carousel" role="button"
                                   data-slide="next">
                                    <i class="fa fa-angle-right"></i>
                                    <i class="sr-only">Next</i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-7">
                        <div class="shop-big-title clearfix">
                            <h4><?php echo $this->product['pro_name']; ?></h4>
                            <span><?php echo number_format($this->product['pro_price'], 0); ?><sup>đ</sup></span>
                        </div>
                        <div class="rating">
                            <div class="ratebox" data-id="<?php echo $this->product['pro_id']; ?>"
                                 data-rating="<?php echo $this->product['pro_rate']; ?>"></div>
                            <small><?php echo $this->product['pro_rating']; ?> Người đánh giá</small>
                        </div>
                        <!-- end rating -->
                        <!-- end rating -->
                        <table class="table table-responsive">
                            <tbody>
                            <tr>
                                <td class="col-md-6">Mã SP</td>
                                <td class="col-md-6"><?php echo $this->product['id']; ?></td>
                            </tr>
                            <tr>
                                <td>Số lượng / Ri</td>
                                <td><?php echo $this->product['pro_size']; ?></td>
                            </tr>
                            <tr>
                                <td>Số Size</td>
                                <td><?php echo $this->product['pro_size_info']; ?></td>
                            </tr>
                            <tr>
                                <td>Thương Hiệu</td>
                                <td><?php echo $this->brand['brand_name']; ?></td>
                            </tr>
                            </tbody>
                        </table>

                        <div class="addwish">
                            <a href="shop-wishlist.html"><i class="fa fa-heart-o"></i> Add to Wishlist</a>
                        </div>
                        <!-- end addw -->
                        <div class="shopbuttons">
                            <div class="btn-group">
                                <a href="#" data-id="<?php echo $this->product['pro_id'];?>"
                                   class="btn btn-primary btn-add-to-card" title=""> Thêm vào giỏ hàng</a>
                            </div>
                        </div>
                        <!-- end shopbuttons -->
                        <div class="shopmeta">
                            <?php if (count($this->products_type) > 0) {
                                echo "<span><strong>Category:</strong> ";
                                foreach ($this->products_type as $key => $type) {
                                    echo "<a href='" . $this->url->getUrlShopType($type['prot_id'], $type['prot_slug']) . "'>{$type['prot_name']}</a>";
                                    if ($key != (count($this->products_type) - 1)) {
                                        echo ", ";
                                    }
                                }
                                echo "</span>";
                            } ?>
                        </div>
                        <!-- end shopmeta -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <div class="shop-tab">
                            <ul id="myTab" class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#home" id="home-tab" role="tab"
                                                                          data-toggle="tab" aria-controls="home"
                                                                          aria-expanded="true">Description</a></li>
                                <li role="presentation"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab"
                                                           aria-controls="profile">Reviews (02)</a></li>
                            </ul>

                            <div id="myTabContent" class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="home"
                                     aria-labelledBy="home-tab">
                                    <?php echo $this->product['pro_content']; ?>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="profile" aria-labelledBy="profile-tab">
                                    <div class="comment-list">
                                        <div class="media">
                                            <div class="pull-left relative">
                                                <img class="img-responsive img-circle" src="upload/comment_01.png"
                                                     alt="">
                                            </div>
                                            <div class="media-body">
                                                <h3>Amanda Fox</h3>
                                                <span>Google.com</span>

                                                <div class="rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <!-- end rating -->
                                                <p>Lorem ipsum dolor sit amet isse potenti. Vesquam ante aliquet
                                                    lacusemper elit. Cras neque nulla, convallis non commodo et, euismod
                                                    nonsese. At vero. Lorem ipsum dolor sit amet isse potenti. Vesquam
                                                    ante aliquet lacusemper elit. Cras neque nulla, convallis non
                                                    commodo et, euismod nonsese..</p>
                                            </div>
                                            <!-- end media-body -->
                                        </div>
                                        <!-- end media -->
                                        <div class="media">
                                            <div class="pull-left relative">
                                                <img class="img-responsive img-circle" src="upload/comment_02.png"
                                                     alt="">
                                            </div>
                                            <div class="media-body">
                                                <h3>Suzanna DOE</h3>
                                                <span>Yahoo.com</span>

                                                <div class="rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <!-- end rating -->
                                                <p>Lorem ipsum dolor sit amet isse potenti. Vesquam ante aliquet
                                                    lacusemper elit. Cras neque nulla, convallis non commodo et, euismod
                                                    nonsese. At vero. Lorem ipsum dolor sit amet isse potenti. Vesquam
                                                    ante aliquet lacusemper elit. Cras neque nulla, convallis non
                                                    commodo et, euismod nonsese Lorem ipsum dolor sit amet isse potenti.
                                                    Vesquam ante aliquet lacusemper elit. Cras neque nulla, convallis
                                                    non commodo et, euismod nonsese.</p>
                                            </div>
                                            <!-- end media-body -->
                                        </div>
                                        <!-- end media -->
                                    </div>
                                    <!-- end comment-list -->

                                    <form class="form-horizontal" role="form" method="post">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 control-label">Tên</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="name" name="name"
                                                       placeholder="Họ và Tên" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="col-sm-2 control-label">Email</label>

                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="email" name="email"
                                                       placeholder="example@domain.com" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone" class="col-sm-2 control-label">Số điện thoại</label>

                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="website" name="website"
                                                       placeholder="www.yoursite.com" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="message" class="col-sm-2 control-label">Message</label>

                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="message" rows="4"
                                                          name="message"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-10 col-sm-offset-2">
                                                <input id="submit" name="submit" type="submit" value="Submit Review"
                                                       class="btn btn-primary">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- end tabpanel -->
                            </div>
                            <!-- end tab-content -->
                        </div>
                        <!-- end shop-tab -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end col -->
            <?php $this->render("home/sidebar"); ?>
        </div>
        <!-- end content -->
    </div><!-- end white -->
    <div class="white-section withtitle clearfix">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title bgcolor">
                    <h4>Sản phẩm <span>liên quan</span></h4>
                </div>
                <!-- end section-title -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

        <div id="owl-featured">
            <?php
            foreach ($this->products_related as $product) {
                $url = $this->url->getUrlShopView($product['pro_id'], $product['pro_slug']);
                ?>
                <div class="owl-featured">
                    <div class="shop-item-list entry">
                        <a class="hover-image" href="<?php echo $url; ?>" title="">
                            <div class="img-rotate">
                                <?php
                                if (intval($product['pro_price_sale']) > 0) {
                                    echo '<span class="badge">Giảm giá</span>';
                                } else if ($product['pro_featured'] == 1) {
                                    echo '<span class="badge">Sản phẩm nổi bật</span>';
                                }
                                ?>
                                <img src="<?php echo $product['img_url']; ?>" alt="">
                            </div>
                        </a>

                        <div class="shop-item-title clearfix">
                            <h4><a href="<?php echo $url; ?>"><?php echo $product['pro_name']; ?></a></h4>

                            <div class="shopmeta">
                                <span class="pull-left"><?php echo number_format($product['pro_price'], 0); ?>
                                    <sup>đ</sup></span>

                                <div class="rating pull-right">
                                    <div class="ratebox" data-id="<?php echo $product['pro_id']; ?>"
                                         data-rating="<?php echo $product['pro_rate']; ?>"></div>
                                </div>
                                <!-- end rating -->
                            </div>
                            <!-- end shop-meta -->
                        </div>
                        <!-- end shop-item-title -->
                        <div class="visible-buttons">
                            <a data-tooltip="tooltip" data-placement="top" title="Thêm vào giỏ hàng"
                               href="#" data-id="<?php echo $product['pro_id'];?>" class="btn-add-to-card">
                                <span class="fa fa-cart-arrow-down"></span></a>
                            <a data-tooltip="tooltip" data-placement="top" title="Wishlist"
                               href="shop-wishlist.html"><span class="fa fa-heart-o"></span></a>
                            <a data-toggle="modal" data-tooltip="tooltip" data-target=".modalexample"
                               data-placement="top" title="Quick View" href="#"><span class="fa fa-eye"></span></a>
                        </div>
                        <!-- end buttons -->
                    </div>
                    <!-- end relative -->
                </div><!-- end col -->
            <?php } ?>
        </div>
        <!-- end owl-featured -->
    </div><!-- end white-section -->
<?php include '/templates/home/page_footer.php'; ?>

    <!-- Template core JavaScript's
    ================================================== -->
<?php include '/templates/home/template_script.php'; ?>

<?php include '/templates/home/template_end.php'; ?>