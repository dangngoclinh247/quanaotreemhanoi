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
    <div id="page-content">
        <form id="add-user" class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <div class="col-md-9">

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
                                       placeholder="Tiêu đề tin tức">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"
                                      id="basic-addon1">http://quanaotreemhanoi.com/tin-tuc/</span>
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
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="pro_seo_title" class="col-sm-2 control-label">Mã sản phẩm: </label>

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
                            </div>

                            <div class="form-group">
                                <label for="pro_seo_title" class="col-sm-2 control-label">Thông tin Size: </label>

                                <div class="col-sm-6 input-group" style="padding-left: 15px;">
                                    <input type="text" class="form-control"
                                           id="pro_size_info" name="pro_size_info"
                                           placeholder="Size Info">
                                    <span class="input-group-addon">Tuổi</span>
                                </div>
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
                            </div>

                            <div class="form-group form-inline">
                                <div class="col-md-2"><label for="pro_seo_title" class="control-label">
                                        Thương hiệu: </label></div>

                                <div class="col-md-10 form-inline">
                                    <input type="text" class="form-control"
                                           id="pro_seo_title" name="pro_seo_title"
                                           placeholder="Thương hiệu">
                                    <button class="btn btn-success">
                                        <i class="fa fa-plus-circle"></i> Thêm</button>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="pro_seo_description" class="col-sm-2 control-label">
                                    SEO Description</label>

                                <div class="col-sm-10">
                                    <textarea class="form-control" name="pro_seo_description" id="news_seo_description"
                                              rows="3"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Thông tin thêm</div>
                    <div class="panel-body">
                        <form class="form-horizontal">
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
                        </form>
                    </div>
                </div>
            </div>
            <div id="news_add_right" class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="radio">
                            <label>
                                <input type="radio" name="news_status" class="pro_status" value="1">Hiển thị
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="news_status" class="pro_status" value="0" checked> Ẩn sản phẩm
                            </label>
                        </div>

                        <div class="form-group">
                            <button id="savebutton" type="submit" class="btn btn-success has-spinner" data-color="green" data-style="expand-right">
                                <span class="spinner"><i class="fa fa-spinner fa-pulse"></i></span>
                                Thêm sản phẩm
                            </button>
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
            </div>
        </form>
        <!--#end form-->
    </div>

<?php include '/templates/admin/page_footer.php'; ?>
<?php include '/templates/admin/template_script.php'; ?>

    <!-- Load javascript use on this page -->
    <script src="/templates/admin/js/plugins/validation/jquery.validate.min.js"></script>
    <script src="/templates/admin/js/summernote.min.js"></script>
    <script src="/templates/js/moment.js"></script>
    <script src="/templates/js/bootstrap-datetimepicker.min.js"></script>

    <script src="/templates/admin/js/script.js"></script>
    <script src="/templates/admin/js/pages/products.js"></script>
    <script>$(function () {
            readyProductsAdd.init();
        })</script>
<?php include '/templates/admin/template_end.php'; ?>