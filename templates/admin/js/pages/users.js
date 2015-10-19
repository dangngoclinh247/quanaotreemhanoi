/**
 * Created by Liam Dang on 9/23/2015.
 */
var readyUserAdd = function () {
    return {
        init: function () {
            $('form').on("submit", function () {
                $("#message").hide();
            });

            /**
             * Init validate for #form-user-add
             */
            $("#form-users-add").validate({
                rules: {
                    user_name: {
                        required: true,
                        minlength: 3
                    },
                    user_email: {
                        required: true,
                        email: true,
                        remote: {
                            url: "/admin.php?c=users&m=ajax_check_email",
                            type: "post",
                            data: {
                                user_email: function() {
                                    return $("#user_email").val();
                                }
                            }
                        }
                    },
                    user_pass: {
                        required: true,
                        minlength: 4
                    }
                },
                messages: {
                    user_name: {
                        required: "Vui lòng nhập Tên",
                        minlength: "Tên ít nhất 3 ký tự"
                    },
                    user_email: {
                        required: "Vui lòng nhập email",
                        email: "Email không đúng định dạng",
                        remote: "Email này đã có người đăng ký"
                    },
                    user_pass: {
                        required: "Vui lòng nhập mật khẩu",
                        minlength: "Mật khẩu tối thiểu 4 ký tự"
                    }
                }
            });
        }
    }
}();

var readyUserEdit = function() {
    return {
        init: function() {
            $("#form-user-edit").validate({
                rules: {
                    user_name: {
                        required: true,
                        minlength: 3
                    },
                    user_email: {
                        required: true,
                        email: true,
                        remote: {
                            url: "/admin.php?c=users&m=ajax_check_email",
                            type: "post",
                            data: {
                                user_email: function () {
                                    return $("#user_email").val();
                                },
                                user_id: function () {
                                    return $("#user_id").val();
                                }
                            }
                        }
                    },
                    user_pass: {
                        minlength: 4
                    }
                },
                messages: {
                    user_name: {
                        required: "Vui lòng nhập Tên",
                        minlength: "Tên ít nhất 3 ký tự"
                    },
                    user_email: {
                        required: "Vui lòng nhập email",
                        email: "Email không đúng định dạng",
                        remote: "Email này đã đăng ký tài khoản khác"
                    },
                    user_pass: {
                        minlength: "Mật khẩu tối thiểu 4 ký tự"
                    }
                }
            });

            $(document).on("hidden.bs.modal", "#modal-edit-success", function() {
                window.location.reload();
            });
        }
    }
}();

function deleteUser(id) {
    // get info user
    $.ajax({
        url: $(location).attr("href"),
        type: "post",
        dataType: "json",
        data: {
            user_id: id
        },
        success: function (result) {
            var message = "<p>Bạn muốn xóa <strong>" + result.user_name + " - " + result.user_email + "</strong></p>";
            $("#modal-delete-user .modal-body").html(message);
            $("#modal-delete-user").modal("show");

            // insert user_name to modal success
            $("#modal-delete-user-success .modal-body strong").text(result.user_name);

            // when click delete confirm
            $("#btnDeleteConfirm").click(function () {
                $.ajax({
                    url: $(location).attr("href"),
                    type: "post",
                    dataType: "json",
                    data: {
                        user_id: id,
                        del: "ok"
                    },
                    success: function () {
                        // hide modal delete user
                        $("#modal-delete-user").modal("hide");

                        $("#modal-delete-user-success").modal("show");
                    },
                    error: function (e) {
                        alert(e.responseText);
                    }
                });
            });
        },
        error: function (e) {
            alert(e.responseText)
        }
    });
}

// auto load page when modal delete user success hide
$("#modal-delete-user-success").on("hide.bs.modal", function () {
    window.location.reload();
});