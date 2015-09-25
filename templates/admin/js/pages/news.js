/**
 * Created by Liam Dang on 9/25/2015.
 */
var readyNews = function () {
    return {
        init: function () {

            autoLoadNTypeList();

            $("#form-add-ntype").validate({
                rules: {
                    ntype_name: {
                        required: true
                    }
                },
                messages: {
                    ntype_name: {
                        required: "Vui lòng nhập Tên Category"
                    }
                },
                submitHandler: function () {
                    $.ajax({
                        url: $(location).attr("href"),
                        type: "post",
                        dataType: "json",
                        data: {
                            ntype_add: "ok",
                            ntype_name: $("#ntype_name").val(),
                            ntype_slug: $("#ntype_slug").val(),
                            ntype_seo_title: $("#ntype_seo_title").val(),
                            ntype_seo_description: $("#ntype_seo_description").val(),
                            ntype_parent_id: $("#ntype_parent_id").val()
                        },
                        success: function (result) {
                            if (result.status == "1") {
                                $("#add-ntype-message").html(result.message);
                                $("#add-ntype-message").show();
                                $("#form-add-ntype").trigger("reset");
                                autoLoadNTypeList();
                            }
                            else {
                                alert("Error: " + result.mesage);
                            }
                        },
                        error: function (e) {
                            alert(e.responseText);
                        }
                    });
                    return false;
                }
            });

            $("#ntype_name").on("input", function () {
                var strSlug = to_slug($("#ntype_name").val());
                //alert(strSlug);
                $("#ntype_slug").val(strSlug);
            })

            // show mini menu when hover td
            $(document).on({
                mouseenter: function () {
                    $(this).children(".minimenu").fadeIn(200);
                }
                ,
                mouseleave: function () {
                    $(this).children(".minimenu").fadeOut(200);
                }
            }, "#ntype-list td");

            // checked all
            $("#ntype-checkbox-all").on("change", function () {
                var statusCheckbox = $(this).prop("checked");
                var currentTable = $(this).closest("table");
                $("input:checkbox").prop(statusCheckbox);
            });
        }
    }
}();

function autoLoadNTypeList() {
    // get ntype list
    $.ajax({
        url: "/admin.php?c=news&m=ntype_list",
        type: "post",
        success: function (result) {
            $("#panel-ntype-list .panel-body").html(result);
        },
        error: function (e) {
            alert("Khong the lay danh sach news type " + e.responseText)
        }
    });
}

function ntype_delete(id)
{
    $.ajax({
        url: "/admin.php?c=news&m=ntype_del",
        type: "post",
        data: {
            ntype_delete: "ok",
            ntype_id: id
        },
        success: function (result) {
            $("#panel-ntype-list .panel-body").html(result);
        },
        error: function (e) {
            alert("Khong the lay danh sach news type " + e.responseText)
        }
    });
}