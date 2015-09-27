<?php include '/templates/admin/template_start.php'; ?>
<?php include '/templates/admin/page_head.php'; ?>
    <div id="page-content">
        <div class="row">
            <div id="products-tag-wrapper" class="col-md-5">
                <!--form add / edit-->
                <div class="tag-command">
                </div>
                <!--END form add / edit-->
            </div>
            <div class="col-md-7">
                <div id="panel-ptag-list" class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Danh sách product tags</h3>
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
    <script src="/templates/admin/js/pages/products_type.js"></script>
    <script src="/templates/admin/js/script.js"></script>
    <script>$(function () {
            readyProductsType.init();
        })</script>


<?php include '/templates/admin/template_end.php'; ?>