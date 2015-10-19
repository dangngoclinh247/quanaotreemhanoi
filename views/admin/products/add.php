<?php include '/templates/admin/template_start.php'; ?>
<?php include '/templates/admin/page_head.php'; ?>
<?php
function getProductsType($data, $prefix = "")
{
    $result = "";
    foreach ($data as $item) {
        $result .= '<tr><td>' . $prefix . '<input class="prot_id" type="checkbox" name="prot_id" value="' . $item['prot_id'] . '">&nbsp;' . $item['prot_name'] . '</tr></td>';
        if (isset($item['submenu']) && $item['submenu'] != null) {
            $result .= getProductsType($item['submenu'], $prefix . "&nbsp;&nbsp;&nbsp;&nbsp;");
        }
    }
    return $result;
}

?>
        <form id="form-products-add" class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <div class="col-md-9 no-padding-left padding-right">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Thêm sản phẩm mới</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="input-name" class="col-sm-2 control-label">Tên sản phẩm</label>

                            <div class="col-sm-10 input-group">
                                <input type="text" class="form-control" id="pro_name" name="pro_name"
                                       placeholder="Tiêu đề tin tức">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"
                                      id="basic-addon1">http://quanaotreemhanoi.com/san-pham/</span>
                                <input type="text" class="form-control" id="pro_slug" name="pro_slug"
                                       placeholder="Url bài viết">
                                <span class="input-group-addon">.html</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="3"
                                      id="pro_content" name="pro_content"></textarea>
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
                                       placeholder="mã sản phẩm">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="pro_seo_title" class="col-sm-2 control-label">Số Size / Ri: </label>

                            <div class="col-sm-6 input-group" style="padding-left: 15px;">
                                <input type="text" class="form-control"
                                       id="pro_size" name="pro_size"
                                       placeholder="Size">
                                <span class="input-group-addon">sản phẩm / ri</span>
                            </div>
                            <label id="pro_size-error" class="error col-sm-offset-2" for="pro_size"
                                   style="padding-left: 15px;"></label>
                        </div>

                        <div class="form-group">
                            <label for="pro_seo_title" class="col-sm-2 control-label">Thông tin Size: </label>

                            <div class="col-sm-6 input-group" style="padding-left: 15px;">
                                <input type="text" class="form-control"
                                       id="pro_size_info" name="pro_size_info"
                                       placeholder="Size Info">
                                <span class="input-group-addon">Tuổi</span>
                            </div>
                            <label id="pro_size_info-error" class="error col-sm-offset-2" for="pro_size_info"
                                   style="padding-left: 15px;"></label>
                        </div>

                        <div class="form-group">
                            <label for="pro_seo_title" class="col-sm-2 control-label">
                                Giá / sản phẩm: </label>

                            <div class="col-sm-6 input-group" style="padding-left: 15px;">
                                <input type="text" class="form-control"
                                       id="pro_price" name="pro_price"
                                       placeholder="Giá">
                                <span class="input-group-addon">VNĐ</span>
                            </div>
                            <label id="pro_price-error" class="error col-sm-offset-2" for="pro_price"
                                   style="padding-left: 15px;"></label>
                        </div>

                        <div class="form-group form-inline">
                            <div class="col-md-2"><label for="pro_seo_title" class="control-label">
                                    Thương hiệu: </label></div>

                            <div class="col-md-10 form-inline">
                                <select id="brand_id" class="form-control select2" name="brand_id">
                                    <option value="">Thương hiệu</option>
                                    <?php
                                    foreach ($this->brands as $brand) {
                                        ?>
                                        <option value="<?php echo $brand['brand_id'];?>"><?php echo $brand['brand_name'];?></option>
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
                            <label for="pro_seo_description" class="col-sm-2 control-label">Tồn kho</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control"
                                       id="pro_quantity" name="pro_quantity"
                                       placeholder="Số lượng ri trong kho">
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
                                       placeholder="SEO Title">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pro_seo_description" class="col-sm-2 control-label">SEO Description</label>

                            <div class="col-sm-10">
                                    <textarea class="form-control" name="pro_seo_description" id="pro_seo_description"
                                              rows="3"></textarea>
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
                                <input type="radio" name="news_status" id="pro_status" value="1">Hiển thị
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="news_status" id="pro_status" value="0" checked> Ẩn sản phẩm
                            </label>
                        </div>

                        <div class="form-group">
                            <button type="submit" name="btn-products-add" class="btn btn-success">Lưu sản phẩm</button>
                        </div>
                    </div>

                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Danh mục sản phẩm</div>
                    <div class="panel-body" style="overflow-y: scroll; overflow-x: hidden; height: 250px;">
                        <table id="news_type" class="table table-hover">
                            <tbody>
                            <?php echo getProductsType($this->prots); ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="image-featured" class="panel panel-default">
                    <div class="panel-heading">Hình đại diện</div>
                    <div class="panel-body">
                        <div class="col-md-9" style="padding-left: 0;">
                            <input type="file" name="img_featured" id="img_featured" class="form-control">
                        </div>
                        <button type="button" id="btn-image-featured-upload" class="btn btn-success col-md-3"><i
                                class="fa fa-upload"></i>&nbsp;UP
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <!--#end form-->

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
            readyProductsAdd.init()
        })</script>
<?php include '/templates/admin/template_end.php'; ?>