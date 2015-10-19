<div class="panel-heading">Hình đại diện</div>
<?php
if (isset($this->image)) {
    ?>
    <div class="panel-body">
        <img class="col-md-12" src="<?php echo $this->image['img_url']; ?>"/>
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