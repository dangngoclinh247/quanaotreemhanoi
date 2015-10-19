<?php include '/templates/admin/template_start.php'; ?>
<?php include '/templates/admin/page_head.php'; ?>

    <div id="page-content">
        <!--main content-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Danh sách sản phẩm</h3>
            </div>
            <div class="panel-body">
                <form class="form-inline" action="/admin.php" method="get">
                    <input type="hidden" name="c" value="products"/>
                    <input type="hidden" name="m" value="search"/>

                    <div class="input-group">
                        <div class="input-group-addon">Tìm Kiếm</div>
                        <input type="text" class="form-control" id="p" name="p" placeholder="Text search">
                    </div>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
            <div class="panel-body">
                <!--Table users-->
                <ul class="nav nav-tabs">
                    <li role="presentation" class="active"><a
                            href="/admin.php?c=products">Show (<?php echo $this->totalItemShow ?>)</a></li>
                    <li role="presentation"><a
                            href="/admin.php?c=products&m=hide">Hide (<?php echo $this->totalItemHide ?>)</a></li>
                    <li role="presentation"><a
                            href="/admin.php?c=products&m=trash">Trash (<?php echo $this->totalItemTrash ?>)</a></li>
                </ul>
                <table id="table-products-list" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th style="width: 3%;"><input type="checkbox" class="checkbox"/></th>
                        <th style="width: 10%;">Mã SP</th>
                        <th style="width: 53%;">Tên sản phẩm</th>
                        <th style="width: 5%;">Featured</th>
                        <th style="width: 10%;">Thương Hiệu</th>
                        <th style="width: 12%;">Giá</th>
                        <th style="width: 7%; text-align: center;"><i class="fa fa-bolt fa-2x"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    <form>
                        <?php
                        foreach ($this->products as $product) {
                            ?>
                            <tr>
                                <td><input type="checkbox"/></td>
                                <td><?php echo $product['id']; ?></td>
                                <td>
                                    <?php
                                    if ($product['pro_name'] == null) {
                                        echo "(no title)";
                                    } else {
                                        echo "<a href='/admin.php?c=products&m=edit&p={$product['pro_id']}'>{$product['pro_name']}</a>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success" style="text-align: center;">
                                            <input class="checkbox-featured" data-id="<?php echo $product['pro_id'];?>"
                                                   type="checkbox" <?php if($product['pro_featured'] == 1) echo " checked ";?>/>
                                            <label>
                                            </label>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($product['brand_name'] != null) {
                                        echo "<a href='/admin.php?c=brand&m=edit&p={$product['brand_id']}'>{$product['brand_name']}</a>";
                                    } ?>
                                </td>
                                <td><?php echo number_format($product['pro_price']) . " VNĐ"; ?></td>
                                <td style="text-align: center;">
                                    <a class="btn btn-sm btn-success"
                                       href="/admin.php?c=products&m=edit&p=<?php echo $product['pro_id']; ?>">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="btn btn-sm btn-danger" href="#"
                                       onclick="del(<?php echo $product['pro_id']; ?>, this);"><i
                                            class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </form>
                    </tbody>
                </table>
                <?php echo $this->pagination->getHTML(); ?>
                <!--End Table Users-->
            </div>
        </div>
        <!--END main content-->

        <!--Modal delete products-->
        <div id="modal-products-delete-confirm" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Xóa sản phẩm</h4>
                    </div>
                    <div class="modal-body">
                        <p>Bạn có chắc chắn rằng muốn xóa sản phẩm này!</p>

                        <p class="product-delete-info-id">Mã Sản Phẩm: <strong></strong></p>

                        <p class="product-delete-info-name">Tên Sản Phẩm: <strong></strong></p>
                    </div>
                    <div class="modal-footer">
                        <button id="btnNoDelete" type="button" class="btn btn-success" data-dismiss="modal">NO</button>
                        <button id="btnDeleteConfirm" type="button" class="btn btn-warning">Yes</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <!--END Modal delete products-->

        <!--Modal delete user success-->
        <div id="modal-delete-user-success" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Xóa Người Dùng</h4>
                    </div>
                    <div class="modal-body">
                        <p>Người dùng <strong></strong> đã được xóa</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <!--END Modal delete user success-->
    </div>
<?php include '/templates/admin/page_footer.php'; ?>
<?php include '/templates/admin/template_script.php'; ?>

    <!-- Load javascript use on this page -->
    <script src="/templates/admin/js/plugins/validation/jquery.validate.min.js"></script>
    <script src="/templates/admin/js/script.js"></script>
    <script src="/templates/admin/js/pages/products.js"></script>
    <script>$(function () {
            readyProducts.init();
        })</script>


<?php include '/templates/admin/template_end.php'; ?>