<div id="sidebar" class="col-md-3 col-sm-12">
    <div class="widget">
        <div class="newsletter">
            <h4>Đăng ký</h4>

            <p>Đăng ký nhận báo giá và thông tin chương trình khuyến mãi</p>

            <form class="subscribe">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Enter your email..."/>
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button">
                                            <span class="fa fa-envelope-o"></span>
                                        </button>
                                    </span>
                </div>
            </form>
        </div>
        <!-- end newsletter -->
    </div>
    <!-- end widget -->

    <div class="widget">
        <div class="widget-title">
            <h4>Danh mục sản phẩm</h4>
        </div>
        <!-- end section-title -->
        <ul>
            <li><a href="#">Delivery Time</a></li>
            <li><a href="#">Order Tracking</a></li>
            <li><a href="#">Shopping Cart</a></li>
            <li><a href="#">My Account</a></li>
            <li><a href="#">Secure Payment</a></li>
        </ul>
    </div>
    <!-- end widget -->
    <div class="widget">
        <div class="widget-title">
            <h4>Sản phẩm nổi bật</h4>
        </div>
        <!-- end section-title -->

        <div class="top-rated-widget">
            <?php
            foreach ($this->products_featured as $product) {
                $url = $this->url->getUrlShopView($product['pro_id'], $product['pro_slug']);
                ?>
                <div class="media">
                    <div class="pull-left relative">
                        <a href="<?php echo $url; ?>" title="">
                            <img src="<?php echo $product['img_url']; ?>" alt="">
                        </a>
                    </div>
                    <div class="media-body">
                        <h3><a href="<?php echo $url; ?>"><?php echo $product['pro_name']; ?></a></h3>
                        <span><?php echo number_format($product['pro_price'], 0); ?><sup>đ</sup></span>

                        <div class="rating">
                            <div class="ratebox" data-id="<?php echo $product['pro_id']; ?>"
                                 data-rating="<?php echo $product['pro_rate']; ?>"></div>
                        </div>
                        <!-- end rating -->
                    </div>
                    <!-- end media-body -->
                </div>
                <!-- end media -->
                <?php
            }
            ?>
        </div>
        <!-- end top-rated-widget -->
    </div>
    <!-- end widget -->

    <div class="widget">
        <div class="widget-title">
            <h4>Get In Touch</h4>
        </div>
        <!-- end section-title -->
        <ul>
            <li><i class="fa fa-envelope-o"></i> <a
                    href="<?php $this->url->getUrlPage("lien-he"); ?>"><?php echo $this->options['company_email']; ?></a>
            </li>
            <li><i class="fa fa-phone"></i> <?php echo $this->options['company_phone1']; ?></li>
            <li><i class="fa fa-link"></i> <a href="<?php echo $this->options['company_website']; ?>"><?php echo $this->options['company_website']; ?></a></li>
        </ul>
        <div class="big-social">
            <a href="#" title=""><i class="fa fa-facebook"></i></a>
            <a href="#" title=""><i class="fa fa-twitter"></i></a>
            <a href="#" title=""><i class="fa fa-google-plus"></i></a>
        </div>
        <!-- end big-social -->
    </div>
    <!-- end widget -->

</div>