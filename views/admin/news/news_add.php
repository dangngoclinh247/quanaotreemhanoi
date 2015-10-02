<?php include '/templates/admin/template_start.php'; ?>
<?php include '/templates/admin/page_head.php'; ?>
<?php
function getProductsType($data, $prefix = "")
{
    $result = "";
    foreach ($data as $item) {
        $result .= '<tr><td>' . $prefix . '<input class="ntype_id" type="checkbox" name="ntype_id" value="' . $item['ntype_id'] . '">&nbsp;' . $item['ntype_name'] . '</tr></td>';
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
                        <h3 class="panel-title">Thêm tin mới</h3>
                    </div>
                    <div class="panel-body">
                        <div id="message">&nbsp;</div>
                        <!--form add users-->

                        <div class="form-group">
                            <label for="input-name" class="col-sm-2 control-label">Tiêu đề</label>

                            <div class="col-sm-10 input-group">
                                <input type="text" class="form-control" id="news_name" name="news_name"
                                       placeholder="Tiêu đề tin tức">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"
                                      id="basic-addon1">http://quanaotreemhanoi.com/tin-tuc/</span>
                                <input type="text" class="form-control" id="news_slug" name="news_slug"
                                       placeholder="Url bài viết">
                                <span class="input-group-addon">.html</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="3" id="news_content" name="news_content"></textarea>
                        </div>


                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Thông tin thêm</div>
                    <div class="panel-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="news_seo_title" class="col-sm-2 control-label">SEO Title</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="news_seo_title" name="news_seo_title"
                                           placeholder="SEO Title">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="news_seo_title" class="col-sm-2 control-label">SEO Description</label>

                                <div class="col-sm-10">
                                    <textarea class="form-control" name="news_seo_description" id="news_seo_description"
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
                                <input type="radio" name="news_status" class="news_status" value="1">Xuất bản
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="news_status" class="news_status" value="2" checked>Bản nháp
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="input-name" class="control-label">Ngày hiển thị</label>

                            <div class="input-group date" id="datetimepicker">
                                <input type="text" class="form-control" id="news_publish_date" name="news_publish_date" disabled>
                                <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <button id="savebutton" type="submit" class="btn btn-success has-spinner" data-color="green" data-style="expand-right">
                                <span class="spinner"><i class="fa fa-spinner fa-pulse"></i></span>
                                Lưu
                            </button>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Tin Tức Category</div>
                    <div class="panel-body" style="overflow-y: scroll; height: 250px;">
                        <table id="news_type" class="table table-hover">
                            <tbody>
                            <?php echo getProductsType($this->ntypes); ?>
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
<script src="/templates/admin/js/pages/news.js"></script>
<script>$(function () {
        readyNewsAdd.init();
    })</script>
<?php include '/templates/admin/template_end.php'; ?>