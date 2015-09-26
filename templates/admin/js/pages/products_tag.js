/**
 * Created by Liam Dang on 9/26/2015.
 */
var readyProductsTag = function () {
    return {
        init: function () {

            // Load tag_add and tag_list
            load_ptag_add();
            load_ptag_list();

            // Auto generator ptag_slug
            $("#ptag_name").on("input", function () {
                var strSlug = to_slug($(this).val());
                $("#ptag_slug").val(strSlug);
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
            }, "#ptag-list tr");
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
            load_ntype_add_validate();
        },
        error: function (e) {
            alert("Khong the lay danh sach news type " + e)
        }
    });
}

// load check validate for form ptag add
function load_ntype_add_validate() {
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
                    ptag_parent_id: $("#ptag_parent_id").val(),
                    ptag_content: $("#ptag_content").code()
                },
                success: function (result) {
                    if (result.status == "1") {
                        $("#add-ptag-message").html(result.message);
                        $("#add-ptag-message").show();
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

//parameter ptag id want to highlight
function load_ptag_list(ptag_id) {
    // get ntype list
    $.ajax({
        url: "/admin.php?c=products&m=tag_list&p=" + ptag_id,
        async: false,
        success: function (result) {
            $("#panel-ptag-list .panel-body").html(result);

            // install checkbox all
            init_checkbox_all()
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

// install checkbox all
function init_checkbox_all() {
    $("#ptag-checkbox-all").on("click", function() {
        var checkboxStatus = $(this).prop("checked");
        var parentElement = $(this).closest("table");
        $(".ntype-check", parentElement).each(function() {
            $(this).prop("checked", checkboxStatus);
        });
    })
}

// install edit and delete link on ptag table
function init_edit_delete()
{

}