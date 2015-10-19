<?php include '/templates/admin/template_start.php'; ?>
<?php include '/templates/admin/page_head.php'; ?>

    <div id="products-tag-wrapper" class="col-md-5 no-padding-left">
        <!--form add / edit-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Update Products Tag</h3>
            </div>
            <div class="panel-body">
                <form id="form-update-ptag" action="/admin.php?c=products_tag" method="post">
                    <div class="form-group">
                        <label for="input-name">Tên Category (<span
                                style="color: red; font-weight: bold;">*</span>)</label>
                        <input type="ptag_name" class="form-control" name="ptag_name" id="ptag_name"
                               placeholder="Tên category" value="<?php echo $this->ptag['ptag_name']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="input-slug">Slug</label>
                        <input type="text" class="form-control" name="ptag_slug" id="ptag_slug"
                               placeholder="Slug" value="<?php echo $this->ptag['ptag_slug']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="input-content">Nội dung</label>

                        <textarea id="ptag_content"
                                  name="ptag_content"><?php echo $this->ptag['ptag_content']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="input-seo-title">SEO Title</label>
                        <input type="text" class="form-control" id="ptag_seo_title" name="ptag_seo_title"
                               placeholder="SEO Title" value="<?php echo $this->ptag['ptag_seo_title']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="input-seo-description">SEO Description</label>
                <textarea class="form-control" id="ptag_seo_description" name="ptag_seo_description"
                          placeholder="SEO Description"
                          rows="4"><?php echo $this->ptag['ptag_seo_description']; ?></textarea>
                    </div>
                    <div id="btn-group" class="form-group">
                        <button id="btn-ptag-edit" name="btn_ptag_edit" type="submit" class="btn btn-success">Update
                        </button>
                    </div>
                    <input type="hidden" id="ptag_id" name="ptag_id" value="<?php echo $this->ptag['ptag_id']; ?>">
                </form>
            </div>
        </div>
        <!--END form add / edit-->
    </div>
    <div class="col-md-7 no-padding">
        <div id="panel-ptag-list" class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Danh sách product tags</h3>
            </div>
            <!--table list-->
            <div class="panel-body">
                <form class="form-inline" action="/admin.php" method="get">
                    <input type="hidden" name="c" value="products_tag"/>
                    <input type="hidden" name="m" value="search"/>

                    <div class="input-group">
                        <div class="input-group-addon">Tìm Kiếm</div>
                        <input type="text" class="form-control" id="p" name="p" placeholder="Text search">
                    </div>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
            <div class="panel-body">
                <table id="ptag-list" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th><input id="ptag-checkbox-all" type='checkbox' name='ptag_select'></th>
                        <th>Tên</th>
                        <th>Slug</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($this->ptags as $ptag) {

                        ?>
                        <tr<?php if (isset($this->ptag_id_highlight) && $this->ptag_id_highlight == $ptag['ptag_id']) echo " class='bg-color-3'"; ?>>
                            <td><input class='ptag-check' type='checkbox' name='ptag_select'
                                       value='<?php echo $ptag['ptag_id']; ?>'/></td>
                            <td><?php echo $ptag['ptag_name']; ?>
                            </td>
                            <td><?php echo $ptag['ptag_slug']; ?></td>
                            <td><a class="btn btn-sm btn-success"
                                   href='/admin.php?c=products_tag&m=edit&p=<?php echo $ptag['ptag_id']; ?>'>
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-sm btn-danger" href='#'
                                   onclick='ptag_delete(<?php echo $ptag['ptag_id']; ?>, this); return false;'>
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
                <?php echo $this->pagination->getHTML(); ?>
            </div>
            <!--END table list-->
        </div>
    </div>
<?php include '/templates/admin/page_footer.php'; ?>
<?php include '/templates/admin/template_script.php'; ?>

    <!-- Load javascript use on this page -->
    <script src="/templates/admin/js/plugins/validation/jquery.validate.min.js"></script>
    <script src="/templates/admin/js/summernote.min.js"></script>
    <script src="/templates/admin/js/pages/products_tag.js"></script>
    <script src="/templates/admin/js/script.js"></script>
    <script>$(function () {
            readyProductsTagEdit.init();
        })</script>


<?php include '/templates/admin/template_end.php'; ?>