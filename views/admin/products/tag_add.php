<div id="add-ptag-message" class="messages">
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Thêm Product Tag</h3>
    </div>
    <div class="panel-body">
        <form id="form-add-ptag" action="" method="post">
            <div class="form-group">
                <label for="input-name">Tên Tag (<span
                        style="color: red; font-weight: bold;">*</span>)</label>
                <input type="text" class="form-control" name="ptag_name" id="ptag_name"
                       placeholder="Tên products tag">
            </div>
            <div class="form-group">
                <label for="input-slug">Slug</label>
                <input type="text" class="form-control" name="ptag_slug" id="ptag_slug"
                       placeholder="Slug">
            </div>
            <div class="form-group">
                <label for="input-content">Nội dung</label>
                <div id="ptag_content"></div>
            </div>
            <div class="form-group">
                <label for="input-seo-title">SEO Title</label>
                <input type="text" class="form-control" id="ptag_seo_title" name="ptag_seo_title"
                       placeholder="SEO Title">
            </div>
            <div class="form-group">
                <label for="input-seo-description">SEO Description</label>
                <textarea class="form-control" id="ptag_seo_description" name="ptag_seo_description"
                          placeholder="SEO Description" rows="4"></textarea>
            </div>
            <div id="btn-group" class="form-group">
                <button id="btn-add-ptag" type="submit" class="btn btn-default">Thêm Tag
                </button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </div>
        </form>
    </div>
</div>