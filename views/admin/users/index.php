<?php include '/templates/admin/template_start.php'; ?>
<?php include '/templates/admin/page_head.php'; ?>

    <div id="page-content">
        <div class="row">
            <!--main content-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Danh sách người dùng</h3>
                </div>
                <div class="panel-body">
                    <!--Table users-->
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ten</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th style="width: 120px;">Edit</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($this->users as $key => $user) {
                            ?>
                            <tr>
                                <td><?php echo ++$key;?></td>
                                <td><?php echo $user['user_name'];?></td>
                                <td><?php echo $user['user_email'];?></td>
                                <td><?php echo $user['roles_name'];?></td>
                                <td>
                                    <a class="btn btn-success btn-sm" href="<?php echo \library\Func::getUrl("users", "edit", $user['user_id'])?>">
                                        <i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-danger btn-sm" href="#" onclick="deleteUser('<?php echo $user['user_id'];?>'); return false;">
                                        <i class="fa fa-trash-o"></i></a>
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
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Xóa Người Dùng</h4>
                        </div>
                        <div class="modal-body">
                            <p>One fine body&hellip;</p>
                        </div>
                        <div class="modal-footer">
                            <button id="btnNoDelete" type="button" class="btn btn-default" data-dismiss="modal">Không</button>
                            <button id="btnDeleteConfirm" type="button" class="btn btn-primary">Xác nhận, Xóa</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!--END Modal delete user-->

            <!--Modal delete user success-->
            <div id="modal-delete-user-success" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Xóa Người Dùng</h4>
                        </div>
                        <div class="modal-body">
                            <p>Người dùng <strong></strong> đã được xóa</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!--END Modal delete user success-->

        </div>
    </div>

<?php include '/templates/admin/page_footer.php'; ?>
<?php include '/templates/admin/template_script.php'; ?>

    <!-- Load javascript use on this page -->
    <script src="/templates/admin/js/plugins/validation/jquery.validate.min.js"></script>
    <script src="/templates/admin/js/script.js"></script>
    <script src="/templates/admin/js/pages/users.js"></script>
    <script>$(function () {
            readyUser.init();
        })</script>


<?php include '/templates/admin/template_end.php'; ?>