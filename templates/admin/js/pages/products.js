/**
 * Created by Liam Dang on 10/2/2015.
 */

var readyProductsAdd = function () {
    return {
        init: function () {

            $("#pro_content").summernote({
                height: 300
            });

            /**
             * create slug when input products name
             */
            $(document).on("input", "#pro_name", function() {
                var pro_slug = to_slug($(this).val());
                $("#pro_slug").val(pro_slug);
            });

            $("#form-products-add").validate({
                rules: {
                    pro_id: {
                        required: true
                    },
                    pro_name: {
                        required: true
                    },
                    pro_size: {
                        required: true,
                        min: 1
                    },
                    pro_size_info: {
                        required: true
                    },
                    pro_price: {
                        required: true,
                        min: 1000
                    },
                    pro_quantity: {
                        min: 1
                    }
                },
                messages: {
                    pro_id: {
                        required: "Vui lòng nhập mã sản phẩm"
                    },
                    pro_name: {
                        required: "Vui lòng nhập tên sản phẩm"
                    },
                    pro_size: {
                        required: "Vui lòng nhập số size / ri",
                        min: "Số size phải là số và lớn hơn 1"
                    },
                    pro_size_info: {
                        required: "Vui lòng nhập thông tin size"
                    },
                    pro_price: {
                        required: "Vui lòng nhập giá sản phẩm",
                        min: "Giá sản phẩm phải lớn hơn 1000 VNĐ"
                    },
                    pro_quantity: {
                        min: "Tồn kho phải lớn hơn 1"
                    }
                },
                submitHandler: function () {
                    $.ajax({
                        url: "admin.php?c=products&m=ajax_products_add",
                        type: "post",
                        dataType: "json",
                        data: {
                            pro_add: "ok",
                            pro_name: $("#pro_name").val(),
                            pro_slug: $("#pro_slug").val(),
                            pro_content: $("#pro_content").code(),
                            pro_size: $("#pro_size").val(),
                            pro_size_info: $("#pro_size_info").val(),
                            pro_price: $("#pro_price").val(),
                            pro_quantity: $("#pro_quantity").val(),
                            pro_seo_title: $("#pro_seo_title").val(),
                            pro_seo_description: $("#pro_seo_description").val(),
                            pro_status: $("#pro_status").val()
                        },
                        success: function (result) {
                            if (result != -"1") {
                                alert("them thanh cong")
                            }
                            else {
                                alert("Error: " + result);
                            }
                        },
                        error: function (e) {
                            alert(e.responseText);
                        }
                    });
                }
            });

            $("#btn-brand-add").click(function () {
                alert("them");
            })
        }
    }
}();