/**
 * Created by Liam Dang on 10/2/2015.
 */

var readyBrandAdd = function () {
    return {
        init: function () {

            load_brand_list(-1); // Load brand list


            $(document).on("input", "#brand_name", function () {
                var slug = to_slug($(this).val());
                $("#brand_slug").val(slug);
            });

            $(document).on("change", "#brand_slug", function () {
                var slug = to_slug($(this).val());
                $(this).val(slug);
            });

            /**
             *  Setting button checkbox-all
             */
            $(document).on("click", "#brand-checkbox-all", function () {
                var checkboxStatus = $(this).prop("checked");
                var currentTable = $(this).closest("table");
                $("input.brand_id", currentTable).prop("checked", checkboxStatus);
            });

            /**
             *  checked = false for any checkbox brand_id click
             */
            $(document).on("click", "input.brand_id", function () {
                $("#brand-checkbox-all").prop("checked", false);
            });

            /**
             * setting summernote for brand_content
             */
            $("#brand_content").summernote({
                toolbar: [
                    //[groupname, [button list]]

                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['color', ['color']]
                ],
                height: 150
            });

            /**
             * setting validate for form add brand
             */
            $("#form-add-brand").validate({
                rules: {
                    brand_name: {
                        required: true,
                        remote: {
                            url: "/admin.php?c=brand&m=ajax_check_brand_name",
                            type: "post",
                            cache: false,
                            data: {
                                brand_name: function () {
                                    return $('#form-add-brand #brand_name').val();
                                }
                            }
                        }
                    }
                },
                messages: {
                    brand_name: {
                        required: "Vui lòng nhập Tên Thương Hiệu",
                        remote: "Thương hiệu này đã được thêm trước đây"
                    }
                },
                submitHandler: function () {
                    $.ajax({
                        url: "/admin.php?c=brand&m=ajax_add",
                        type: "post",
                        data: getBrandFormData(),
                        async: false,
                        cache: false,
                        success: function (result) {
                            if (result != "-1") {
                                load_brand_list(result);
                                $("#form-add-brand").trigger("reset");
                            }
                            else {
                                alert("Lỗi, không thể thêm thương hiệu này");
                            }
                        },
                        error: function (e) {
                            alert("error: " + e);
                        }
                    });
                }
            });

            /**
             * setting button delete for brand
             */
            $(document).on("click", ".btn-brand-delete", function () {
                var url = $(this).attr("href");
                var trElement = $(this).closest("tr");
                $.ajax({
                    url: url,
                    success: function (result) {
                        if (result == "1") {
                            trElement.addClass("bg-color-4").fadeOut(1000);
                        } else {
                            alert("Không thể xóa lúc này");
                        }
                    },
                    error: function (e) {
                        alert("Error: " + e)
                    }
                });
                return false;
            });
        }
    }
}();

var readyBrandEdit = function () {
    return {
        init: function () {

            load_brand_list(-1); // Load brand list

            $(document).on("change", "#brand_slug", function () {
                var slug = to_slug($(this).val());
                $(this).val(slug);
            });

            /**
             *  Setting button checkbox-all
             */
            $(document).on("click", "#brand-checkbox-all", function () {
                var checkboxStatus = $(this).prop("checked");
                var currentTable = $(this).closest("table");
                $("input.brand_id", currentTable).prop("checked", checkboxStatus);
            });

            /**
             *  checked = false for any checkbox brand_id click
             */
            $(document).on("click", "input.brand_id", function () {
                $("#brand-checkbox-all").prop("checked", false);
            });

            /**
             * setting summernote for brand_content
             */
            $("#brand_content").summernote({
                toolbar: [
                    //[groupname, [button list]]

                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['color', ['color']]
                ]
            });

            /**
             * setting validate for form add brand
             */
            $("#form-update-brand").validate({
                rules: {
                    brand_name: {
                        required: true,
                        remote: {
                            url: "/admin.php?c=brand&m=ajax_check_brand_name",
                            type: "post",
                            cache: false,
                            data: {
                                brand_name: function () {
                                    return $('#form-update-brand #brand_name').val();
                                },
                                brand_id: function () {
                                    return $('#form-update-brand #brand_id').val();
                                }
                            }
                        }
                    }
                },
                messages: {
                    brand_name: {
                        required: "Vui lòng nhập Tên Thương Hiệu",
                        remote: "Tên thương hiệu này đã tồn tại trong danh sách"
                    }
                }
            });

            /**
             * setting button delete for brand
             */
            $(document).on("click", ".btn-brand-delete", function () {
                var url = $(this).attr("href");
                var trElement = $(this).closest("tr");
                $.ajax({
                    url: url,
                    success: function (result) {
                        if (result == "1") {
                            trElement.addClass("bg-color-4").fadeOut(1000);

                        } else {
                            alert("Không thể xóa lúc này");
                        }
                    },
                    error: function (e) {
                        alert("Error: " + e)
                    }
                });
                return false;
            });

        }
    };
}();

function getBrandFormData() {
    var data = {
        brand_name: $("#brand_name").val(),
        brand_slug: $("#brand_slug").val(),
        brand_content: $("#brand_content").code(),
        brand_seo_title: $("#brand_seo_title").val(),
        brand_seo_description: $("#brand_seo_description").val()
    };
    return data;
}

function load_brand_list(brand_id_highlight) {
    $.ajax({
        url: "/admin.php?c=brand&m=ajax_list&p=" + brand_id_highlight,
        async: false,
        success: function (result) {
            $("#panel-brand-list .panel-body").html(result);
            if (brand_id_highlight > 0) {
                $(".active_add_tran").delay(1000).addClass("active");
                /*var curTable = $(".active_add_tran").closest("table");
                 curTable.addClass("has-active-tr", 1000);*/
            }
        },
        error: function (e) {
            alert("error: " + e);
        }
    });
}
