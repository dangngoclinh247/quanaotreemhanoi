<?php
if (count($this->images) > 0) {
    ?>
    <div id="news-panel-images" class="panel panel-default">
        <div class="panel-heading">Hình ảnh đã upload</div>
        <div class="panel-body">
            <?php
            if (count($this->images) > 0) {
                foreach ($this->images as $image) {
                    ?>

                        <img  class="col-md-6" style="padding: 5px; margin: 0" onclick="info_image(<?php echo $image['news_id'];?>, <?php echo $image['img_id'];?>);"
                             src="<?php echo $image['img_url']; ?>"/>

                    <?php
                }
            }
            ?>
        </div>
    </div>
    <div id="modal-images" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

            </div>
        </div>
    </div>
    <?php
}