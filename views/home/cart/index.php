<?php include '/templates/home/template_start.php'; ?>
<?php include '/templates/home/page_header.php'; ?>
    <div class="page-wrapper white-section clearfix">
        <div class="row">
            <div class="col-md-8">
                <h2>Shop Checkout</h2>
            </div>
            <!-- end col -->

            <div class="col-md-4">
                <ol class="breadcrumb text-right">
                    <li><a href="#">Home</a></li>
                    <li class="active">Shop Checkout</li>
                </ol>
            </div>
        </div>
        <!-- end row -->

        <hr>

        <!-- START BUILDER -->
        <div id="single-shop" class="row">
            <div class="col-md-12">

                <div class="table-responsive">
                    <table id="cart-table" class="table table-condensed">
                        <thead>
                        <tr>
                            <th>Xóa</th>

                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số Lượng</th>
                            <th>Tổng giá</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $products = $this->cart->getProducts();
                        foreach ($products as $cart) {
                            $quantity = $cart['quantity'];
                            $product = $cart['info'];
                            $url = $this->url->getUrlShopView($product['pro_id'], $product['pro_slug']);
                            if (isset($product['img_url']) && $product['img_url'] != "") {
                                $img_url = $product['img_url'];
                            } else {
                                $img_url = $this->options['img_product'];
                            }
                            ?>
                            <tr>
                                <td class="product-remove">
                                    <a class="remove btn-cart-remove" data-id="<?php echo $product['pro_id']; ?>"
                                       title="Remove this product" href="#">×</a>
                                </td>
                                <td>
                                    <div class="media">
                                        <div class="relative">
                                            <a href="<?php echo $url; ?>" data-id="<?php echo $product['pro_id']; ?>"
                                               title="">
                                                <img src="<?php echo $img_url; ?>" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    <!-- end media -->
                                </td>
                                <td>
                                    <a href="<?php echo $url; ?>"><?php echo $product['pro_name']; ?>
                                        - <?php echo $product['id']; ?></a>
                                </td>
                                <td><span
                                        class="pro_price"><?php echo number_format($product['pro_price'], 0); ?></span>
                                    <sup>đ</sup></td>
                                <td>
                                    <span class="cart-quantity center-block"
                                          data-id="<?php echo $product['pro_id']; ?>"
                                          data-quantity="<?php echo $quantity; ?>"><?php echo $quantity; ?></span>
                                </td>
                                <td>
                                    <span
                                        class="pro_price_total"><?php echo number_format($this->cart->getPrice($cart), 0); ?></span><sup>đ</sup>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <!-- end table -->

                <div class="totalarea margin-top row">
                    <div class="col-md-8">
                        <div class="note-order">
                            <h2>Lưu ý</h2>
                            <ul class="custom">
                                <li>Đọc ký hướng dẫn mua hàng trước khi order</li>
                                <li>Xem qua chính sách đổi trả</li>
                                <li>Chúng tôi sẽ liên hệ với bạn khi nhận được order</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4" style="text-align: right">
                        <div class="totalprice">
                            <h2>Tổng Đơn Hàng</h2>

                            <p>Total : <span
                                    class="cart_price"><?php echo number_format($this->cart->getTotalPrice(), 0); ?></span><sup>đ</sup>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- end totalarea -->

                <!-- START BUILDER -->
                <div id="single-shop" class="row">
                    <div class="col-md-12">
                        <form action="" method="post" class="shopform">
                            <div class="row">
                                <div class="col-md-6">
                                    <h2>Thông tin thanh toán</h2>
                                    <?php
                                    if (!isset($_SESSION['user_id'])) {
                                        ?>
                                        <p>Nếu bạn Đã có tài khoản, Vui lòng <a class="btn-login" href="#">Đăng
                                                nhập</a> để đặt hàng </p>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                                                <label>Họ & Tên *</label>
                                                <input type="text" name="user_name" id="user_name" class="form-control"
                                                       placeholder="First Name">
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <label>Email</label>
                                                <input type="email" name="user_email" id="user_email"
                                                       class="form-control"
                                                       placeholder="Company Name">
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <label>Số điện thoại *</label>
                                                <input type="text" name="user_phone1" id="user_phone1"
                                                       class="form-control"
                                                       placeholder="Address Line 1">
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <label>Địa chỉ *</label>
                                            <textarea name="user_address" id="user_address" class="form-control"
                                                      placeholder="Địa chỉ" rows="4"></textarea>
                                            </div>
                                        </div>
                                        <?php
                                    } else {
                                        ?>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                                                <label>Họ & Tên *</label>
                                                <input type="text" name="user_name" id="user_name" class="form-control"
                                                       placeholder="First Name" value="<?php echo $this->user['user_name'];?>">
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <label>Email</label>
                                                <input type="email" name="user_email" id="user_email"
                                                       class="form-control"
                                                       placeholder="Company Name" value="<?php echo $this->user['user_email'];?>" disabled>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <label>Số điện thoại *</label>
                                                <input type="text" name="user_phone1" id="user_phone1"
                                                       class="form-control"
                                                       placeholder="Address Line 1" value="<?php echo $this->user['user_phone1'];?>">
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <label>Địa chỉ *</label>
                                            <textarea name="user_address" id="user_address" class="form-control"
                                                      placeholder="Địa chỉ" rows="4"><?php echo $this->user['user_address'];?></textarea>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <!-- end row -->
                                </div>
                                <!-- end col -->
                                <div class="col-md-6">
                                    <h2>Địa chỉ nhận hàng (Nếu khác địa chỉ thanh toán)</h2>
                                    <label>Other Notes</label>
                                    <textarea rows="6" class="form-control" placeholder="Thông tin thêm"
                                              name="user_note"></textarea>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->

                            <br><br>


                            <div class="totalarea margin-top row">
                                <label class="checkbox payment-method inline">
                                    <input type="radio" name="loai" value="1" checked> Chuyển khoản ngân
                                    hàng
                                    <span class="custom2">Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order wont be shipped until the funds have cleared in our account.</span>
                                </label>
                                <label class="checkbox payment-method inline">
                                    <input type="radio" name="loai" value="2"> Nhận hàng trả tiền
                                </label>
                                <label class="checkbox payment-method inline">
                                    <input type="radio" name="loai" value="3"> Đến công ty lấy
                                </label>
                                <button type="submit" class="btn btn-primary pull-right">ĐẶT HÀNG</button>
                            </div>
                            <!-- end totalarea -->
                        </form>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div><!-- end white -->

    <!-- PAGE Footer -->
<?php include '/templates/home/page_footer.php'; ?>

    <!-- Template core JavaScript's
    ================================================== -->
<?php include '/templates/home/template_script.php'; ?>
    <script>
        $(document).ready(function () {
            $(".btn-cart-remove").click(function () {
                var pro_id = $(this).attr("data-id");
                var currentElement = $(this).closest("tr");
                $.ajax({
                    url: "/home.php?c=shop&m=remove_from_cart&p=" + pro_id,
                    success: function (result) {
                        if (result == "1") {
                            currentElement.fadeOut(500);
                            setTimeout(function () {
                                window.location.reload();
                            }, 500);
                        }
                        else {
                            alert("Loi " + result);
                        }
                    },
                    error: function (e) {
                        alert(e);
                    }
                });
            });

            $(document).on("click", ".cart-quantity", function () {
                var pro_id = $(this).attr("data-id");
                var quantity = $(this).attr("data-quantity");
                var td = $(this).closest("td");
                td.html("<input class='quantity-update' type='number' data-id='" + pro_id + "' value='" + quantity + "' min='1' max='100'>");
            });

            $(document).on("change", ".quantity-update", function () {
                var pro_id = $(this).attr("data-id");
                var quantity = $(this).val();
                var td = $(this).closest("td");
                var tr = td.closest("tr");
                var pro_price = $(tr).find(".pro_price").text().replace(",", "");
                var pro_price_total = (parseInt(pro_price) * parseInt(quantity)).format(0, 3, ",");
                $.ajax({
                    url: "/home.php?c=shop&m=update_quantity&p=" + pro_id,
                    type: "post",
                    data: {
                        pro_quantity: quantity
                    },
                    success: function (result) {
                        if (result == "1") {
                            var str = "<span class='cart-quantity center-block' " +
                                "data-id='" + pro_id + "' " +
                                "data-quantity='" + quantity + "'>" + quantity + "</span>";
                            td.html(str);
                            tr.find(".pro_price_total").html(pro_price_total);
                            calculator()

                        }
                        else {
                            alert("Số lượng sản phẩm lớn hơn 1");
                        }
                    },
                    error: function (e) {
                        alert(e);
                    }
                });
            })
        })
        /**
         * Number.prototype.format(n, x, s, c)
         *
         * @param integer n: length of decimal
         * @param integer x: length of whole part
         * @param mixed   s: sections delimiter
         * @param mixed   c: decimal delimiter
         */
        Number.prototype.format = function (n, x, s, c) {
            var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
                num = this.toFixed(Math.max(0, ~~n));

            return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
        };

        function calculator() {
            var total = 0;
            $(".pro_price_total").each(function () {
                var price_total = $(this).text().split(",").join("");
                var pro_price_total = parseFloat(price_total);
                total += pro_price_total;
            });
            $(".cart_price").html(total.format(0, 3, ","));
        }
        ;


    </script>
<?php include '/templates/home/template_end.php'; ?>