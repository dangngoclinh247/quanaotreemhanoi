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
                <div id="single-shop">

                    <div id="shoplist" class="row">
                        <?php
                        foreach ($this->products as $key => $product) {
                            $url = $this->url->getUrlShopView($product['pro_id'], $product['pro_slug']);
                            if($product['pro_rate'] == null)
                            {
                                $product['pro_rate'] = 0;
                            }
                            //echo $key;
                            ?>
                            <div class="col-md-4 col-sm-6"<?php if(($key)%3 == 0) echo " style='clear: both'"?>">
                                <div class="shop-item-list entry">
                                    <a class="hover-image" href="<?php echo $url;?>" title="">
                                        <div class="img-rotate">
                                        <?php
                                        if(intval($product['pro_price_sale']) > 0)
                                        {
                                            echo '<span class="badge">Giảm giá</span>';
                                        }
                                        else if($product['pro_featured'] == 1)
                                        {
                                            echo '<span class="badge">Sản phẩm nổi bật</span>';
                                        }
                                        ?>

                                            <img src="<?php echo $product['img_url']; ?>" alt="">
                                            <?php if (count($product['images']) > 0) {
                                                echo '<img src="' . $product['images'][0]['img_url'] . '" class="rotate-image"
                                                 alt="">';
                                            } ?>

                                        </div>
                                    </a>

                                    <div class="shop-item-title clearfix">
                                        <h4><a href="<?php echo $url;?>"><?php echo $product['pro_name']; ?></a></h4>

                                        <div class="shopmeta">
                                            <span class="pull-left"><?php echo number_format($product['pro_price'],0); ?><sup>đ</sup></span>
                                            <div class="rating pull-right">
                                                <div class="ratebox" data-id="<?php echo $product['pro_id'];?>"
                                                data-rating="<?php echo $product['pro_rate'];?>"></div>
                                            </div>
                                            <!-- end rating -->
                                        </div>
                                        <!-- end shop-meta -->
                                    </div>
                                    <!-- end shop-item-title -->
                                    <div class="visible-buttons">
                                        <a data-tooltip="tooltip" data-placement="top" title="Thêm vào giỏ hàng"
                                           href="#Add-To-Cart" data-id="<?php echo $product['pro_id'];?>" class="btn-add-to-card">
                                           <span class="fa fa-cart-arrow-down"></span></a>
                                        <a data-tooltip="tooltip" data-placement="top" title="Wishlist"
                                           href="#"><span class="fa fa-heart-o"></span></a>
                                        <a data-toggle="modal" data-tooltip="tooltip" data-target=".modalexample"
                                           data-placement="top" title="Quick View" href="#"><span
                                                class="fa fa-eye"></span></a>
                                    </div>
                                    <!-- end buttons -->
                                </div>
                                <!-- end relative -->
                            </div>
                            <!-- end col -->
                            <?php
                        }
                        ?>
                    </div>
                    <!-- end shoplist -->
                </div>
                <!-- end row -->
            </div>
            <!-- end col -->
            <?php $this->render("home/sidebar"); ?>
        </div>
        <!-- end content -->
    </div><!-- end white -->

<?php include '/templates/home/page_footer.php'; ?>

    <!-- Template core JavaScript's
    ================================================== -->
<?php include '/templates/home/template_script.php'; ?>

<?php include '/templates/home/template_end.php'; ?>