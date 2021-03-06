<?php include '/templates/admin/template_start.php'; ?>
<?php include '/templates/admin/page_head.php'; ?>
    <div id="brand-update-wrapper" class="col-md-5 no-padding-left">
        <!--form add / edit-->
        <div class="tag-command">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Update Thương Hiệu</h3>
                </div>
                <div class="panel-body">
                    <form id="form-update-brand" action="/admin.php?c=brand" method="post">
                        <div class="form-group">
                            <label for="input-name">Tên Thương hiệu (<span
                                    style="color: red; font-weight: bold;">*</span>)</label>
                            <input type="text" class="form-control" name="brand_name" id="brand_name"
                                   placeholder="Tên products tag" value="<?php echo $this->brand['brand_name']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="input-slug">Slug</label>
                            <input type="text" class="form-control" name="brand_slug" id="brand_slug"
                                   placeholder="Slug" value="<?php echo $this->brand['brand_slug']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="input-content">Nội dung</label>
                            <textarea id="brand_content" name="brand_content"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="input-seo-title">SEO Title</label>
                            <input type="text" class="form-control" id="brand_seo_title" name="brand_seo_title"
                                   placeholder="SEO Title" value="<?php echo $this->brand['brand_seo_title']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="input-seo-description">SEO Description</label>
                <textarea class="form-control" id="brand_seo_description" name="brand_seo_description"
                          placeholder="SEO Description"
                          rows="4"><?php echo $this->brand['brand_seo_description']; ?></textarea>
                        </div>
                        <div id="btn-group" class="form-group">
                            <input type="hidden" id="brand_id" name="brand_id"
                                   value="<?php echo $this->brand['brand_id']; ?>">
                            <button id="btn-update-brand" name="btn-update-brand" type="submit" class="btn btn-default">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--END form add / edit-->
    </div>
    <div class="col-md-7 no-padding">
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
<?php include '/templates/admin/page_footer.php'; ?>
<?php include '/templates/admin/template_script.php'; ?>

    <!-- Load javascript use on this page -->
    <script src="/templates/admin/js/plugins/validation/jquery.validate.min.js"></script>
    <script src="/templates/admin/js/summernote.min.js"></script>
    <script src="/templates/admin/js/pages/brand.js"></script>
    <script src="/templates/admin/js/script.js"></script>
    <script>$(function () {
            readyBrandEdit.init();
        })</script>


<?php include '/templates/admin/template_end.php'; ?>