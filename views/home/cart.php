<?php
if (!isset($this->cart)) {
    ?>
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
            aria-expanded="false"><i class="fa fa-cart-plus"></i> Giỏ Hàng: (0 sản phẩm)</button>
    <?php
} else {
    ?>
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
            aria-expanded="false"><i class="fa fa-cart-plus"></i> Giỏ Hàng: (<?php echo $this->cart->totalProduct();?> sản phẩm) <span
            class="dropme"></span></button>
    <ul class="dropdown-menu cartdrop" role="menu">
        <li>
            <ul style="max-height: 400px; overflow-y: scroll; overflow-x: hidden">
                <?php
                foreach($this->cart->getProducts() as $product) {
                    $url = $this->url->getUrlShopView($product['pro_id'], $product['info']['pro_slug']);
                    ?>
                    <li>
                        <a href="<?php echo $url;?>">
                            <img title="product" alt="product" class="alingleft"
                                 src="<?php echo $product['info']['img_url'];?>">
                            <h4><?php echo $this->getShortText($product['info']['pro_name'], 35);?>
                                <small>Số lượng : <?php echo $product['quantity'];?></small>
                            </h4>
                        </a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </li>
        <li>
            <a href="/gio-hang.html" class="btn btn-primary">Thanh Toán</a>
        </li>
    </ul>
    <?php
}