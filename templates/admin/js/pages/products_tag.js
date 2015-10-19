/**
 * Created by Liam Dang on 9/26/2015.
 */
var readyProductsTag = function () {
    return {
        init: function () {

            $("#ptag_content").summernote({
                toolbar: [
                    //[groupname, [button list]]

                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['color', ['color']]
                ],
                height: 150
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

            //remove all class bg-color-3 when click edit
            $(document).on("click", ".btn_ptag_edit", function() {
                $("table tr").removeClass("bg-color-3");
            });

            $(document).on("input", "#form-add-ptag #ptag_name", function(e) {
                var slug = to_slug($(this).val());
                $("#ptag_slug").val(slug);
            });

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
                }
            });

            /**
             * add slug to #ptag_slug when input event #ptag_slug
             */
            $(document).on("change", "#ptag_slug", function () {
                var slug = to_slug($(this).val());
                $(this).val(slug);
            });
        }
    }
}();

var readyProductsTagEdit = function() {
    return {
        init: function() {
            readyProductsTag.init();
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
                }
            });
        }
    }
}();

// install edit and delete link on ptag table
function ptag_delete(ptag_id, current_element)
{
    var trElement = $(current_element).closest("tr");
    trElement.addClass("bg-color-1");
    $.ajax({
        url: "/admin.php?c=products_tag&m=delete&p=" + ptag_id,
        success: function (result) {
            if (result == "1") {
                var trElement = $(current_element).closest("tr");
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