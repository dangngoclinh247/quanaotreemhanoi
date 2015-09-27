<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title pull-left">Sửa Category</h3>
        <button id="load-form-add" href="#" class="btn btn-default btn-sm pull-right clearfix">Thêm Tag</button>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <div id="message-edit" class="message"></div>
        <form id="form-update-ptag" action="" method="post">
            <div class="form-group">
                <label for="input-name">Tên Category (<span
                        style="color: red; font-weight: bold;">*</span>)</label>
                <input type="ptag_name" class="form-control" name="ptag_name" id="ptag_name"
                       placeholder="Tên category" value="<?php echo $this->ptag['ptag_name']; ?>">
            </div>
            <div class="form-group">
                <label for="input-slug">Slug</label>
                <input type="text" class="form-control" name="ptag_slug" id="ptag_slug"
                       placeholder="Slug" value="<?php echo $this->ptag['ptag_slug']; ?>">
            </div>
            <div class="form-group">
                <label for="input-content">Nội dung</label>

                <div id="ptag_content"><?php echo $this->ptag['ptag_content']; ?></div>
            </div>
            <div class="form-group">
                <label for="input-seo-title">SEO Title</label>
                <input type="text" class="form-control" id="ptag_seo_title" name="ptag_seo_title"
                       placeholder="SEO Title" value="<?php echo $this->ptag['ptag_seo_title']; ?>">
            </div>
            <div class="form-group">
                <label for="input-seo-description">SEO Description</label>
                <textarea class="form-control" id="ptag_seo_description" name="ptag_seo_description"
                          placeholder="SEO Description"
                          rows="4"><?php echo $this->ptag['ptag_seo_description']; ?></textarea>
            </div>
            <div id="btn-group" class="form-group">
                <button id="btn-update-ptag" type="submit" class="btn btn-default">Update</button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </div>
            <input type="hidden" id="ptag_id" name="ptag_id" value="<?php echo $this->ptag['ptag_id']; ?>">
        </form>
    </div>
</div>