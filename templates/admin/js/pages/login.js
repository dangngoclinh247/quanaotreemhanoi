/**
 * Created by Liam Dang on 10/5/2015.
 */

var readyLogin = function() {
    return {
        init: function() {
            $("#form-login").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    }
                },
                messages: {
                    email: {
                        required: "Vui lòng nhập email",
                        email: "Email không đúng"
                    },
                    password: {
                        required: "Vui lòng nhập password"
                    }
                },
                submitHandler: function() {
                    $.ajax({
                        url: "/admin.php?c=login&m=process",
                        async: false,
                        type: "post",
                        data: {
                            email: $("#email").val(),
                            pass: $("#password").val(),
                            remember: $("#remember").prop("checked")
                        },
                        success: function (result) {
                            if (result == "1") {
                                alert("dang nhap thanh chong")

                            } else {
                                alert("loi " + result);
                            }
                        },
                        error: function (e) {
                            alert(e);
                        }
                    });
                }
            });
        }
    }
}();
