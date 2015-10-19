</div>
<!-- end container -->
<svg id="clouds" class="hidden-xs" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="120"
     viewBox="0 0 85 100" preserveAspectRatio="none">
    <path d="M-5 100 Q 0 20 5 100 Z
            M0 100 Q 5 0 10 100
            M5 100 Q 10 30 15 100
            M10 100 Q 15 10 20 100
            M15 100 Q 20 30 25 100
            M20 100 Q 25 -10 30 100
            M25 100 Q 30 10 35 100
            M30 100 Q 35 30 40 100
            M35 100 Q 40 10 45 100
            M40 100 Q 45 50 50 100
            M45 100 Q 50 20 55 100
            M50 100 Q 55 40 60 100
            M55 100 Q 60 60 65 100
            M60 100 Q 65 50 70 100
            M65 100 Q 70 20 75 100
            M70 100 Q 75 45 80 100
            M75 100 Q 80 30 85 100
            M80 100 Q 85 20 90 100
            M85 100 Q 90 50 95 100
            M90 100 Q 95 25 100 100
            M95 100 Q 100 15 105 100 Z">
    </path>
</svg>

<div class="footer-bg text-center hidden-xs">
    <img src="/templates/home/images/footer.png" alt="" class="img-responsive">
</div>

<footer class="footer">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="widget">
                    <div class="widget-title">
                        <h4><?php echo $this->options['footer_payment_name'];?></h4>
                    </div><!-- end section-title -->
                    <?php echo $this->options['footer_payment'];?>
                </div><!-- end widget -->
            </div><!-- end col -->

            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="widget">
                    <div class="widget-title">
                        <h4>Mở cửa 24/7</h4>
                    </div><!-- end section-title -->

                    <div class="big-call">
                        <span><i class="fa fa-phone"></i> <?php echo $this->options['company_phone1'];?></span>
                        <span><i class="fa fa-fax"></i> <?php echo $this->options['company_phone2'];?></span>
                    </div>
                </div><!-- end widget -->
            </div><!-- end col -->
        </div><!-- end row -->

        <hr>

        <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="widget">
                    <div class="widget-title">
                        <h4><?php echo $this->options['footer_widget1_h4'];?></h4>
                    </div><!-- end section-title -->
                    <?php echo $this->options['footer_widget1'];?>
                </div><!-- end widget -->
            </div><!-- end col -->

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="widget">
                    <div class="widget-title">
                        <h4><?php echo $this->options['footer_widget2_h4'];?></h4>
                    </div><!-- end section-title -->
                    <?php echo $this->options['footer_widget2'];?>
                </div><!-- end widget -->
            </div><!-- end col -->

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="widget-title">
                    <h4><?php echo $this->options['footer_widget3_h4'];?></h4>
                </div><!-- end section-title -->
                <?php echo $this->options['footer_widget3'];?>
            </div><!-- end col -->

            <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="widget">
                    <div class="widget-title">
                        <h4><?php echo $this->options['footer_widget4_h4'];?></h4>
                    </div><!-- end section-title -->
                    <?php echo $this->options['footer_widget4'];?>
                </div><!-- end widget -->
            </div><!-- end col -->
        </div><!-- end row -->
    </div><!-- container -->
</footer>

<div class="copyrights text-center">
    <p><?php echo $this->options['website_footer'];?></p>
</div><!-- end copy -->

<div class="backtotop"><i class="fa fa-arrow-up"></i> </div>

</div><!-- end wrapper -->