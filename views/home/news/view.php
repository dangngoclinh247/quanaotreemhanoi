<?php include '/templates/home/template_start.php'; ?>
<?php include '/templates/home/page_header.php'; ?>
    <div class="page-wrapper white-section clearfix">
        <?php
        if (isset($this->breadcrumb)) {
            echo $this->breadcrumb->toString();
        }
        $date = new DateTime($this->news['news_publish_date']);
        ?>
        <hr>
        <!-- START BUILDER -->

        <div class="row">
            <div id="content" class="col-md-9 col-sm-12">
                <div id="singleblog" class="blog-wrap">
                    <div class="blog-media">
                        <a href="<?php echo $this->url->getUrlBlogView($this->news['news_id'], $this->news['news_slug']);?>" title="">
                            <img src="<?php echo $this->image['img_url'];?>" alt="<?php echo $this->image['img_alt'];?>"
                                                                 class="img-responsive"></a>
                    </div>
                    <!-- end blog media -->
                    <div class="post-date">
                        <span class="day"><?php echo $date->format("d")?></span>
                        <span class="month"><?php echo $date->format("M")?></span>
                    </div>
                    <!-- end post-date -->
                    <div class="post-content">
                        <h2><a href="<?php echo $this->url->getUrlBlogView($this->news['news_id'], $this->news['news_slug']);?>">
                                <?php echo $this->news['news_name'];?></a></h2>

                        <div class="post-meta">
                            <span><i class="fa fa-user"></i> <a href="#"><?php echo $this->user['user_name'];?></a> </span>
                            <span><i class="fa fa-tag"></i> <a href="#">Galleries</a></span>
                            <span><i class="fa fa-comments"></i> <a href="#">21 Comments</a></span>
                        </div>
                        <!-- end post-meta -->
                        <?php echo $this->news['news_content'];?>
                    </div>
                    <!-- post-content -->
                </div>
                <!-- end blog-wrapper -->

                <div class="comment-box">
                    <div class="page-title">
                        <h2>2 Comments</h2>
                    </div>

                    <hr>

                    <div class="comment-list-wrapper">
                        <div class="comment-list">
                            <div class="media">
                                <div class="pull-left relative">
                                    <img class="img-responsive img-circle" src="upload/comment_01.png" alt="">
                                </div>
                                <div class="pull-right relative">
                                    <a href="#" class="btn btn-primary btn-sm">Reply</a>
                                </div>
                                <div class="media-body">
                                    <h3>Amanda Fox</h3>
                                    <span>22.10.2015</span>

                                    <p>Lorem ipsum dolor sit amet isse potenti. Vesquam ante aliquet lacusemper
                                        elit. Cras neque nulla, convallis non commodo et, euismod nonsese. At vero.
                                        Lorem ipsum dolor sit amet isse potenti. Vesquam ante aliquet lacusemper
                                        elit. Cras neque nulla, convallis non commodo et, euismod nonsese..</p>
                                </div>
                                <!-- end media-body -->
                            </div>
                            <!-- end media -->
                            <div class="media reply-comment">
                                <div class="pull-left relative">
                                    <img class="img-responsive img-circle" src="upload/comment_02.png" alt="">
                                </div>
                                <div class="pull-right relative">
                                    <a href="#" class="btn btn-primary btn-sm">Reply</a>
                                </div>
                                <div class="media-body">
                                    <h3>Suzanna DOE</h3>
                                    <span>22.10.2015</span>

                                    <p>Lorem ipsum dolor sit amet isse potenti. Vesquam ante aliquet lacusemper
                                        elit. Cras neque nulla, convallis non commodo et, euismod nonsese. At vero.
                                        Lorem ipsum dolor sit amet isse potenti. Vesquam ante aliquet lacusemper
                                        elit. Cras neque nulla, convallis non commodo et, euismod nonsese Lorem
                                        ipsum dolor sit amet isse potenti. Vesquam ante aliquet lacusemper elit.
                                        Cras neque nulla, convallis non commodo et, euismod nonsese.</p>
                                </div>
                                <!-- end media-body -->
                            </div>
                            <!-- end media -->
                        </div>
                        <!-- end comment-list -->
                    </div>
                    <!-- end comment-list-wrapper -->

                    <div class="page-title">
                        <h2>Leave a Comment</h2>
                    </div>

                    <hr>

                    <div class="comment-form-wrap">
                        <form class="form-horizontal" role="form" method="post">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Name</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name"
                                           placeholder="First & Last Name" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label">Email</label>

                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="email" name="email"
                                           placeholder="example@domain.com" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="website" class="col-sm-2 control-label">Website</label>

                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="website" name="website"
                                           placeholder="www.yoursite.com" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="message" class="col-sm-2 control-label">Message</label>

                                <div class="col-sm-10">
                                    <textarea class="form-control" id="message" rows="4" name="message"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <input id="submit" name="submit" type="submit" value="Submit Comment"
                                           class="btn btn-primary">
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- end comment-form-wrap -->
                </div>
                <!-- end comment -->

                <br>


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