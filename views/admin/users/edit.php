<?php include '/templates/admin/template_start.php'; ?>
<?php include '/templates/admin/page_head.php'; ?>

    <div id="page-content">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Chỉnh sửa thông tin người dùng</h3>
                </div>
                <div class="panel-body">
                    <div id="message">&nbsp;</div>
                    <!--form add users-->
                    <form id="edit-user" class="form-horizontal"
                          action="" method="post">
                        <div class="form-group">
                            <label for="input-name" class="col-sm-3 control-label">Tên</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="user_name" name="user_name"
                                       placeholder="Name" value="<?php echo $this->user['user_name'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-email" class="col-sm-3 control-label">Email</label>

                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="user_email" name="user_email"
                                       placeholder="Email" value="<?php echo $this->user['user_email'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Mật khẩu</label>

                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="user_pass" name="user_pass"
                                       placeholder="Nhập password nếu muốn đổi">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-roles" class="col-sm-3 control-label">Quyền</label>

                            <div class="col-sm-9">
                                <select name="roles_id" id="roles_id" class="form-control">
                                    <?php
                                    foreach($this->roles as $role)
                                    {
                                        if($role['roles_id'] == $this->user['roles_id']) {
                                            echo '<option value="' . $role['roles_id'] . '" selected="selected">' . $role['roles_name'] . '</option>';
                                        } else {
                                            echo '<option value="' . $role['roles_id'] . '">' . $role['roles_name'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default">Update</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </div>
                        </div>
                    </form>
                    <!--#end form-->
                </div>
            </div>
        </div>
    </div>

<?php include '/templates/admin/page_footer.php'; ?>
<?php include '/templates/admin/template_script.php'; ?>

    <!-- Load javascript use on this page -->
    <script src="/templates/admin/js/plugins/validation/jquery.validate.min.js"></script>
    <script src="/templates/admin/js/pages/users.js"></script>
    <script>$(function () {
            readyUser.init();
        })</script>


<?php include '/templates/admin/template_end.php'; ?>