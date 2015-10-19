/**
 * Created by Liam Dang on 10/9/2015.
 */

var readyNewsType = function() {
    return {
        init: function() {

            /**
             * Setting summernote editor for #ntype_content
             */
            $("#ntype_content").summernote({
                toolbar: [
                    //[groupname, [button list]]

                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['color', ['color']]
                ],
                height: 100
            });

            /**
             * Validate Form #form-ntype-add
             */
            $("#form-ntype-add").validate({
                rules: {
                    ntype_name: {
                        required: true
                    }
                },
                messages: {
                    ntype_name: {
                        required: "Vui lòng nhập Tên Category"
                    }
                }
            });

            /**
             * add slug to #ntype_slug when input event #ntype_name
             */
            $(document).on("input", "#ntype_name", function () {
                var slug = to_slug($(this).val());
                $("#ntype_slug").val(slug);
            });
        }
    }
} ();

var readyNewsTypeEdit = function() {
    return {
        init: function() {

            /**
             * Setting summernote editor for #ntype_content
             */
            $("#ntype_content").summernote({
                toolbar: [
                    //[groupname, [button list]]

                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['color', ['color']]
                ],
                height: 100
            });

            /**
             * Validate Form #form-ntype-add
             */
            $("#form-ntype-add").validate({
                rules: {
                    ntype_name: {
                        required: true
                    }
                },
                messages: {
                    ntype_name: {
                        required: "Vui lòng nhập Tên Category"
                    }
                }
            });

        }
    }
}();

/**
 * Function Delete News_Type in News Type List
 *
 * @param ntype_id
 * @param current_element
 */
function del(ntype_id, current_element)
{
    $.ajax({
        url: "/admin.php?c=news_type&m=delete&p=" + ntype_id,
        success: function (result) {
            if (result == "1") {
                trElement = $(current_element).closest("tr");
                trElement.removeClass("bg-color-3").addClass("bg-color-1");
                trElement.fadeOut(1000);
                window.location.reload();
            }
            else {
                alert("Loi: " + result);
            }
        },
        error: function (e) {
            alert("Khong the lay danh sach news type " + e.responseText)
        }
    });
}