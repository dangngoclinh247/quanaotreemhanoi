<?php include '/templates/admin/template_start.php'; ?>
<?php include '/templates/admin/page_head.php'; ?>
<?php
function getProductsType($data, $prefix = "", $arrSelected = array())
{
    $result = "";
    foreach ($data as $item) {
        $checked = "";
        if (in_array($item['prot_id'], $arrSelected)) {
            $checked = " checked";
        }
        $result .= '<tr><td>' . $prefix . '<input class="prot_id" type="checkbox" name="prot_id[]" value="' . $item['prot_id'] . '"' . $checked . '>&nbsp;' . $item['prot_name'] . '</tr></td>';
        if (isset($item['submenu']) && $item['submenu'] != null) {
            $result .= getProductsType($item['submenu'], $prefix . "&nbsp;&nbsp;&nbsp;&nbsp;", $arrSelected);
        }
    }
    return $result;
}

?>
    <form id="form-products-edit" class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        <div class="col-md-9 no-padding-left">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Thêm sản phẩm mới</h3>
                </div>
                <div class="panel-body">
                    <div id="message">&nbsp;</div>
                    <!--form add users-->

                    <div class="form-group">
                        <label for="input-name" class="col-sm-2 control-label">Tên sản phẩm</label>

                        <div class="col-sm-10 input-group">
                            <input type="text" class="form-control" id="pro_name" name="pro_name"
                                   placeholder="Tiêu đề tin tức" value="<?php echo $this->product['pro_name']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                                <span class="input-group-addon"
                                      id="basic-addon1">http://quanaotreemhanoi.com/san-pham/</span>
                            <input type="text" class="form-control" id="pro_slug" name="pro_slug"
                                   placeholder="Url bài viết" value="<?php echo $this->product['pro_slug']; ?>">
                            <span class="input-group-addon">.html</span>
                        </div>
                    </div>
                    <div class="form-group">
                            <textarea class="form-control" rows="3"
                                      id="pro_content"
                                      name="pro_content"><?php echo $this->product['pro_content']; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Thông tin sản phẩm</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="pro_id" class="col-sm-2 control-label">Mã sản phẩm: </label>

                        <div class="col-sm-6 input-group" style="padding-left: 15px;">
                            <input type="text" class="form-control"
                                   id="pro_id" name="pro_id"
                                   placeholder="mã sản phẩm" value="<?php echo $this->product['id']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="pro_size" class="col-sm-2 control-label">Số Size / Ri: </label>

                        <div class="col-sm-6 input-group" style="padding-left: 15px;">
                            <input type="text" class="form-control"
                                   id="pro_size" name="pro_size"
                                   placeholder="Size" value="<?php echo $this->product['pro_size']; ?>">
                            <span class="input-group-addon">sản phẩm / ri</span>
                        </div>
                        <label id="pro_size-error" class="error col-sm-offset-2" for="pro_size"
                               style="padding-left: 15px;"></label>
                    </div>

                    <div class="form-group">
                        <label for="pro_size_info" class="col-sm-2 control-label">Thông tin Size: </label>

                        <div class="col-sm-6 input-group" style="padding-left: 15px;">
                            <input type="text" class="form-control"
                                   id="pro_size_info" name="pro_size_info"
                                   placeholder="Size Info" value="<?php echo $this->product['pro_size_info']; ?>">
                            <span class="input-group-addon">Tuổi</span>
                        </div>
                        <label id="pro_size_info-error" class="error col-sm-offset-2" for="pro_size_info"
                               style="padding-left: 15px;"></label>
                    </div>

                    <div class="form-group">
                        <label for="pro_price" class="col-sm-2 control-label">
                            Giá / sản phẩm: </label>

                        <div class="col-sm-6 input-group" style="padding-left: 15px;">
                            <input type="text" class="form-control"
                                   id="pro_price" name="pro_price"
                                   placeholder="Giá" value="<?php echo $this->product['pro_price']; ?>">
                            <span class="input-group-addon">VNĐ</span>
                        </div>
                        <label id="pro_price-error" class="error col-sm-offset-2" for="pro_price"
                               style="padding-left: 15px;"></label>
                    </div>

                    <div class="form-group form-inline">
                        <div class="col-md-2"><label for="brand_id" class="control-label">
                                Thương hiệu: </label></div>

                        <div class="col-md-10 form-inline">
                            <select id="brand_id" class="form-control select2" name="brand_id">
                                <option value="">Thương hiệu</option>
                                <?php
                                foreach ($this->brands as $brand) {
                                    $selected = "";
                                    if ($brand['brand_id'] == $this->product['brand_id'])
                                        $selected = " selected";
                                    ?>
                                    <option
                                        value="<?php echo $brand['brand_id']; ?>"<?php echo $selected ?>><?php echo $brand['brand_name']; ?></option>
                                    <?php
                                }
                                ?>

                            </select>
                            <button type="button" id="btn-brand-add" class="btn btn-success">
                                <i class="fa fa-plus-circle"></i> Thêm
                            </button>
                        </div>
                        <label id="brand_id-error" class="error col-sm-offset-2" for="brand_id"
                               style="padding-left: 15px;"></label>
                    </div>

                    <div class="form-group">
                        <label for="pro_quantity" class="col-sm-2 control-label">Tồn kho</label>

                        <div class="col-sm-6">
                            <input type="text" class="form-control"
                                   id="pro_quantity" name="pro_quantity"
                                   placeholder="Số lượng ri trong kho"
                                   value="<?php echo $this->product['pro_quantity']; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Thông tin thêm</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="pro_seo_title" class="col-sm-2 control-label">SEO Title</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="pro_seo_title" name="pro_seo_title"
                                   placeholder="SEO Title" value="<?php echo $this->product['pro_seo_title']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pro_seo_description" class="col-sm-2 control-label">SEO Description</label>

                        <div class="col-sm-10">
                                    <textarea class="form-control" name="pro_seo_description" id="pro_seo_description"
                                              rows="3"><?php echo $this->product['pro_seo_description']; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="products_right" class="col-md-3 no-padding">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="radio">
                        <label>
                            <input type="radio" name="pro_status" id="pro_status"
                                   value="1"<?php if ($this->product['pro_status'] == 1) echo " checked" ?>>Hiển thị
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="pro_status" id="pro_status"
                                   value="0"<?php if ($this->product['pro_status'] == 0) echo " checked" ?>> Ẩn sản phẩm
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="pro_status" id="pro_status"
                                   value="<?php echo \models\Products::STATUS_TRASH; ?>"<?php if ($this->product['pro_status'] == \models\Products::STATUS_TRASH) echo " checked" ?>>
                            Trash
                        </label>
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="products_id" id="products_id"
                               value="<?php echo $this->product['pro_id']; ?>">
                        <button type="submit" name="btn-products-edit" class="btn btn-success">Lưu sản phẩm</button>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Danh mục sản phẩm</div>
                <div class="panel-body" style="overflow-y: scroll; overflow-x: hidden; height: 250px;">
                    <table id="news_type" class="table table-hover">
                        <tbody>
                        <?php echo getProductsType($this->prots, "", $this->prot_id); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="image-featured" class="panel panel-default"></div>
        </div>
    </form>
    <!--#end form-->

    <!--Modal products_image-->
    <div id="modal-products-image" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Quản lý hình ảnh</h4>
                </div>
                <div class="modal-body">
                    <div class="products_image"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!--END Modal products_image-->

    <div id="modal-update-success" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog"
         aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" style="padding-top: 20px; padding-bottom: 20px; text-align: center;">
                <i class="fa fa-check-circle fa-5x" style="color: #5cb85c;"></i> <span
                    style="font-size: 48px; color: rgba(0,0,0,0.35);">Saved</span>
            </div>
        </div>
    </div>

<?php include '/templates/admin/page_footer.php'; ?>
<?php include '/templates/admin/template_script.php'; ?>

    <!-- Load javascript use on this page -->
    <script src="/templates/admin/js/plugins/validation/jquery.validate.min.js"></script>
    <script src="/templates/admin/js/summernote.min.js"></script>
    <script src="/templates/js/moment.js"></script>
    <script src="/templates/js/select2.min.js"></script>
    <script src="/templates/js/bootstrap-datetimepicker.min.js"></script>

    <script src="/templates/admin/js/script.js"></script>
    <script src="/templates/admin/js/pages/products.js"></script>
    <script>$(function () {
            readyProductsEdit.init()
        })</script>
<?php include '/templates/admin/template_end.php'; ?>