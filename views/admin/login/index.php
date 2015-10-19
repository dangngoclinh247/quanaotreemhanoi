<?php include '/templates/admin/old.template_start.php'; ?>

    <div class="container">
        <div id="panel-login" class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Login</h3>
            </div>
            <div class="panel-body">
                <form id="form-login" action="" method="post">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Địa chỉ Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="mật khẩu">
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="remember" name="remember" type="checkbox"> Tự động đăng nhập vào lần sau
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                </form>
            </div>
        </div>
    </div> <!-- /container -->

<?php include '/templates/admin/template_script.php'; ?>

    <!-- Load javascript use on this page -->
    <script src="/templates/admin/js/plugins/validation/jquery.validate.min.js"></script>
    <script src="/templates/admin/js/script.js"></script>
    <script src="/templates/admin/js/pages/login.js"></script>
    <script>$(function () {
            readyLogin.init();
        })</script>


<?php include '/templates/admin/old.template_end.php'; ?>