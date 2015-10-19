<?php include '/templates/home/template_start.php'; ?>
<?php include '/templates/home/page_header.php'; ?>
        <div class="page-wrapper white-section clearfix">
            <!-- Breadcrumb -->
            <?php
                if(isset($this->breadcrumb))
                {
                    echo $this->breadcrumb->toString();
                }
            ?>
            <!-- END Breadcrumb -->
            <hr>

            <!-- START BUILDER -->
            <div id="single-shop" class="row">
                <div class="col-lg-12">

                    <div class="contact_list clearfix">
                        <div class="col-sm-4 wow fadeInUp">
                            <h6><?php echo $this->options['company_name_short'];?></h6>
                            <ul>
                                <li><i class="fa fa-map-marker"></i> <?php echo $this->options['company_address'];?></li>
                                <li><i class="fa fa-envelope-square"></i> <?php echo $this->options['company_email'];?></li>
                                <li><i class="fa fa-phone"></i> <?php echo $this->options['company_phone1'];?></li>
                                <li><i class="fa fa-fax"></i> <?php echo $this->options['company_phone2'];?></li>
                            </ul>
                        </div>

                        <div class="col-sm-8 wow fadeInUp">
                            <div class="contact_form row wow fadeIn">
                                <div id="message"></div>
                                <form id="contactform" class="row" action="contact.php" name="contactform"
                                      method="post">
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <input type="text" name="name" id="name" class="form-control"
                                               placeholder="Tên">
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <input type="text" name="email" id="email" class="form-control"
                                               placeholder="Email">
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <input type="text" name="name" id="phone" class="form-control"
                                               placeholder="Số điện thoại">
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <textarea class="form-control" name="comments" id="comments" rows="6"
                                                  placeholder="Nội dung"></textarea>

                                        <div class="text-right">
                                            <button type="submit" value="SEND" id="submit" class="btn btn-primary"><i
                                                    class="fa fa-paper-plane-o"></i> SEND MAIL
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- end contactlist -->
                    <hr>
                    <div id="map" class="wow slideInUp"></div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end white -->

    <!-- PAGE Footer -->
    <?php include '/templates/home/page_footer.php'; ?>

    <!-- Template core JavaScript's
    ================================================== -->
    <?php include '/templates/home/template_script.php'; ?>

    <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script src="/templates/home/js/contact.js"></script>
    <script type="text/javascript">
        (function ($) {
            "use strict";
            /* ==============================================
             MAP -->
             =============================================== */
            var locations = [
                ['<div class="infobox"><h3 class="title"><a href="/contact.html"><?php echo $this->options['company_name_short'];?></a></h3><span><?php echo $this->options['company_address'];?></span><br><?php echo $this->options['company_phone1'];?></p></div></div></div>', 10.8399837, 106.5946273, 2]
            ];

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13,
                scrollwheel: false,
                navigationControl: true,
                mapTypeControl: false,
                scaleControl: false,
                draggable: true,
                center: new google.maps.LatLng(10.8399837, 106.5946273),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var infowindow = new google.maps.InfoWindow();

            var marker, i;

            for (i = 0; i < locations.length; i++) {

                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map,
                    icon: '/templates/home/images/marker.png'
                });


                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        infowindow.setContent(locations[i][0]);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            }
        })(jQuery);
    </script>
<?php include '/templates/home/template_end.php'; ?>