<?php include '/templates/admin/template_start.php'; ?>
<?php include '/templates/admin/page_head.php'; ?>
    <div id="page-content">
        <div class="row">
            <div id="ntype-wrapper" class="col-md-5">
                <div class="ntype-command">
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
    <script src="/templates/admin/js/summernote.min.js"></script>
    <script src="/templates/admin/js/pages/news.js"></script>
    <script src="/templates/admin/js/script.js"></script>
    <script>$(function () {
            readyNews.init();
        })</script>


<?php include '/templates/admin/template_end.php'; ?>