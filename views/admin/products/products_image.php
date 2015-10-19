<div class="panel panel-default">
    <div class="panel-body">
        <div class="form-group col-md-12" style="margin-bottom: 30px;">
            <img class="col-md-12" style="padding: 0; margin: 0;" src="<?php echo $this->image['img_url']; ?>"/>
        </div>
        <div class="form-group">
            <label for="news_seo_title" class="control-label">URL hình ảnh</label>

            <div>
                <input type="text" class="form-control" id="img_url" name="img_url"
                       placeholder="SEO Title" value="<?php echo $this->image['img_url']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="news_seo_title" class="control-label">Tên</label>

            <div>
                <input type="text" class="form-control" id="img_name" name="img_name"
                       placeholder="SEO Title" value="<?php echo $this->image['img_alt']; ?>">
            </div>
        </div>
        <div>
            <button id="btn-unset-image-featured" type="button"
                    class="btn btn-success"<?php if($this->image['featured'] == 0) echo ' style="display: none;"'?>>Hủy
                Featured
            </button>
            <button id="btn-set-image-featured" type="button"
                    class="btn btn-success"<?php if($this->image['featured'] == 1) echo ' style="display: none;"'?>>Đặt làm
                featured
            </button>

        </div>
    </div>
</div>