<?php include '/templates/admin/template_start.php'; ?>
<?php include '/templates/admin/page_head.php'; ?>
    <div id="page-content">
        <div class="row">
            <div id="products-tag-wrapper" class="col-md-5">
                <!--form add / edit-->
                <div class="tag-command">
                    <div id="add-ptag-message" class="messages">
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Thêm Thương hiệu mới</h3>
                        </div>
                        <div class="panel-body">
                            <form id="form-add-brand" action="" method="post">
                                <div class="form-group">
                                    <label for="input-name">Tên Thương hiệu (<span
                                            style="color: red; font-weight: bold;">*</span>)</label>
                                    <input type="text" class="form-control" name="brand_name" id="brand_name"
                                           placeholder="Tên products tag">
                                </div>
                                <div class="form-group">
                                    <label for="input-slug">Slug</label>
                                    <input type="text" class="form-control" name="brand_slug" id="brand_slug"
                                           placeholder="Slug">
                                </div>
                                <div class="form-group">
                                    <label for="input-content">Nội dung</label>
                                    <div id="brand_content"></div>
                                </div>
                                <div class="form-group">
                                    <label for="input-seo-title">SEO Title</label>
                                    <input type="text" class="form-control" id="brand_seo_title" name="brand_seo_title"
                                           placeholder="SEO Title">
                                </div>
                                <div class="form-group">
                                    <label for="input-seo-description">SEO Description</label>
                <textarea class="form-control" id="brand_seo_description" name="brand_seo_description"
                          placeholder="SEO Description" rows="4"></textarea>
                                </div>
                                <div id="btn-group" class="form-group">
                                    <button id="btn-add-brand" type="submit" class="btn btn-default">Thêm Tag
                                    </button>
                                    <button type="reset" class="btn btn-danger">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--END form add / edit-->
            </div>
            <div class="col-md-7">
                <div id="panel-brand-list" class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Danh sách Thương Hiệu</h3>
                    </div>
                    <!--table list-->
                    <div class="panel-body">
                    </div>
                    <!--END table list-->
                </div>
            </div>
        </div>
    </div>
<?php include '/templates/admin/page_footer.php'; ?>
<?php include '/templates/admin/template_script.php'; ?>

    <!-- Load javascript use on this page -->
    <script src="/templates/admin/js/plugins/validation/jquery.validate.min.js"></script>
    <script src="/templates/admin/js/summernote.min.js"></script>
    <script src="/templates/admin/js/pages/brand.js"></script>
    <script src="/templates/admin/js/script.js"></script>
    <script>$(function () {
            readyBrandAdd.init();
        })</script>


<?php include '/templates/admin/template_end.php'; ?>