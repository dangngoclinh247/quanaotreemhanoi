<?php include '/templates/admin/template_start.php'; ?>
<?php include '/templates/admin/page_head.php'; ?>
<?php
if (isset($this->message)) {
    echo $this->message->toString();
}
?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Chỉnh sửa thông tin người dùng</h3>
        </div>
        <div class="panel-body">
            <!--form add users-->
            <form id="form-user-edit" name="form_user_edit" class="form-horizontal"
                  action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="input-name" class="col-sm-2 control-label">Tên</label>

                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="user_name" name="user_name"
                               placeholder="Name" value="<?php echo $this->user['user_name']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-email" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-6">
                        <input type="email" class="form-control" id="user_email" name="user_email"
                               placeholder="Email" value="<?php echo $this->user['user_email']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Mật khẩu</label>

                    <div class="col-sm-6">
                        <input type="password" class="form-control" id="user_pass" name="user_pass"
                               placeholder="Nhập password nếu muốn đổi">
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-roles" class="col-sm-2 control-label">Quyền</label>

                    <div class="col-sm-6">
                        <select name="roles_id" id="roles_id" class="form-control">
                            <?php
                            foreach ($this->roles as $role) {
                                if ($role['roles_id'] == $this->user['roles_id']) {
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
                    <label for="user_phone1" class="col-sm-2 control-label">Điện thoại di động</label>

                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="user_phone1" name="user_phone1"
                               placeholder="Name" value="<?php echo $this->user['user_phone1']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="user_phone2" class="col-sm-2 control-label">Điện thoại bàn</label>

                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="user_phone2" name="user_phone2"
                               placeholder="Name" value="<?php echo $this->user['user_phone2']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="user_address" class="col-sm-2 control-label">Địa chỉ</label>

                    <div class="col-sm-6">
                        <textarea type="text" class="form-control" id="user_address" name="user_address"
                                  placeholder="Địa chỉ" rows="5"><?php echo $this->user['user_address']; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="user_address" class="col-sm-2 control-label">Ảnh đại diện</label>

                    <div class="col-sm-2">
                        <?php
                        if (isset($this->user['img_url'])) {
                            ?>
                            <img src="<?php echo $this->user['img_url']; ?>" alt="" class="img-rounded" style="width: 150px;"
                                 data-id="<?php echo $this->user['user_id']; ?>" data-name="user">
                            <?php
                        } else {
                            ?>
                            <img src="http://placehold.it/150x150?text=AVATAR" alt="" class="img-rounded"
                                 data-id="<?php echo $this->user['user_id']; ?>" data-name="user">
                            <?php
                        }
                        ?>
                    </div>
                    <div class="col-ms-4">
                        <input type="file" name="user_image">

                        <p class="help-block">Chọn file .jpg/.png nếu muốn đổi hình đại diện</p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="hidden" name="user_id" id="user_id" value="<?php echo $this->user['user_id']; ?>">
                        <button name="btn_user_update" type="submit" class="btn btn-success" value="<?php echo $this->user['user_id']; ?>">UPDATE
                        </button>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </div>
                </div>
            </form>
            <!--#end form-->
        </div>
    </div>

<?php include '/templates/admin/page_footer.php'; ?>
<?php include '/templates/admin/template_script.php'; ?>

    <!-- Load javascript use on this page -->
    <script src="/templates/admin/js/plugins/validation/jquery.validate.min.js"></script>
    <script src="/templates/admin/js/script.js"></script>
    <script src="/templates/admin/js/pages/users.js"></script>
    <script>$(function () {
            readyUserEdit.init();
        })</script>


<?php include '/templates/admin/template_end.php'; ?>