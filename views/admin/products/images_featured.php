<div class="panel-heading">Hình Sản Phẩm</div>
<?php
if (count($this->images_featured) > 0) {
    ?>
    <div class="panel-body" style="height: 300px; overflow-y: scroll;">
        <?php
        foreach ($this->images_featured as $image) {
            ?>
            <img class="col-md-6" style="padding:5px;"
                 onclick="info_image(<?php echo $image['pro_id'] . "," . $image['img_id']; ?>);"
                 src="<?php echo $image['img_url']; ?>"/>
            <?php
        }
        ?>
    </div>
<?php } ?>
<div class="panel-body">
    <div class="col-md-9" style="padding-left: 0;">
        <input type="file" name="img_featured" id="img_featured" class="form-control">
    </div>
    <button type="button" id="btn-image-featured-upload" class="btn btn-success col-md-3"><i
            class="fa fa-upload"></i>&nbsp;UP
    </button>
</div>