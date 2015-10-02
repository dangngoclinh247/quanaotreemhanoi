/**
 * Created by Liam Dang on 9/27/2015.
 */
var readyProductsType = function () {
    return {
        init: function () {

            // Load type add form
            load_type_add();
            load_prot_list();

            $(document).on("input", "#form-add-type #prot_name", function(e) {
                var slug = to_slug($(this).val());
                $("#prot_slug").val(slug);
            });

            // show mini menu when hover td
            $(document).on({
                mouseenter: function () {
                    $(this).find(".minimenu").fadeIn(200);
                }
                ,
                mouseleave: function () {
                    $(this).find(".minimenu").hide();
                }
            }, "#prot-list tr");

            // end message when click add
            $(document).on("click", "#btn-add-type", function() {
                $(".messages").hide();
            });

            // init check all
            $(document).on("change", "#prot-checkbox-all", function() {
                var changeStatus = $(this).prop("checked");
                $(".prot-check").each(function() {
                    $(this).prop("checked", changeStatus);
                });
            });

            // unchecked all if any checkbox uncheck
            $(document).on("change", ".prot-check", function() {
                $("#prot-checkbox-all").prop("checked", false);
            });

            //remove all class bg-color-3 when click edit
            $(document).on("click", ".btn_prot_edit", function() {
                $("table tr").removeClass("bg-color-3");
            });

            $(document).on("click", "#load-form-add", function() {
                load_type_add();
            });

            $(document).on("click", ".btn_ptag_edit", function() {
                $("tr").removeClass("bg-color-3");
            });
        }
    }
}();

// Load form prot add
function load_type_add() {
    $.ajax({
        url: "/admin.php?c=products&m=type_add",
        async: false,
        success: function (result) {
            $("#products-type-wrapper .type-command").html(result);
            init_textarea();
            load_type_add_validate();
        },
        error: function (e) {
            alert("Khong the lay danh sach news type " + e)
        }
    });
}

// load check validate for form prot add
function load_type_add_validate() {
    $("#form-add-type").validate({
        rules: {
            prot_name: {
                required: true
            }
        },
        messages: {
            prot_name: {
                required: "Vui lòng nhập Tên Product Tag"
            }
        },
        submitHandler: function () {
            $.ajax({
                url: "admin.php?c=products&m=type_insert",
                type: "post",
                dataType: "json",
                data: {
                    prot_name: $("#prot_name").val(),
                    prot_slug: $("#prot_slug").val(),
                    prot_seo_title: $("#prot_seo_title").val(),
                    prot_seo_description: $("#prot_seo_description").val(),
                    prot_content: $("#prot_content").code(),
                    prot_parent_id: $("#prot_parent_id").val()
                },
                success: function (result) {
                    if (result.status == "1") {
                        show_message(result.message);
                        $("#form-add-prot").trigger("reset");
                        load_prot_list(result.prot_id);
                        load_add_highlight();
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
function load_prot_edit_validate(prot_id) {
    $("#form-update-prot").validate({
        rules: {
            prot_name: {
                required: true
            }
        },
        messages: {
            prot_name: {
                required: "Vui lòng nhập Tên Product Tag"
            }
        },
        submitHandler: function () {
            $.ajax({
                url: "admin.php?c=products&m=type_update&p=" + prot_id,
                async: false,
                type: "post",
                dataType: "json",
                data: {
                    prot_name: $("#prot_name").val(),
                    prot_slug: $("#prot_slug").val(),
                    prot_seo_title: $("#prot_seo_title").val(),
                    prot_seo_description: $("#prot_seo_description").val(),
                    prot_content: $("#prot_content").code(),
                    prot_parent_id: $("#prot_parent_id").val()
                },
                success: function (result) {
                    if (result.status == "1") {
                        show_message(result.message);
                        $("#form-add-update").trigger("reset");
                        load_prot_list(prot_id);
                        prot_edit(prot_id);
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

//parameter prot id want to highlight
function load_prot_list(prot_id) {
    // get ntype list
    $.ajax({
        url: "/admin.php?c=products&m=type_list&p=" + prot_id,
        async: false,
        success: function (result) {
            $("#panel-prot-list").html(result);

        },
        error: function (e) {
            alert("Khong the lay danh sach products type " + e.responseText)
        }
    });
}


// setting summernote for textarea
function init_textarea() {
    $("#prot_content").summernote({
        toolbar: [
            //[groupname, [button list]]

            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['color', ['color']]
        ]
    });
}

// install edit and delete link on prot table
function prot_delete(prot_id, current_element)
{
    $.ajax({
        url: "/admin.php?c=products&m=type_del&p=" + prot_id,
        success: function (result) {
            if (result == "1") {
                trElement = $(current_element).closest("tr");
                if($(trElement).hasClass("bg-color-3"))
                {
                    load_type_add();
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

function prot_edit(prot_id, current_element)
{
    $.ajax({
        url: "/admin.php?c=products&m=type_edit&p=" + prot_id,
        success: function (result) {
            if (result == "0") {
                alert("Không tồn tại product tag này");
            }
            else {
                $("#products-type-wrapper .type-command").html(result);

                trElement = $(current_element).closest("tr");
                trElement.addClass("bg-color-3");
                init_textarea();
                load_prot_edit_validate(prot_id);
            }
        },
        error: function (e) {
            alert("Lỗi " + e);
        }
    });
}

function show_message(message)
{
    $("#add-prot-message").html(message);
    $("#add-prot-message").show();
    $("#add-prot-message").fadeOut(3000);
}

function load_add_highlight()
{
    $("tr.bg-color-3").removeClass("bg-color-3").addClass("active_add_tran");
    $("tr.active_add_tran").toggleClass("active_add_tran-change");

}