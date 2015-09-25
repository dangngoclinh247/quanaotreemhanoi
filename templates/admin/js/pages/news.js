/**
 * Created by Liam Dang on 9/25/2015.
 */
var readyNews = function () {
    return {
        init: function () {
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

            $("#ntype_name").on("input", function() {
                var strSlug = to_slug($("#ntype_name").val());
                //alert(strSlug);
                $("#ntype_slug").val(strSlug);
            })
        }
    }
}();