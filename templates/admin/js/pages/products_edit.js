/**
 * Created by Liam Dang on 10/6/2015.
 */



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
                            load_products_images_featured_panel(pro_id);
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
                            load_products_images_featured_panel(pro_id);
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