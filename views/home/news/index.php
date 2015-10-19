<?php include '/templates/home/template_start.php'; ?>
<?php include '/templates/home/page_header.php'; ?>
    <div class="page-wrapper white-section clearfix">
        <?php
        if (isset($this->breadcrumb)) {
            echo $this->breadcrumb->toString();
        }
        ?>

        <hr>

        <!-- START BUILDER -->

        <div class="row">
            <div id="content" class="col-md-9 col-sm-12">
                <?php
                if (isset($this->news) && count($this->news) > 0) {
                    foreach ($this->news as $news) {
                        $url = $this->url->getUrlBlogView($news['news_id'], $news['news_slug']);
                        $date = new DateTime($news['news_publish_date']);
                        ?>
                        <div class="blog-wrap">
                            <?php
                            if (isset($news['img_url']) && $news['img_url'] != null) {

                                ?>
                                <div class="blog-media">
                                    <a href="<?php echo $this->url->getUrlBlogView($news['news_id'], $news['news_slug']);?>"
                                       title=""><img src="<?php echo $news['img_url'];?>" alt=""
                                                                        class="img-responsive"></a>
                                </div>
                                <?php
                            }
                            else
                            {
                                ?>
                                <div class="blog-media">
                                    <a href="<?php echo $this->url->getUrlBlogView($news['news_id'], $news['news_slug']);?>"
                                       title=""><img src="http://placehold.it/500x300" alt=""
                                                     class="img-responsive"></a>
                                </div>
                                <?php
                            }
                            ?>
                            <!-- end blog media -->
                            <div class="post-date">
                                <span class="day"><?php echo $date->format("d")?></span>
                                <span class="month"><?php echo $date->format("M")?></span>
                            </div>
                            <!-- end post-date -->
                            <div class="post-content">
                                <h2><a href="<?php echo $url;?>">
                                        <?php echo $news['news_name'] ?></a></h2>

                                <p><?php echo $this->getShortText(strip_tags($news['news_content']), 500);?></p>

                                <div class="post-meta">
                                    <span><i class="fa fa-user"></i> <a href="#"><?php echo $news['user_name'];?></a> </span>
                                    <span><i class="fa fa-comments"></i> <a href="<?php echo $url;?>#comments">Comments</a></span>
                                </div>
                                <!-- end post-meta -->
                            </div>
                            <!-- post-content -->
                        </div><!-- end blog-wrapper -->
                        <?php
                    }
                }
                ?>
                <?php
                    if(isset($this->pagination))
                    {
                        echo $this->pagination->getHTML();
                    }
                ?>
            </div>
            <!-- end content -->

            <?php $this->render("home/sidebar");?>
            <!-- end sidebar -->

        </div>
        <!-- end row -->
    </div><!-- end white -->

    <?php $this->render("home/news/shop"); ?>

    <!-- PAGE Footer -->
<?php include '/templates/home/page_footer.php'; ?>

    <!-- Template core JavaScript's
    ================================================== -->
<?php include '/templates/home/template_script.php'; ?>

    <script src="/templates/home/js/jquery.fitvids.js"></script>
    <script>
        (function ($) {
            "use strict";
            /* ==============================================
             VIDEO FIX -->
             =============================================== */
            // Target your .container, .wrapper, .post, etc.
            $("body").fitVids();
        })(jQuery);
    </script>
<?php include '/templates/home/template_end.php'; ?>