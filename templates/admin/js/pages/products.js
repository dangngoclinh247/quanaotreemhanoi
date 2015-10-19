/**
 * Created by Liam Dang on 10/2/2015.
 */

var readyProducts = function () {
    return {
        init: function () {

        }
    }
}();

function del(pro_id, currentElement) {
    var trElement = $(currentElement).closest("tr");
    $.ajax({
        url: "/admin.php?c=products&m=select&p=" + pro_id,
        dataType: "json",
        success: function (result) {
            if (result.pro_id == "-1") {
                alert("Khong ton tai products nay")
            }
            else {
                $("#modal-products-delete-confirm .product-delete-info-id strong").text(result.id);
                $("#modal-products-delete-confirm .product-delete-info-name strong").text(result.pro_name);
                $("#modal-products-delete-confirm").modal("show")
                $("#modal-products-delete-confirm #btnDeleteConfirm").click(function () {
                    $("#modal-products-delete-confirm").modal("hide");
                    $.ajax({
                        url: "/admin.php?c=products&m=delete&p=" + pro_id,
                        success: function (result) {
                            if (result == "1") {
                                trElement.fadeOut(1000);
                            }
                            else {
                                alert("Không thể xóa " + result);
                            }
                        },
                        error: function (e) {
                            alert("Loi" + e);
                        }
                    });
                });
            }
        },
        error: function (e) {
            alert(e);
        }
    });
    return false;
}
function delTrash(pro_id, currentElement) {
    var trElement = $(currentElement).closest("tr");
    $.ajax({
        url: "/admin.php?c=products&m=select&p=" + pro_id,
        dataType: "json",
        success: function (result) {
            if (result.pro_id == "-1") {
                alert("Khong ton tai products nay")
            }
            else {
                $("#modal-products-delete-confirm .product-delete-info-id strong").text(result.id);
                $("#modal-products-delete-confirm .product-delete-info-name strong").text(result.pro_name);
                $("#modal-products-delete-confirm").modal("show")
                $("#modal-products-delete-confirm #btnDeleteConfirm").click(function () {
                    $("#modal-products-delete-confirm").modal("hide");
                    $.ajax({
                        url: "/admin.php?c=products&m=deleteTrash&p=" + pro_id,
                        success: function (result) {
                            if (result == "1") {
                                trElement.fadeOut(1000);
                            }
                            else {
                                alert("Không thể xóa " + result);
                            }
                        },
                        error: function (e) {
                            alert("Loi" + e);
                        }
                    });
                });
            }
        },
        error: function (e) {
            alert(e);
        }
    });
    return false;
}

