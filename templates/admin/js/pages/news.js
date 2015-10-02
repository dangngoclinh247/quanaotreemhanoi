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

function autoLoadNTypeList(ntype_id) {
    // get ntype list
    $.ajax({
        url: "/admin.php?c=news&m=ntype_list&p=" + ntype_id,
        success: function (result) {
            $("#panel-ntype-list .panel-body").html(result);
        },
        error: function (e) {
            alert("Khong the lay danh sach news type " + e.responseText)
        }
    });
}

function ntype_delete(id, current_element) {
    $.ajax({
        url: "/admin.php?c=news&m=ntype_del",
        type: "post",
        data: {
            ntype_id: id
        },
        dataType: "json",
        success: function (result) {
            if (result.status == "1") {
                trElement = $(current_element).closest("tr");
                trElement.removeClass("bg-color-3").addClass("bg-color-1");
                trElement.fadeOut(5000);
            }
            else {
                alert(status.news_type);
            }
        },
        error: function (e) {
            alert("Khong the lay danh sach news type " + e.responseText)
        }
    });
}

function ntype_edit(id, current_element) {
    trElement = $(current_element).closest("tr");
    $.ajax({
        url: "/admin.php?c=news&m=ntype_edit&p=" + id,
        success: function (result) {
            if (result == "0") {
                alert("Can't Edit")
            } else {
                // remove all tr background color
                $("table tr").each(function () {
                    $(this).removeClass("bg-color-3");
                });
                trElement.addClass("bg-color-3");
                $("#ntype-wrapper .ntype-command").fadeOut(200, function () {
                    $("#ntype-wrapper .ntype-command").html(result);
                    init_textarea();
                    load_ntype_edit_validate(id);
                });
                $("#ntype-wrapper .ntype-command").css("boder-color", "#f0b67f");
                $("#ntype-wrapper .ntype-command").fadeIn(500);
            }
        },
        error: function (e) {
            alert("Khong the lay danh sach news type " + e)
        }
    });
}

function init_textarea() {
    // add textarea for ntype-content
    $("#ntype_content").summernote({
        toolbar: [
            //[groupname, [button list]]

            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['color', ['color']]
        ]
    });
}

function load_ntype_add() {
    $.ajax({
        url: "/admin.php?c=news&m=ntype_add",
        async: false,
        success: function (result) {
            $("#ntype-wrapper .ntype-command").html(result);
            init_textarea();
            load_ntype_add_validate();
        },
        error: function (e) {
            alert("Khong the lay danh sach news type " + e)
        }
    });
}

