<?php include '/templates/admin/template_start.php'; ?>
<?php include '/templates/admin/page_head.php'; ?>

    <div id="page-content">
        <!--main content-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Danh sách tin tức</h3>
            </div>
            <div class="panel-body">
                <!--Table users-->
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="col-sm-1"><input type="checkbox" id="checkbox-all"></th>
                        <th class="col-sm-6">Tiêu đề</th>
                        <th class="col-sm-2">Tác giả</th>
                        <th class="col-sm-2">Category</th>
                        <th class="col-sm-1">Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($this->news as $new) {
                        ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="select-news" class="checked-news"/>
                            </td>
                            <td class="list-news-name">
                                <a href="/admin.php?c=news&m=news_edit&p=<?php echo $new['news_id'];?>">
                                    <?php
                                    if (!isset($new['news_name']) || $new['news_name'] == null) {
                                        echo "(no title)";
                                    } else {
                                        echo $new['news_name'];
                                    }
                                    ?>
                                </a>
                                <p class="minimenu">
                                    <a href="">Edit</a> |
                                    <a href="">Delete</a> |
                                    <a href="">Hidden</a>
                                </p>
                            </td>
                            <td>
                                <a href="/admin.php?c=user&m=edit&p=<?php echo $new['user_id'];?>">

                                </a>
                                <?php
                                if (isset($new['user_name']) && $new['user_name'] != null) {
                                    echo $new['user_name'];
                                } else {
                                    echo "Khong co";
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if (isset($new['type'])) {
                                    foreach ($new['type'] as $key => $type) {
                                        if ($key > 0) {
                                            echo ", ";
                                        }
                                        ?><a href="/admin.php?c=ntype&m=edit&p=<?php echo $new['ntype_id'];?>"><?php echo $type['ntype_name'];?></a><?php
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <?php echo $new['news_update_date']; ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
                <!--End Table Users-->
            </div>
        </div>
        <!--END main content-->

        <!--Modal delete user-->
        <div id="modal-delete-user" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Xóa Người Dùng</h4>
                    </div>
                    <div class="modal-body">
                        <p>One fine body&hellip;</p>
                    </div>
                    <div class="modal-footer">
                        <button id="btnNoDelete" type="button" class="btn btn-default" data-dismiss="modal">Không
                        </button>
                        <button id="btnDeleteConfirm" type="button" class="btn btn-primary">Xác nhận, Xóa</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <!--END Modal delete user-->

        <!--Modal delete user success-->
        <div id="modal-delete-user-success" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Xóa Người Dùng</h4>
                    </div>
                    <div class="modal-body">
                        <p>Người dùng <strong></strong> đã được xóa</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <!--END Modal delete user success-->
    </div>

<?php include '/templates/admin/page_footer.php'; ?>
<?php include '/templates/admin/template_script.php'; ?>

    <!-- Load javascript use on this page -->
    <script src="/templates/admin/js/plugins/validation/jquery.validate.min.js"></script>
    <script src="/templates/admin/js/script.js"></script>
    <script src="/templates/admin/js/pages/news.js"></script>
    <script>$(function () {
            readyNews.init();
        })</script>


<?php include '/templates/admin/template_end.php'; ?>