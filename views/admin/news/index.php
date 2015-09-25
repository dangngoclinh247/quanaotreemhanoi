<?php include '/templates/admin/template_start.php'; ?>
<?php include '/templates/admin/page_head.php'; ?>
<?php
    $ntypes = \library\Func::sortNType($this->ntypes);
?>
    <div id="page-content">
        <div class="row">
            <div class="col-md-5">
                <div id="add-ntype-message" class="messages">
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Thêm category</h3>
                    </div>
                    <div class="panel-body">
                        <form id="form-add-ntype" action="" method="post">
                            <div class="form-group">
                                <label for="input-name">Tên Category (<span
                                        style="color: red; font-weight: bold;">*</span>)</label>
                                <input type="ntype_name" class="form-control" name="ntype_name" id="ntype_name"
                                       placeholder="Tên category">
                            </div>
                            <div class="form-group">
                                <label for="input-slug">Slug</label>
                                <input type="text" class="form-control" name="ntype_slug" id="ntype_slug"
                                       placeholder="Slug">
                            </div>
                            <div class="form-group">
                                <label for="input-slug">Parent Category</label>
                                <select id="ntype_parent_id" class="form-control">
                                    <option value="">None</option>
                                    <?php echo \library\Func::getStringOptionNType($ntypes); ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="input-seo-title">SEO Title</label>
                                <input type="text" class="form-control" id="ntype_seo_title" name="ntype_seo_title"
                                       placeholder="SEO Title">
                            </div>
                            <div class="form-group">
                                <label for="input-seo-description">SEO Description</label>
                                <textarea class="form-control" id="ntype_seo_description" name="ntype_seo_description"
                                          placeholder="SEO Description" rows="4"></textarea>
                            </div>
                            <div id="btn-group" class="form-group">
                                <button id="btn-add-ntype" type="submit" class="btn btn-default">Thêm Category</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div id="panel-ntype-list" class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Danh sách category Tin tức</h3>
                    </div>
                    <div class="panel-body">
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include '/templates/admin/page_footer.php'; ?>
<?php include '/templates/admin/template_script.php'; ?>

    <!-- Load javascript use on this page -->
    <script src="/templates/admin/js/plugins/validation/jquery.validate.min.js"></script>
    <script src="/templates/admin/js/pages/news.js"></script>
    <script src="/templates/admin/js/script.js"></script>
    <script>$(function () {
            readyNews.init();
        })</script>


<?php include '/templates/admin/template_end.php'; ?>