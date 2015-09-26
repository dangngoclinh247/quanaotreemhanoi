/**
 * Created by Liam Dang on 9/25/2015.
 */
var readyNews = function () {
    return {
        init: function () {

            load_ntype_add();
            autoLoadNTypeList();


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
                    $(this).children(".minimenu").hide();
                }
            }, "#ntype-list td");

            // checked all
            $("#panel-ntype-list").on({
                change: function () {
                    var statusCheckbox = $(this).prop("checked");
                    var currentTable = $(this).closest("table");
                    $(".ntype-check", currentTable).each(function () {
                        $(this).prop("checked", statusCheckbox);
                    });
                }
            }, "#ntype-checkbox-all");

            // unchecked checkbox all if any checkbox unchecked
            $("#panel-ntype-list").on({
                change: function () {
                    $("#ntype-checkbox-all").prop("checked", false);
                }
            }, ".ntype-check");

            // add textarea for ntype-content
            $("#ntype_content").summernote({
                toolbar: [
                    //[groupname, [button list]]

                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['color', ['color']]
                ]
            });
        }
    }
}();

function autoLoadNTypeList(ntype_id) {
    // get ntype list
    $.ajax({
        url: "/admin.php?c=news&m=ntype_list&p=" + ntype_id,
        success: function (result) {
            $("#panel-ntype-list .panel-body").html(result);
        },
        error: function (e) {
            alert("Khong the lay danh sach news type " + e.responseText)
        }
    });
}

function ntype_delete(id, current_element) {
    $.ajax({
        url: "/admin.php?c=news&m=ntype_del",
        type: "post",
        data: {
            ntype_id: id
        },
        dataType: "json",
        success: function (result) {
            if (result.status == "1") {
                trElement = $(current_element).closest("tr");
                trElement.removeClass("bg-color-3").addClass("bg-color-1");
                trElement.fadeOut(5000);
            }
            else {
                alert(status.news_type);
            }
        },
        error: function (e) {
            alert("Khong the lay danh sach news type " + e.responseText)
        }
    });
}

function ntype_edit(id, current_element) {
    trElement = $(current_element).closest("tr");
    $.ajax({
        url: "/admin.php?c=news&m=ntype_edit&p=" + id,
        success: function (result) {
            if (result == "0") {
                alert("Can't Edit")
            } else {
                // remove all tr background color
                $("table tr").each(function () {
                    $(this).removeClass("bg-color-3");
                });
                trElement.addClass("bg-color-3");
                $("#ntype-wrapper .ntype-command").fadeOut(200, function() {
                    $("#ntype-wrapper .ntype-command").html(result);
                    init_textarea();
                    load_ntype_edit_validate(id);
                });
                $("#ntype-wrapper .ntype-command").css("boder-color", "#f0b67f");
                $("#ntype-wrapper .ntype-command").fadeIn(500);
            }
        },
        error: function (e) {
            alert("Khong the lay danh sach news type " + e)
        }
    });
}

function init_textarea() {
    // add textarea for ntype-content
    $("#ntype_content").summernote({
        toolbar: [
            //[groupname, [button list]]

            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['color', ['color']]
        ]
    });
}

function load_ntype_add() {
    $.ajax({
        url: "/admin.php?c=news&m=ntype_add",
        async: false,
        success: function (result) {
            $("#ntype-wrapper .ntype-command").html(result);
            init_textarea();
            load_ntype_add_validate();
        },
        error: function (e) {
            alert("Khong the lay danh sach news type " + e)
        }
    });
}

function load_ntype_add_validate()
{
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
                url: "admin.php?c=news&m=ntype_insert",
                type: "post",
                dataType: "json",
                data: {
                    ntype_add: "ok",
                    ntype_name: $("#ntype_name").val(),
                    ntype_slug: $("#ntype_slug").val(),
                    ntype_seo_title: $("#ntype_seo_title").val(),
                    ntype_seo_description: $("#ntype_seo_description").val(),
                    ntype_parent_id: $("#ntype_parent_id").val(),
                    ntype_content: $("#ntype_content").code()
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
}

function load_ntype_edit_validate(id)
{
    $("#form-update-ntype").validate({
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
                url: "admin.php?c=news&m=ntype_update&p=" + id,
                type: "post",
                dataType: "json",
                data: {
                    ntype_name: $("#ntype_name").val(),
                    ntype_slug: $("#ntype_slug").val(),
                    ntype_seo_title: $("#ntype_seo_title").val(),
                    ntype_seo_description: $("#ntype_seo_description").val(),
                    ntype_parent_id: $("#ntype_parent_id").val(),
                    ntype_content: $("#ntype_content").code()
                },
                success: function (result) {
                    if (result.status == "1") {
                        $("#message-edit").html(result.message);
                        autoLoadNTypeList(id);
                    }
                    else {
                        alert("Du lieu nay da bi xoa truoc do");
                        load_ntype_add()
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