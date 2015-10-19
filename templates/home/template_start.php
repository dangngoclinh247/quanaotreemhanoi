<!DOCTYPE html>
<!--[if lt IE 7 ]>
<html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>
<html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>
<html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en"> <!--<![endif]-->

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="<?php echo $this->getMetaDescription(); ?>">
    <meta name="author" content="<?php echo $this->getPageTitle(); ?>">

    <title><?php echo $this->getPageTitle(); ?></title>

    <link rel="shortcut icon" href="/templates/home/images/favicon.ico" type="image/x-icon"/>
    <link rel="apple-touch-icon" href="/templates/home/images/apple-touch-icon.png"/>
    <link rel="apple-touch-icon" sizes="72x72" href="/templates/home/images/apple-touch-icon-72x72.png"/>
    <link rel="apple-touch-icon" sizes="114x114" href="/templates/home/images/apple-touch-icon-114x114.png"/>

    <!-- Bootstrap core CSS -->
    <link href="/templates/home/css/bootstrap.css" rel="stylesheet">
    <link href="/templates/home/css/font-awesome.css" rel="stylesheet">
    <link href="/templates/home/css/raterater.css" rel="stylesheet">
    <link href="/templates/home/css/menu.css" rel="stylesheet">
    <link href="/templates/home/css/carousel.css" rel="stylesheet">
    <link href="/templates/home/style.css" rel="stylesheet">

    <style>
        /* Override star colors */
        .raterater-bg-layer {
            color: rgba(255, 255, 255, 255);
        }

        .raterater-hover-layer {
            color: #eabe12;
            /*color: rgba( 255, 255, 0, 0.75 );*/
        }

        .raterater-hover-layer.rated {
            color: #eabe12;
            /*color: rgba( 255, 255, 0, 1 );*/
        }

        .raterater-rating-layer {
            color: #eabe12;
            /*color: rgba( 255, 155, 0, 0.75 );*/
        }

        .raterater-outline-layer {
            color: #eabe12;
            /*color: rgba( 255, 255, 255, 255 );*/
            /*color: rgba( 0, 0, 0, 0.25 );*/
        }
    </style>

    <!-- Custom CSS -->
    <link href="/templates/home/css/custom.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<!--<div id="loader">
    <div class="loader-container">
        <img src="images/loader.gif" alt="" class="loader-site">
    </div>
</div>-->
<div id="modal-thanks-rating" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Thanks</h4>
            </div>
            <div class="modal-body">
                <i class="fa fa-check fa-2x" style="color: #5cb85c;"></i> Thanks for Rating
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- /modal-thanks-rating -->

<div id="modal-add-to-cart-success" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Thanks</h4>
            </div>
            <div class="modal-body">
                <i class="fa fa-check fa-2x" style="color: #5cb85c;"></i> Sản phẩm đã được thêm vào Giỏ Hàng
            </div>
            <div class="modal-footer">
                <a href="<?php echo $this->url->getUrlPage("gio-hang");?>" class="btn btn-success">Tới Giỏ Hàng</a>
                <a href="#" class="btn btn-success" data-dismiss="modal">Đóng</a>
            </div>
        </div>
    </div>
</div>
<!-- /modal-thanks-rating -->
<?php if (!isset($_SESSION['user_id']))
{
?>
<div id="modal-login" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Đăng Nhập</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class="form-horizontal col-md-8">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label no-padding">Email</label>

                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label no-padding">Mật khẩu</label>

                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="password" name="password"
                                       placeholder="mật khẩu">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="remember" name="remember"> Tự động đăng nhập
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-success">Đăng nhập</button>
                            </div>
                        </div>
                    </form>
                    <div class="col-md-4">
                        <p>Nếu bạn chưa có tài khoản, click <a class="btn-register" href="#" data-dismiss="modal">Đăng
                                ký</a></p>
                        <a class="btn btn-success btn-sm btn-block" href=""><i class="fa fa-facebook fa-lg"></i>
                            Facebook</a> <br>
                        <a class="btn btn-success btn-sm btn-block" href=""><i class="fa fa-google fa-lg"></i>
                            Google</a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div id="modal-register" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Đăng Nhập</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form id="form-register" class="form-horizontal col-md-8" action="" method="post">
                        <div class="form-group">
                            <label for="user_email" class="col-sm-3 control-label no-padding">Email</label>

                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="user_email" name="user_email" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_pass" class="col-sm-3 control-label no-padding">Mật khẩu</label>

                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="user_pass" name="user_pass"
                                       placeholder="mật khẩu">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_name" class="col-sm-3 control-label no-padding">Họ & Tên</label>

                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="user_name" name="user_name"
                                       placeholder="Họ và tên">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_phone" class="col-sm-3 control-label no-padding">Phone</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="user_phone1" name="user_phone1"
                                       placeholder="số điện thoại">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_address" class="col-sm-3 control-label no-padding">Địa chỉ</label>

                            <div class="col-sm-9">
                                <textarea class="form-control" id="user_address" name="user_address"
                                       placeholder="địa chỉ" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-success">Đăng nhập</button>
                            </div>
                        </div>
                    </form>
                    <div class="col-md-4">
                        <p>Nếu bạn chưa có tài khoản, click <a class="btn-register" href="#" data-dismiss="modal">Đăng
                                ký</a></p>
                        <a class="btn btn-success btn-sm btn-block" href=""><i class="fa fa-facebook fa-lg"></i>
                            Facebook</a> <br>
                        <a class="btn btn-success btn-sm btn-block" href=""><i class="fa fa-google fa-lg"></i>
                            Google</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php } ?>