var readyProductsAdd = function () {
    return {
        init: function () {

            var pro_id = -1;

            /**
             * init summernote for #news_content page news_add
             */
            $("#pro_content").summernote({
                height: 400,
                onImageUpload: function (files) {
                    sendFile(files[0]);
                }
            });

            /**
             * upload file for news_content - summernote page $news_add
             *
             * @param file
             */
            function sendFile(file) {
                var data = new FormData();
                data.append("file", file);
                $.ajax({
                    data: data,
                    type: "POST",
                    url: "/admin.php?c=products&m=upload&p=" + pro_id,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (result) {
                        if (result.id != -1) {
                            $("#pro_content").summernote("insertImage", result.url, 'filename');
                            pro_id = result.id;
                            load_images_panel(pro_id);
                        } else {
                            alert("loi" + result.id + result.url);
                        }
                    },
                    error: function (e) {
                        alert(e.responseText);
                    }
                });
            }

            /**
             * create slug when input products name
             */
            $(document).on("input", "#pro_name", function () {
                var pro_slug = to_slug($(this).val());
                $("#pro_slug").val(pro_slug);
            });

            $("#brand_id").select2({
                placeholder: "Thương hiệu"
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
                    },
                    brand_id: {
                        required: true,
                        minlength: 1
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
                    },
                    brand_id: {
                        required: "Vui lòng chọn thương hiệu"
                    }
                },
                submitHandler: function () {
                    if (pro_id == -1) {
                        products_insert();
                    }
                    else {
                        products_update(pro_id)
                    }
                }
            });

            function products_update(pro_id) {
                $.ajax({
                    url: "admin.php?c=products&m=update&p=" + pro_id,
                    type: "post",
                    data: {
                        pro_id: $("#pro_id").val(),
                        pro_name: $("#pro_name").val(),
                        pro_slug: $("#pro_slug").val(),
                        pro_content: $("#pro_content").code(),
                        pro_size: $("#pro_size").val(),
                        pro_size_info: $("#pro_size_info").val(),
                        pro_price: $("#pro_price").val(),
                        pro_quantity: $("#pro_quantity").val(),
                        pro_seo_title: $("#pro_seo_title").val(),
                        pro_seo_description: $("#pro_seo_description").val(),
                        pro_status: $("#pro_status:checked").val(),
                        brand_id: $("#brand_id").val(),
                        prot_id: getProtId()
                    },
                    success: function (result) {
                        if (result == "1") {
                            window.location.href = "/admin.php?c=products&m=edit&p=" + pro_id;
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

            function products_insert() {
                alert(getProtId());
                $.ajax({
                    url: "admin.php?c=products&m=insert",
                    type: "post",
                    data: {
                        pro_id: $("#pro_id").val(),
                        pro_name: $("#pro_name").val(),
                        pro_slug: $("#pro_slug").val(),
                        pro_content: $("#pro_content").code(),
                        pro_size: $("#pro_size").val(),
                        pro_size_info: $("#pro_size_info").val(),
                        pro_price: $("#pro_price").val(),
                        pro_quantity: $("#pro_quantity").val(),
                        pro_seo_title: $("#pro_seo_title").val(),
                        pro_seo_description: $("#pro_seo_description").val(),
                        pro_status: $("#pro_status:checked").val(),
                        brand_id: $("#brand_id").val(),
                        prot_id: getProtId()
                    },
                    dataType: "json",
                    success: function (result) {
                        if (result.status == "1") {
                            window.location.href = "/admin.php?c=products&m=edit&p=" + result.pro_id;
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

            function getProtId() {
                var prot_id = new Array();
                $(".prot_id:checked").each(function () {
                    prot_id.push($(this).val());
                });
                return prot_id;
            }

            $(document).on("click", "#btn-image-featured-upload", function () {
                var data = new FormData();
                var file = $("#img_featured").prop("files")[0];
                if (file == undefined) {
                    alert("Vui lòng chọn hình ảnh");
                }
                else {
                    data.append("file", file);
                    data.append("featured", 1);
                    $.ajax({
                        data: data,
                        type: "POST",
                        url: "/admin.php?c=products&m=upload&p=" + pro_id,
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        success: function (result) {
                            pro_id = result.id;
                            load_image_featured_panel(pro_id);
                            load_images_panel(pro_id);
                        },
                        error: function (e) {
                            alert(e.responseText);
                        }
                    });
                }
            })
        }
    }
}();

var readyProductsEdit = function () {
    return {
        init: function () {

            var pro_id = $("#products_id").val();

            load_image_featured_panel(pro_id);
            load_images_panel(pro_id);

            /**
             * init summernote for #news_content page news_add
             */
            $("#pro_content").summernote({
                height: 400,
                onImageUpload: function (files) {
                    sendFile(files[0]);
                }
            });

            /**
             *
             * upload file for news_content - summernote page news_add
             *
             * @param file
             * @param editor
             * @param welEditable
             */
            function sendFile(file) {
                var pro_id = $("#products_id").val();
                var data = new FormData();
                data.append("file", file);
                $.ajax({
                    data: data,
                    type: "POST",
                    url: "/admin.php?c=products&m=ajax_products_add_upload&p=" + pro_id,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (result) {
                        //alert(result);
                        if (result.id != -1) {
                            $("#pro_content").summernote("insertImage", result.url, 'filename');
                            load_images_panel(pro_id);
                        } else {
                            alert("loi" + result.id + result.url);
                        }
                    },
                    error: function (e) {
                        alert(e.responseText);
                    }
                });
            };


            /**
             * Upload image featured
             */
            $(document).on("click", "#btn-products-featured-upload", function () {
                var fd = new FormData();
                var file = $("#img_featured").prop("files")[0];
                fd.append("file", file);
                fd.append("featured", true);
                $.ajax({
                    url: "/admin.php?c=products&m=ajax_products_add_upload&p=" + pro_id,
                    data: fd,
                    type: "post",
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        window.location.reload();
                    },
                    error: function (e) {
                        alert(e.responseText);
                    }
                })
            })

            $("#form-products-edit").validate({
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
                    },
                    brand_id: {
                        required: true,
                        minlength: 1
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
                    },
                    brand_id: {
                        required: "Vui lòng chọn thương hiệu"
                    }
                },
                submitHandler: function () {
                    $.ajax({
                        url: "admin.php?c=products&m=update&p=" + pro_id,
                        type: "post",
                        data: {
                            pro_id: $("#pro_id").val(),
                            pro_name: $("#pro_name").val(),
                            pro_slug: $("#pro_slug").val(),
                            pro_content: $("#pro_content").code(),
                            pro_size: $("#pro_size").val(),
                            pro_size_info: $("#pro_size_info").val(),
                            pro_price: $("#pro_price").val(),
                            pro_quantity: $("#pro_quantity").val(),
                            pro_seo_title: $("#pro_seo_title").val(),
                            pro_seo_description: $("#pro_seo_description").val(),
                            pro_status: $("#pro_status:checked").val(),
                            brand_id: $("#brand_id").val(),
                            prot_id: getProtId()
                        },
                        success: function (result) {
                            if (result == "1") {
                                $("#modal-update-success").modal("show");
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

            function getProtId() {
                var prot_id = new Array();
                $(".prot_id:checked").each(function () {
                    prot_id.push($(this).val());
                });
                return prot_id;
            }

            $(document).on("click", "#btn-image-featured-upload", function () {
                var data = new FormData();
                var file = $("#img_featured").prop("files")[0];
                if (file == undefined) {
                    alert("Vui lòng chọn hình ảnh");
                }
                else {
                    data.append("file", file);
                    data.append("featured", 1);
                    $.ajax({
                        data: data,
                        type: "POST",
                        url: "/admin.php?c=products&m=upload&p=" + pro_id,
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        success: function (result) {
                            pro_id = result.id;
                            load_image_featured_panel(pro_id);
                            load_images_panel(pro_id);
                        },
                        error: function (e) {
                            alert(e.responseText);
                        }
                    });
                }
            })
        }
    }
}();

/**
 * Load news_panel_images to #news_panel_images
 */
function load_image_featured_panel(pro_id) {
    if (pro_id > 0) {
        $.ajax({
            url: "/admin.php?c=products&m=images_featured_panel&p=" + pro_id,
            success: function (result) {
                $("#image-featured").html(result);
            },
            error: function (e) {
                alert("Loi: " + e)
            }
        });
    }
}

function load_images_panel(pro_id) {
    if (pro_id > 0) {
        $.ajax({
            url: "/admin.php?c=products&m=images_panel&p=" + pro_id,
            success: function (result) {
                if ($("#panel-images").length > 0) {
                    $("#panel-images").remove();
                }
                $("#products_right").append(result);
            },
            error: function (e) {
                alert("Loi: " + e)
            }
        });
    }
}

/**
 * Load image info, show modal products image
 *
 * @param pro_id
 * @param img_id
 */
function info_image(pro_id, img_id) {
    $.ajax({
        url: "/admin.php?c=products&m=products_image&p=" + pro_id,
        type: "post",
        data: {
            img_id: img_id
        },
        success: function (result) {
            $("#modal-products-image .products_image").html(result);
            $("#modal-products-image").modal('show');


            $("#btn-set-image-featured").click(function () {
                $.ajax({
                    url: "/admin.php?c=products&m=products_image_set_featured&p=" + pro_id,
                    type: "post",
                    data: {
                        img_id: img_id
                    },
                    success: function (result) {
                        if (result == "1") {
                            $("#btn-set-image-featured").hide();
                            $("#btn-unset-image-featured").show();
                            load_image_featured_panel(pro_id);
                        }
                        else {
                            alert("Khong set duoc" + result);
                        }
                    },
                    error: function (e) {
                        alert(e.responseText);
                    }
                });
            });

            $("#btn-unset-image-featured").click(function () {
                $.ajax({
                    url: "/admin.php?c=products&m=products_image_unset_featured&p=" + pro_id,
                    type: "post",
                    data: {
                        img_id: img_id
                    },
                    success: function (result) {
                        if (result == "1") {
                            $("#btn-set-image-featured").show();
                            $("#btn-unset-image-featured").hide();
                            load_image_featured_panel(pro_id);
                        }
                        else {
                            alert("Khong set duoc" + result);
                        }
                    },
                    error: function (e) {
                        alert(e.responseText);
                    }
                });
            });
        },
        error: function (e) {
            alert(e.responseText);
        }
    });
}

function pro_update(pro_id) {

}