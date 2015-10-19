/**
 * Created by Liam Dang on 9/27/2015.
 */
var readyProductsType = function () {
    return {
        init: function () {

            $("#prot_content").summernote({
                toolbar: [
                    //[groupname, [button list]]

                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['color', ['color']]
                ],
                height: 150
            });

            $(document).on("input", "#form-add-type #prot_name", function(e) {
                var slug = to_slug($(this).val());
                $("#prot_slug").val(slug);
            });

            $("#prot_slug").change(function() {
                var slug = to_slug($(this).val());
                $(this).val(slug);
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
                }
            });
        }
    }
}();


// install edit and delete link on prot table
function del(prot_id, current_element)
{
    var trElement = $(current_element).closest("tr");
    trElement.addClass("bg-color-1");
    $.ajax({
        url: "/admin.php?c=products_type&m=delete&p=" + prot_id,
        success: function (result) {
            if (result == "1") {
                trElement.addClass("bg-color-1");
                trElement.fadeOut(1000);
            }
            else {
                trElement.removeClass("bg-color-1");
                alert("Lỗi");
            }
        },
        error: function (e) {
            alert("Lỗi " + e);
        }
    });
    return false;
}