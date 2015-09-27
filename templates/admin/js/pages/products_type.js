/**
 * Created by Liam Dang on 9/27/2015.
 */
var readyProductsTag = function () {
    return {
        init: function () {

            // Load tag_add and tag_list
            load_ptag_add();
            load_ptag_list();

            // show mini menu when hover td
            $(document).on({
                mouseenter: function () {
                    $(this).find(".minimenu").fadeIn(200);
                }
                ,
                mouseleave: function () {
                    $(this).find(".minimenu").hide();
                }
            }, "#ptag-list tr");

            $(document).on("click", "#btn-add-ptag", function() {
                $(".messages").hide();
            });

            // init check all
            $(document).on("change", "#ptag-checkbox-all", function() {
                var changeStatus = $(this).prop("checked");
                $(".ptag-check").each(function() {
                    $(this).prop("checked", changeStatus);
                });
            });

            // unchecked all if any checkbox uncheck
            $(document).on("change", ".ptag-check", function() {
                $("#ptag-checkbox-all").prop("checked", false);
            });

            $(document).on("validate", "#form-update-ptag", {
                rules: {
                    ptag_name: {
                        required: true
                    }
                },
                messages: {
                    ptag_name: {
                        required: "Vui lòng nhập Tên Product Tag"
                    }
                },
                submitHandler: function() {
                    alert("lamdang");
                }
            })

            //remove all class bg-color-3 when click edit
            $(document).on("click", ".btn_ptag_edit", function() {
                $("table tr").removeClass("bg-color-3");
            });

            $(document).on("click", "#load-form-add", function() {
                load_ptag_add();
            });

            $(document).on("input", "#form-add-ptag #ptag_name", function(e) {
                var slug = to_slug($(this).val());
                var slug_current =  $("#ptag_slug").val();
                if(slug_current == "" ||
                    ((slug.length - slug_current.length) <=2
                    && (slug.length - slug_current.length) > -2))
                    $("#ptag_slug").val(slug);
            })
        }
    }
}();

// Load form ptag add
function load_ptag_add() {
    $.ajax({
        url: "/admin.php?c=products&m=tag_add",
        async: false,
        success: function (result) {
            $("#products-tag-wrapper .tag-command").html(result);
            init_textarea();
            load_ptag_add_validate();
        },
        error: function (e) {
            alert("Khong the lay danh sach news type " + e)
        }
    });
}

// load check validate for form ptag add
function load_ptag_add_validate() {
    $("#form-add-ptag").validate({
        rules: {
            ptag_name: {
                required: true
            }
        },
        messages: {
            ptag_name: {
                required: "Vui lòng nhập Tên Product Tag"
            }
        },
        submitHandler: function () {
            $.ajax({
                url: "admin.php?c=products&m=tag_insert",
                type: "post",
                dataType: "json",
                data: {
                    ptag_add: "ok",
                    ptag_name: $("#ptag_name").val(),
                    ptag_slug: $("#ptag_slug").val(),
                    ptag_seo_title: $("#ptag_seo_title").val(),
                    ptag_seo_description: $("#ptag_seo_description").val(),
                    ptag_content: $("#ptag_content").code()
                },
                success: function (result) {
                    if (result.status == "1") {
                        show_message(result.message);
                        $("#form-add-ptag").trigger("reset");
                        load_ptag_list();
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
function load_ptag_edit_validate(ptag_id) {
    $("#form-update-ptag").validate({
        rules: {
            ptag_name: {
                required: true
            }
        },
        messages: {
            ptag_name: {
                required: "Vui lòng nhập Tên Product Tag"
            }
        },
        submitHandler: function () {
            $.ajax({
                url: "admin.php?c=products&m=tag_update&p=" + ptag_id,
                type: "post",
                dataType: "json",
                data: {
                    ptag_update: "ok",
                    ptag_name: $("#ptag_name").val(),
                    ptag_slug: $("#ptag_slug").val(),
                    ptag_seo_title: $("#ptag_seo_title").val(),
                    ptag_seo_description: $("#ptag_seo_description").val(),
                    ptag_content: $("#ptag_content").code()
                },
                success: function (result) {
                    if (result.status == "1") {
                        show_message(result.message);
                        $("#form-add-update").trigger("reset");
                        load_ptag_list(ptag_id);

                        //reload form
                        ptag_edit(ptag_id);
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

//parameter ptag id want to highlight
function load_ptag_list(ptag_id) {
    // get ntype list
    $.ajax({
        url: "/admin.php?c=products&m=tag_list&p=" + ptag_id,
        async: false,
        success: function (result) {
            $("#panel-ptag-list .panel-body").html(result);

            // install checkbox all
            //init_checkbox_all()
        },
        error: function (e) {
            alert("Khong the lay danh sach products tag " + e.responseText)
        }
    });
}


// setting summernote for textarea
function init_textarea() {
    $("#ptag_content").summernote({
        toolbar: [
            //[groupname, [button list]]

            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['color', ['color']]
        ]
    });
}

// install edit and delete link on ptag table
function ptag_delete(ptag_id, current_element)
{
    $.ajax({
        url: "/admin.php?c=products&m=tag_del",
        type: "post",
        data: {
            ptag_id: ptag_id
        },
        success: function (result) {
            if (result == "1") {
                trElement = $(current_element).closest("tr");

                // load ptag add if trElement == current edit
                if($(trElement).hasClass("bg-color-3"))
                {
                    load_ptag_add();
                }
                trElement.removeClass("bg-color-3").addClass("bg-color-1");
                trElement.fadeOut(1000);
            }
            else {
                alert("Lỗi");
            }
        },
        error: function (e) {
            alert("Lỗi " + e);
        }
    });
}

function ptag_edit(ptag_id, current_element)
{
    $.ajax({
        url: "/admin.php?c=products&m=tag_edit&p=" + ptag_id,
        success: function (result) {
            if (result == "0") {
                alert("Không tồn tại product tag này");
            }
            else {
                $("#products-tag-wrapper .tag-command").html(result);
                trElement = $(current_element).closest("tr");
                trElement.addClass("bg-color-3");
                init_textarea();
                load_ptag_edit_validate(ptag_id);
            }
        },
        error: function (e) {
            alert("Lỗi " + e);
        }
    });
}

function show_message(message)
{
    $("#add-ptag-message").html(message);
    $("#add-ptag-message").show();
    $("#add-ptag-message").fadeOut(3000);
}