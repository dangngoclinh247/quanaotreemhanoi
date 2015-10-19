(function ($) {
    "use strict";

    /* ==============================================
     TABBED HOVER -->
     =============================================== */

    $('.nav-pills > li ').hover(function () {
        if ($(this).hasClass('hoverblock'))
            return;
        else
            $(this).find('a').tab('show');
    });

    $('.nav-tabs > li').find('a').click(function () {
        $(this).parent()
            .siblings().addClass('hoverblock');
    });

    $(document).ready(function () {
        $('.topbarhover').hover(function () {
            $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(200);
        }, function () {
            $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(200);
        });
    });

    $(".ddd").on("click", function () {
        var $button = $(this);
        var $input = $button.closest('.sp-quantity').find("input.quntity-input");

        $input.val(function (i, value) {
            return +value + (1 * +$button.data('multi'));
        });
    });

    /* ==============================================
     MENU HOVER -->
     =============================================== */

    jQuery('.hovermenu .dropdown').hover(function () {
        jQuery(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn();
    }, function () {
        jQuery(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut();
    });

    /* ==============================================
     MENU CLICKABLE for HORIZONTAL -->
     =============================================== */

    $('.clickablemenu .dropdown').click('show.bs.dropdown', function (e) {
        var $dropdown = $(this).find('.dropdown-menu');
        var orig_margin_top = parseInt($dropdown.css('margin-top'));
        $dropdown.css({
            'margin-top': (orig_margin_top + 65) + 'px',
            opacity: 0
        }).animate({'margin-top': orig_margin_top + 'px', opacity: 1}, 420, function () {
            $(this).css({'margin-top': ''});
        });
    });

    /* ==============================================
     MENU CLICKABLE for VERTICAL -->
     =============================================== */

    $('.verticalmenu .dropdown').click('show.bs.dropdown', function (e) {
        var $dropdown = $(this).find('.dropdown-menu');
        var orig_margin_top = parseInt("1", 10);
        $dropdown.css({
            'margin-left': (orig_margin_top + 65) + 'px',
            opacity: 0
        }).animate({'margin-left': orig_margin_top + 'px', opacity: 1}, 420, function () {
            $(this).css({'margin-left': ''});
        });
    });

    /* ==============================================
     TOOLTIP -->
     =============================================== */

    $('body').tooltip({
        selector: "[data-tooltip=tooltip]",
        container: "body"
    });

    /* ==============================================
     CAROUSEL -->
     =============================================== */

    $('#owl-sidebar').owlCarousel({
        loop: true,
        margin: 30,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        nav: false,
        dots: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    })
    $('#owl-home').owlCarousel({
        loop: true,
        margin: 30,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        nav: false,
        dots: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    })
    $('#owl-featured').owlCarousel({
        loop: true,
        margin: 15,
        nav: true,
        dots: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 4
            }
        }
    })
    $('#owl-recent-second').owlCarousel({
        loop: true,
        margin: 15,
        nav: true,
        dots: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    })
    $('#owl-featured-second').owlCarousel({
        loop: true,
        margin: 15,
        nav: true,
        dots: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    })
    $('#owl-recent').owlCarousel({
        loop: true,
        margin: 15,
        nav: true,
        dots: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 4
            }
        }
    })
    $('#owl-blog').owlCarousel({
        loop: true,
        margin: 15,
        nav: true,
        dots: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    })
    $('#owl-testi').owlCarousel({
        loop: true,
        margin: 15,
        nav: false,
        dots: false,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 4
            }
        }
    })

    /* ==============================================
     LOADER -->
     =============================================== */

    $(window).load(function () {
        $('#loader').delay(300).fadeOut('slow');
        $('#loader-container').delay(200).fadeOut('slow');
        $('body').delay(300).css({'overflow': 'visible'});
    })

    /* ==============================================
     ANIMATION -->
     =============================================== */

    new WOW({
        boxClass: 'wow',      // default
        animateClass: 'animated', // default
        offset: 0,          // default
        mobile: true,       // default
        live: true        // default
    }).init();

    /* ==============================================
     BACK TOP -->
     =============================================== */

    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 1) {
            jQuery('.backtotop').css({bottom: "25px"});
        } else {
            jQuery('.backtotop').css({bottom: "-100px"});
        }
    });
    jQuery('.backtotop').click(function () {
        jQuery('html, body').animate({scrollTop: '0px'}, 800);
        return false;
    });

    /* ===============================================
     Rating
     ================================================ */

    $('.ratebox').raterater({
        submitFunction: 'rateAlert',
        allowChange: true,
        starWidth: 13,
        spaceWidth: 5,
        numStars: 5
    });

    /* ===============================================
     Login and Register
     ================================================ */
    $(document).on("click", ".btn-login", function () {
        $("#modal-login").modal("show");
        return false;
    });
    $(document).on("click", ".btn-register", function () {
        $("#modal-register").modal("show");
        return false;
    });

    $("#modal-login form").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true
            }
        },
        messages: {
            email: {
                required: "Vui lòng nhập Email",
                email: "Email không đúng"
            },
            password: {
                required: "Vui lòng nhập Mật Khẩu"
            }
        },
        submitHandler: function () {
            $.ajax({
                url: "/admin.php?c=login&m=process",
                async: false,
                type: "post",
                data: {
                    email: $("#email").val(),
                    pass: $("#password").val(),
                    remember: $("#remember").prop("checked")
                },
                success: function (result) {
                    if (result == "1") {
                        window.location.reload();
                    } else {
                        $("#modal-login .modal-body p").remove();
                        $("#modal-login .modal-body").prepend("<p>Sai Email or Mật Khẩu</p>");
                    }
                },
                error: function (e) {
                    alert(e);
                }
            });
        },
        error: function (e) {
            alert("Loi " + e);
        }
    });

    $("#modal-register form").validate({
        rules: {
            user_email: {
                required: true,
                email: true,
                remote: {
                    url: "/home.php?c=users&m=ajax_check_email",
                    type: "post",
                    cache: false,
                    data: {
                        user_email: function () {
                            return $("#modal-register form #user_email").val();
                        },
                        user_id: function () {
                            return $("#modal-register form #user_id").val();
                        }
                    }
                }
            },
            user_pass: {
                required: true
            },
            user_phone: {
                required: true
            },
            user_name: {
                required: true
            },
            user_address: {
                required: true
            }
        },
        messages: {
            user_email: {
                required: "Vui lòng nhập Email",
                email: "Email không đúng",
                remote: "Email đã đăng ký - Đăng nhập"
            },
            user_pass: {
                required: "Vui lòng nhập Mật khẩu"
            },
            user_phone: {
                required: "Vui lòng nhập Số điện thoại"
            },
            user_name: {
                required: "Vui lòng nhập Tên"
            },
            user_address: {
                required: "Vui lòng nhập Địa chỉ"
            }
        },
        submitHandler: function () {
            $.ajax({
                url: "/home.php?c=users&m=insert",
                type: "post",
                data: {
                    user_email: $("#user_email").val(),
                    user_pass: $("#user_pass").val(),
                    user_name: $("#user_name").val(),
                    user_phone1: $("#user_phone1").val(),
                    user_address: $("#user_address").val()
                },
                success: function (result) {
                    if (result == "1") {
                        $("#modal-register .modal-body").html("Đã đăng ký thành công, Vui lòng <a class='btn-login' href='#' data-dismiss='modal'>đăng nhập</a>");
                    }
                    else {
                        alert("Loi " + result);
                    }
                },
                error: function (e) {
                    alert(e);
                }
            });
        }
    });
/* ===============================================
 Btn-add-to-cart
 ================================================ */
$(".btn-add-to-card").click(function() {
    var pro_id = $(this).attr("data-id");
    $.ajax({
        url: "/home.php?c=shop&m=add_to_cart&p=" + pro_id,
        success: function (result) {
            if (result == "1") {
                $("#modal-add-to-cart-success").modal("show");
            }
            else {
                alert("You can't Voting " + result);
            }
        },
        error: function (e) {
            alert(e);
        }
    })
})

})(jQuery);

function rateAlert(pro_id, pro_rate) {
    $.ajax({
        url: "/home.php?c=shop&m=vote&p=" + pro_id,
        type: "post",
        data: {
            pro_rate: pro_rate
        },
        success: function (result) {
            if (result == "1") {
                $("#modal-thanks-rating").modal("show");
            }
            else {
                alert("You can't Voting " + result);
            }
        },
        error: function (e) {
            alert(e);
        }
    })
}