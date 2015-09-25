/**
 * Created by Liam Dang on 9/23/2015.
 */
var readyUser = function () {
    return {
        init: function () {
            $('form').on("submit", function () {
                $("#message").hide();
            });
            $("#add-user").validate({
                rules: {
                    user_name: {
                        required: true,
                        minlength: 3
                    },
                    user_email: {
                        required: true,
                        email: true
                    },
                    user_pass: {
                        required: true,
                        minlength: 6
                    }
                },
                messages: {
                    user_name: {
                        required: "Vui lòng nhập Tên",
                        minlength: "Tên ít nhất 3 ký tự"
                    },
                    user_email: {
                        required: "Vui lòng nhập email",
                        email: "Email không đúng định dạng"
                    },
                    user_pass: {
                        required: "Vui lòng nhập mật khẩu",
                        minlength: "Mật khẩu tối thiểu 6 ký tự"
                    }
                },
                submitHandler: function () {
                    $.ajax({
                        url: $("#add-user").attr("action"),
                        type: "post",
                        dataType: "json",
                        data: {
                            user_name: $("#user_name").val(),
                            user_email: $("#user_email").val(),
                            user_pass: $("#user_pass").val(),
                            roles_id: $("#roles_id").val(),
                            add: "ok"
                        },
                        success: function (result) {
                            if (result.status == "1") {
                                $("#message").html(result.message);
                                $("#message").show();
                                $("#add-user").trigger("reset");
                            }
                        },
                        error: function (e) {
                            alert(e.responseText);
                        }
                    });
                    return false;
                }
            });
            $("#edit-user").validate({
                rules: {
                    user_name: {
                        required: true,
                        minlength: 3
                    },
                    user_email: {
                        required: true,
                        email: true
                    },
                    user_pass: {
                        minlength: 6
                    }
                },
                messages: {
                    user_name: {
                        required: "Vui lòng nhập Tên",
                        minlength: "Tên ít nhất 3 ký tự"
                    },
                    user_email: {
                        required: "Vui lòng nhập email",
                        email: "Email không đúng định dạng"
                    },
                    user_pass: {
                        minlength: "Mật khẩu tối thiểu 6 ký tự"
                    }
                },
                submitHandler: function () {
                    $.ajax({
                        url: $(location).attr("href"),
                        type: "post",
                        dataType: "json",
                        data: {
                            user_name: $("#user_name").val(),
                            user_email: $("#user_email").val(),
                            user_pass: $("#user_pass").val(),
                            roles_id: $("#roles_id").val(),
                            edit: "ok"
                        },
                        success: function (result) {
                            if (result.status == "1") {
                                $("#message").html(result.message);
                                $("#message").show();
                                $("#add-user").trigger("reset");
                            }
                        },
                        error: function (e) {
                            alert(e.responseText);
                        }
                    });
                    return false;
                }
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