function load_ntype_add_validate() {
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
                url: "admin.php?c=news&m=ntype_insert",
                type: "post",
                dataType: "json",
                data: {
                    ntype_add: "ok",
                    ntype_name: $("#ntype_name").val(),
                    ntype_slug: $("#ntype_slug").val(),
                    ntype_seo_title: $("#ntype_seo_title").val(),
                    ntype_seo_description: $("#ntype_seo_description").val(),
                    ntype_parent_id: $("#ntype_parent_id").val(),
                    ntype_content: $("#ntype_content").code()
                },
                success: function (result) {
                    if (result.status == "1") {
                        $("#add-ntype-message").html(result.message);
                        $("#add-ntype-message").show();
                        $("#form-add-ntype").trigger("reset");
                        autoLoadNTypeList();
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

function load_ntype_edit_validate(id) {
    $("#form-update-ntype").validate({
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
                url: "admin.php?c=news&m=ntype_update&p=" + id,
                type: "post",
                dataType: "json",
                data: {
                    ntype_name: $("#ntype_name").val(),
                    ntype_slug: $("#ntype_slug").val(),
                    ntype_seo_title: $("#ntype_seo_title").val(),
                    ntype_seo_description: $("#ntype_seo_description").val(),
                    ntype_parent_id: $("#ntype_parent_id").val(),
                    ntype_content: $("#ntype_content").code()
                },
                success: function (result) {
                    if (result.status == "1") {
                        $("#message-edit").html(result.message);
                        autoLoadNTypeList(id);
                    }
                    else {
                        alert("Du lieu nay da bi xoa truoc do");
                        load_ntype_add()
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

/**
 * use for page news -> add
 * @type {{init}}
 */
var readyNewsAdd = function () {
    return {
        init: function () {

            var news_id = -1;
            var saved = true;

            load_news_status_checkbox();
            load_news_content_summernote();

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
             * setting active and disabled for save button
             */
            $("#savebutton").click(function () {
                $(this).addClass("active").addClass("disabled");
            });

            /**
             * add slug to #news_slug when input event #news_name
             */
            $(document).on("input", "#news_name", function () {
                var slug = to_slug($(this).val());
                $("#news_slug").val(slug);
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
             */
            $(window).on("beforeunload", function () {
                if (save == false) {
                    return "Dữ liệu bạn chưa được lưu, vui lòng nhấn lưu trước khi thoát khỏi trang này";
                } else {
                }
            })


            /**
             *  process when user click submit
             */
            $("button[type='submit']").click(function () {
                if (news_id == -1) {
                    news_insert();
                }
                else {
                    news_update();
                }
            });

            /**
             * ajax insert news row
             */
            function news_insert() {
                $.ajax({
                    url: "/admin.php?c=news&m=news_insert",
                    data: getData(),
                    type: "post",
                    cache: false,
                    //dataType: "json",
                    success: function (result) {
                        if (result == -1) {
                            alert("lỗi insert");
                        }
                        else {
                            window.location.href = "/admin.php?c=news&m=news_edit&p=" + result;
                            /*                            news_id = result;
                             saved = true;
                             load_news_panel_images();

                             unactive_savebutton(1000);*/
                        }
                    },
                    error: function (e) {
                        alert("error: " + e.responseText);
                    }
                })
            }

            /**
             * ajax update news
             */
            function news_update() {
                $.ajax({
                    url: "/admin.php?c=news&m=news_update&p=" + news_id,
                    data: getData(),
                    type: "post",
                    //cache: false,
                    //dataType: "json",
                    success: function (result) {
                        if (result == "1") {
                            window.location.href = "/admin.php?c=news&m=news_edit&p=" + news_id;
                            /*                            load_news_panel_images();
                             unactive_savebutton(1000);*/
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


            /**
             * init summernote for #news_content page news_add
             */
            function load_news_content_summernote() {
                $("#news_content").summernote({
                    height: 400,
                    onImageUpload: function (files, editor, welEditable) {
                        sendFile(files[0], editor, welEditable);
                    }
                });
            }


            /**
             *
             * upload file for news_content - summernote page news_add
             *
             * @param file
             * @param editor
             * @param welEditable
             */
            function sendFile(file, editor, welEditable) {
                var data = new FormData();
                data.append("file", file);
                $.ajax({
                    data: data,
                    type: "POST",
                    url: "/admin.php?c=news&m=news_add_upload&p=" + news_id,
                    //cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (result) {
                        $("#news_content").summernote("insertImage", result.url, 'filename');
                        news_id = result.id;
                        load_news_panel_images();
                    },
                    error: function (e) {
                        alert(e.responseText);
                    }
                });
            };
        }
    }
}();

var readyNewsEdit = function () {
    return {
        init: function () {
            var news_id = $("#news_id").val();

            load_news_content_summernote();
            load_news_status_checkbox();
            load_news_panel_images(news_id);
            load_image_featured(news_id);

            if ($(".news_status:checked").val() == 1) {
                $("#news_publish_date").prop("disabled", false);
            }

            /**
             * init date time picker
             */
            $('#datetimepicker').datetimepicker();

            /**
             * setting save button
             */
            $("#savebutton").click(function () {
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
            function load_news_content_summernote() {
                $("#news_content").summernote({
                    height: 400,
                    onImageUpload: function (files, editor, welEditable) {
                        sendFile(files[0], editor, welEditable);
                    }
                });
            }


            /**
             *
             * upload file for news_content - summernote page news-edit
             *
             * @param file
             * @param editor
             * @param welEditable
             */
            function sendFile(file, editor, welEditable) {
                var data = new FormData();
                data.append("file", file);
                $.ajax({
                    data: data,
                    type: "POST",
                    url: "/admin.php?c=news&m=news_add_upload&p=" + news_id,
                    //cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (result) {
                        $("#news_content").summernote("insertImage", result.url, 'filename');
                        load_news_panel_images(result.id);
                    },
                    error: function (e) {
                        alert(e.responseText);
                    }
                });
            };

            /**
             *  process when user click submit
             */
            $("button[type='submit']").click(function () {
                $.ajax({
                    url: "/admin.php?c=news&m=news_update&p=" + $("#news_id").val(),
                    data: getData(),
                    type: "post",
                    cache: false,
                    //dataType: "json",
                    success: function (result) {
                        if (result == "1") {
                            window.location.reload();
                        }
                        else {
                            alert("Update loi");
                        }
                    },
                    error: function (e) {
                        alert("Loi: " + e)
                    }
                })
            });
        }
    }
}();

/**
 * Load news_panel_images to #news_panel_images
 */
function load_news_panel_images(news_id) {
    if (news_id > 0) {
        $.ajax({
            url: "/admin.php?c=news&m=news_panel_images&p=" + news_id,
            success: function (result) {
                if ($("#news-panel-images").length > 0) {
                    $("#news-panel-images").remove();
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
        nstatus_id: $(".news_status:checked").val(),
        news_publish_date: $("#news_publish_date").val(),
        nstatus_id: $(".news_status:checked").val()
    };
    return data;
}

/**
 * Load news status checkbox when event click
 */
function load_news_status_checkbox() {
    $(".news_status").click(function () {
        var value = $(this).val();
        if (value == "1") {
            $("#news_publish_date").prop("disabled", false);
        }
        else {
            $("#news_publish_date").prop("disabled", true);
        }
    });
}

function info_image(news_id, img_id) {
    $.ajax({
        url: "/admin.php?c=news&m=news_image_panel",
        type: "post",
        data: {
            news_id: news_id,
            img_id: img_id
        },
        success: function (result) {
            $("#modal-news-images .news_image_panel").html(result);
            $("#modal-news-images").modal('show');
            $("#btn-set-image-featured").click(function () {
                $.ajax({
                    url: "/admin.php?c=news&m=news_image_set_featured",
                    type: "post",
                    data: {
                        news_id: news_id,
                        img_id: img_id
                    },
                    success: function (result) {
                        if (result == "1") {
                            var element = $("#btn-set-image-featured").prop("disabled", true).closest("div");
                            element.append("Đã đặt hình này là featured");
                            load_image_featured(news_id);
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

function load_image_featured(news_id) {
    $.ajax({
        url: "/admin.php?c=news&m=load_image_featured&p=" + news_id,
        success: function (result) {
            if ($("#panel-image-featured").length > 0) {
                $("#panel-image-featured").remove();
            }
            $("#news_add_right").append(result);
        }
    });
}