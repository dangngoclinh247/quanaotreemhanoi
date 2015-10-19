<?php
if (count($this->images) > 0) {
    ?>
    <div id="panel-images" class="panel panel-default">
        <div class="panel-heading">Hình ảnh đã upload</div>
        <div class="panel-body" style="height: 300px; overflow-y: scroll;">
            <?php
            foreach ($this->images as $image) {
                ?>
                <img class="col-md-6" style="padding:5px;"
                     onclick="info_image(<?php echo $image['pro_id'] . "," . $image['img_id']; ?>);"
                     src="<?php echo $image['img_url']; ?>"/>
                <?php
            }
            ?>
        </div>
    </div>
<?php }