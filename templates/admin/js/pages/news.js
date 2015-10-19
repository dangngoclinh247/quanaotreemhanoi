/**
 * Created by Liam Dang on 9/29/2015.
 */
var readyNews = function () {
    return {
        init: function () {

            /**
             * set checked for all input[type=checkbox] when click #checkbox-all
             */
            $("#checkbox-all").click(function () {
                var checkStatus = $(this).prop("checked");
                var table = $(this).closest("table");
                $("input[type=checkbox]", table).each(function () {
                    $(this).prop("checked", checkStatus);
                })
            });

            /**
             * #checked-all : false when user click any type=checkbox
             */
            $(".checked-news").click(function () {
                $("#checkbox-all").prop("checked", false);
            });


            /**
             * show edit/delete/hidden when mouse enter and hide when mouse leave (table tr td.list-news-name)
             */
            $("table tr td.list-news-name").on({
                mouseenter: function () {
                    $(this).find(".minimenu").show();
                },
                mouseleave: function () {
                    $(this).find(".minimenu").hide();
                }
            });
        }
    }
}();

/**
 * use for page news -> add
 * @type {{init}}
 */
var readyNewsAdd = function () {
    return {
        init: function () {

            var news_id = -1;
            var saved = true;

            $("#form-news-add").validate({
                rules: {
                    news_name: {
                        required: true
                    }

                },
                messages: {
                    news_name: {
                        required: "Vui lòng nhập Tên Category"
                    }
                }
            });

            $("#btn-save").click(function () {
                if ($("#form-news-add").validate().form() == true) {
                    if (news_id == -1) {
                        news_insert();
                    }
                    else {
                        news_update();
                    }
                }
            })

            /**
             * Disabled publish date when status = draft
             */
            $(".status").click(function () {
                var value = $(this).val();
                var news_publish_date = $("#news_publish_date");
                if (value == "1") {
                    news_publish_date.prop("disabled", false);
                }
                else {
                    news_publish_date.prop("disabled", true);
                }
            });

            $("input, textarea, select").change(function () {
                saved = false;
            });


            /**
             * init date time picker and set default value
             */
            $('#datetimepicker').datetimepicker({
                defaultDate: new Date()
            });

            /**
             * add slug to #news_slug when input event #news_name
             */
            $(document).on("input", "#news_name", function () {
                var slug = to_slug($(this).val());
                $("#news_slug").val(slug);
            });

            /**
             * add slug to #news_slug when input event #news_name
             */
            $(document).on("change", "#news_slug", function () {
                var slug = to_slug($(this).val());
                $(this).val(slug);
            });

            /**
             * checked input checkbox when click on table - tr news_type
             */
            $(document).on("click", "#news_type tbody tr", function () {
                var input = $(this).find("input");
                input.prop("checked", !input.prop("checked"));
            });

            /**
             * confirm when unload

             $(window).on("beforeunload", function () {
                if (saved == false) {
                    return "Dữ liệu bạn chưa được lưu, vui lòng nhấn lưu trước khi thoát khỏi trang này";
                } else {
                }
            })
             */


            /**
             * ajax insert news row
             */
            function news_insert() {
                $.ajax({
                    url: "/admin.php?c=news&m=insert",
                    data: getData(),
                    type: "post",
                    cache: false,
                    //dataType: "json",
                    success: function (result) {
                        if (result == -1) {
                            alert("lỗi insert");
                        }
                        else {
                            window.location.href = "/admin.php?c=news&m=edit&p=" + result;
                        }
                    },
                    error: function (e) {
                        alert("error: " + e.responseText);
                    }
                })
            }


            /**
             * init summernote for #news_content page news_add
             */
            $("#news_content").summernote({
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
             */
            function sendFile(file) {
                var data = new FormData();
                data.append("file", file);
                $.ajax({
                    data: data,
                    type: "POST",
                    url: "/admin.php?c=news&m=upload&p=" + news_id,
                    //cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (result) {
                        $("#news_content").summernote("insertImage", result.url, 'filename');
                        news_id = result.id;
                        load_images_panel(news_id);
                    },
                    error: function (e) {
                        alert(e.responseText);
                    }
                });
            };

            /**
             * ajax update news
             */
            function news_update() {
                $.ajax({
                    url: "/admin.php?c=news&m=update&p=" + news_id,
                    data: getData(),
                    type: "post",
                    success: function (result) {
                        if (result == "1") {
                            window.location.href = "/admin.php?c=news&m=edit&p=" + news_id;
                        }
                        else {
                            alert("Update loi");
                        }
                    },
                    error: function (e) {
                        alert("Loi: " + e)
                    }
                })
            };

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
                        url: "/admin.php?c=news&m=upload&p=" + news_id,
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        success: function (result) {
                            news_id = result.id;
                            load_image_featured_panel(news_id);
                            load_images_panel(news_id);
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

var readyNewsEdit = function () {
    return {
        init: function () {
            var news_id = $("#news_id").val();
            /*var time_save = new Date(0);*/
            load_images_panel(news_id);

            $(".status").click(function () {
                var status = $(this).val();
                if (status == 1) {
                    $("#news_publish_date").prop("disabled", false);
                }
                else {
                    $("#news_publish_date").prop("disabled", true);
                }
            });

            /**
             * add slug to #news_slug when input event #news_name
             */
            $(document).on("change", "#news_slug", function () {
                var slug = to_slug($(this).val());
                $(this).val(slug);
            });

            /**
             * init date time picker
             */
            $('#datetimepicker').datetimepicker();

            /**
             * setting save button
             */
            $("#btn-save").click(function () {
                $(this).addClass("active").addClass("disabled");
            });

            /**
             * checked input checkbox when click on table - tr news_type
             */
            $(document).on("click", "#news_type tbody tr", function () {
                var input = $(this).find("input");
                input.prop("checked", !input.prop("checked"));
            });

            /**
             * init summernote for #news_content page news-edit
             */
            $("#news_content").summernote({
                height: 400,
                onImageUpload: function (files) {
                    sendFile(files[0]);
                }
            });


            /**
             *
             * upload file for news_content - summernote page news-edit
             *
             * @param file
             */
            function sendFile(file) {
                var data = new FormData();
                data.append("file", file);
                $.ajax({
                    data: data,
                    type: "POST",
                    url: "/admin.php?c=news&m=upload&p=" + news_id,
                    //cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (result) {
                        $("#news_content").summernote("insertImage", result.url, 'filename');
                        load_images_panel(news_id);
                    },
                    error: function (e) {
                        alert(e.responseText);
                    }
                });
            };


/*            setInterval(save_update, 1);
            function save_update() {
                var time = new Date(1);
                time_save += time;
                if(time_save.getTime() == 60*60) {
                    $("button[type='submit']").trigger("click");
                }
            }*/

            /**
             *  process when user click submit
             */
            $("button[type='submit']").click(function () {
                time_save = new Date(0);
                var spinner = $(this).find("span");
                spinner.addClass("active");
                $.ajax({
                    url: "/admin.php?c=news&m=update&p=" + $("#news_id").val(),
                    data: getData(),
                    type: "post",
                    cache: false,
                    //dataType: "json",
                    success: function (result) {
                        if (result == "1") {
                            $("#modal-update-success").on("hidden.bs.modal", function () {
                                spinner.removeClass("active");
                            });

                            $("#modal-update-success").modal("show");
                        }
                        else {
                            alert("Update loi" + result);
                        }
                    },
                    error: function (e) {
                        alert("Loi: " + e)
                    }
                });
                return false;
            });

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
                        url: "/admin.php?c=news&m=upload&p=" + news_id,
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        success: function (result) {
                            news_id = result.id;
                            load_image_featured_panel(news_id);
                            load_images_panel(news_id);
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
function load_images_panel(news_id) {
    if (news_id > 0) {
        $.ajax({
            url: "/admin.php?c=news&m=images_panel&p=" + news_id,
            success: function (result) {
                if ($("#panel-images").length > 0) {
                    $("#panel-images").remove();
                }
                $("#news_add_right").append(result);
            },
            error: function (e) {
                alert("Loi: " + e)
            }
        });
    }
}

/**
 * Load news_panel_images to #news_panel_images
 */
function load_image_featured_panel(news_id) {
    if (news_id > 0) {
        $.ajax({
            url: "/admin.php?c=news&m=image_featured_panel&p=" + news_id,
            success: function (result) {
                $("#image-featured").html(result);
            },
            error: function (e) {
                alert("Loi: " + e)
            }
        });
    }
}

/**
 * get all data in add form
 * @returns {object}
 */
function getData() {
    var ntype_id = new Array();
    $(".ntype_id:checked").each(function () {
        ntype_id.push($(this).val());
    });
    var data = {
        news_name: $("#news_name").val(),
        news_slug: $("#news_slug").val(),
        news_content: $("#news_content").code(),
        news_seo_title: $("#news_seo_title").val(),
        news_seo_description: $("#news_seo_description").val(),
        ntype_id: ntype_id,
        status: $(".status:checked").val(),
        news_publish_date: $("#news_publish_date").val()
    };
    return data;
}

function info_image(img_id, news_id) {
    $.ajax({
        url: "/admin.php?c=images&m=image&p=" + img_id,
        success: function (result) {
            $("#modal-news-images .news_image_panel").html(result);
            $("#modal-news-images").modal('show');

            $("#btn-set-image-featured").click(function () {
                $.ajax({
                    url: "/admin.php?c=news&m=image_set_featured&p=" + img_id,
                    success: function (result) {
                        if (result == "1") {
                            $("#btn-set-image-featured").hide();
                            $("#btn-unset-image-featured").fadeIn(1000);
                            load_image_featured_panel(news_id);
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
                    url: "/admin.php?c=images&m=resetFeatured&p=" + img_id,
                    success: function (result) {
                        if (result == "1") {
                            $("#btn-unset-image-featured").hide();
                            $("#btn-set-image-featured").fadeIn(1000);
                            load_image_featured_panel(news_id);
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