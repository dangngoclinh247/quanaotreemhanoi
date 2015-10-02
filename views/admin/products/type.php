<?php include '/templates/admin/template_start.php'; ?>
<?php include '/templates/admin/page_head.php'; ?>
    <div id="page-content">
        <div class="row">
            <div id="products-type-wrapper" class="col-md-5">
                <!--form add / edit-->
                <div class="type-command">
                </div>
                <!--END form add / edit-->
            </div>
            <div class="col-md-7 padding-0">
                <!--prot list-->
                <div id="panel-prot-list"></div>
                <!--END prot list-->
            </div>
        </div>
    </div>
<?php include '/templates/admin/page_footer.php'; ?>
<?php include '/templates/admin/template_script.php'; ?>

    <!-- Load javascript use on this page -->
    <script src="/templates/admin/js/plugins/validation/jquery.validate.min.js"></script>
    <script src="/templates/admin/js/summernote.min.js"></script>
    <script src="/templates/admin/js/script.js"></script>
    <script src="/templates/admin/js/pages/products_type.js"></script>
    <script>$(function () {readyProductsType.init();})</script>
<?php include '/templates/admin/template_end.php'; ?>