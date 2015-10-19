<?php include '/templates/admin/template_start.php'; ?>
<?php include '/templates/admin/page_head.php'; ?>
<?php
function getProductsType($data, $prefix = "", $ntypes_of_news)
{
    $result = "";
    foreach ($data as $item) {
        $checked = "";
        if (in_array($item['ntype_id'], $ntypes_of_news)) {
            $checked = " checked";
        }
        $result .= '<tr><td>' . $prefix . '<input class="ntype_id" type="checkbox" name="ntype_id" value="' . $item['ntype_id'] . '"' . $checked . '>&nbsp;' . $item['ntype_name'] . '</tr></td>';
        if (isset($item['submenu']) && $item['submenu'] != null) {
            $result .= getProductsType($item['submenu'], $prefix . "&nbsp;&nbsp;&nbsp;&nbsp;", $ntypes_of_news);
        }
    }
    return $result;
}

?>
    <form id="form-news-edit" class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        <div class="col-md-9 no-padding-left">
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
                                   placeholder="Tiêu đề tin tức" value="<?php echo $this->news['news_name']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                                <span class="input-group-addon"
                                      id="basic-addon1">http://quanaotreemhanoi.com/tin-tuc/</span>
                            <input type="text" class="form-control" id="news_slug" name="news_slug"
                                   placeholder="Url bài viết" value="<?php echo $this->news['news_slug']; ?>">
                            <span class="input-group-addon">.html</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <textarea class="form-control" rows="3" id="news_content"
                                  name="news_content"><?php echo $this->news['news_content']; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Thông tin thêm</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="news_seo_title" class="col-sm-2 control-label">SEO Title</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="news_seo_title" name="news_seo_title"
                                   placeholder="SEO Title" value="<?php echo $this->news['news_seo_title']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="news_seo_title" class="col-sm-2 control-label">SEO Description</label>

                        <div class="col-sm-10">
                                    <textarea class="form-control" name="news_seo_description" id="news_seo_description"
                                              rows="3"
                                              placeholder="SEO Description"><?php echo $this->news['news_seo_description']; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="news_add_right" class="col-md-3 no-padding">
            <div class="panel panel-default">
                <div class="panel-body">

                    <div class="radio">
                        <label>
                            <input type="radio" name="status" class="status"
                                   value="1"<?php if ($this->news['status'] == 1) echo " checked" ?>>Xuất bản
                        </label>
                    </div>

                    <div class="radio">
                        <label>
                            <input type="radio" name="status" class="status"
                                   value="2"<?php if ($this->news['status'] == 2) echo " checked" ?>>Bản nháp
                        </label>
                    </div>

                    <div class="radio">
                        <label>
                            <input type="radio" name="status" class="status"
                                   value="3"<?php if ($this->news['status'] == 3) echo " checked" ?>>Trash
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="input-name" class="control-label">Ngày hiển thị</label>

                        <div class="input-group date" id="datetimepicker">
                            <input type="text" class="form-control" id="news_publish_date"
                                   name="news_publish_date"<?php if ($this->news['status'] != 1) echo " disabled" ?>
                                   value="<?php if (isset($this->news['news_publish_date']) && $this->news['news_publish_date'] != "") {
                                       $datetime = DateTime::createFromFormat("Y-m-d H:i:s", $this->news['news_publish_date']);
                                       echo $datetime->format("m/d/Y H:i A");
                                   }
                                   ?>">
                            <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <button id="savebutton" type="submit" class="btn btn-success has-spinner" data-color="green"
                                data-style="expand-right">
                            <span class="spinner"><i class="fa fa-spinner fa-pulse"></i> Lưu</span>
                        </button>
                        <input type="hidden" id="news_id" value="<?php echo $this->news['news_id']; ?>">
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Tin Tức Category</div>
                <div class="panel-body" style="overflow-y: scroll; height: 250px;">
                    <table id="news_type" class="table table-hover">
                        <tbody>
                        <?php
                        /*                            if(!isset($this->ntypes_of_news) || $this->ntypes_of_news == null)
                                                    {
                                                        $this->ntypes_of_news = array();
                                                    }*/
                        echo getProductsType($this->ntypes, "", $this->ntypes_of_news);
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="image-featured" class="panel panel-default">
                <div class="panel-heading">Hình đại diện</div>
                <?php
                if (isset($this->image)) {
                    ?>
                    <div class="panel-body">
                        <img class="col-md-12" src="<?php echo $this->image['img_url']; ?>"/>
                    </div>
                <?php } ?>
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
    <!--Modal news_image_panel-->
    <div id="modal-news-images" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Quản lý hình ảnh</h4>
                </div>
                <div class="modal-body">
                    <div class="news_image_panel"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!--END Modal news_image_panel-->

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
    <script src="/templates/js/bootstrap-datetimepicker.min.js"></script>

    <script src="/templates/admin/js/script.js"></script>
    <script src="/templates/admin/js/pages/news.js"></script>
    <script>$(function () {
            readyNewsEdit.init();
        })</script>
<?php include '/templates/admin/old.template_end.php'; ?>