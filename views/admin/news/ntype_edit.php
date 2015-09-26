<?php
$ntypes = \library\Func::sortNType($this->ntypes);
function sortOptionSelectNType($data, $ntype_id, $prefix = "")
{
    $result = "";
    foreach ($data as $key => $item) {
        if ($item['ntype_id'] == $ntype_id) {
            $result .= '<option value="' . $item['ntype_id'] . '" selected="selected">' . $prefix . " " . $item['ntype_name'] . '</option>';
        } else {
            $result .= '<option value="' . $item['ntype_id'] . '">' . $prefix . " " . $item['ntype_name'] . '</option>';
        }
        if (isset($item['submenu']) && $item['submenu'] != null) {
            $result .= sortOptionSelectNType($item['submenu'], $ntype_id, $prefix . "--");
        }
    }
    return $result;
}
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Sửa Category</h3>
    </div>
    <div class="panel-body">
        <div id="message-edit" class="message"></div>
        <form id="form-update-ntype" action="" method="post">
            <div class="form-group">
                <label for="input-name">Tên Category (<span
                        style="color: red; font-weight: bold;">*</span>)</label>
                <input type="ntype_name" class="form-control" name="ntype_name" id="ntype_name"
                       placeholder="Tên category" value="<?php echo $this->ntype['ntype_name']; ?>">
            </div>
            <div class="form-group">
                <label for="input-slug">Slug</label>
                <input type="text" class="form-control" name="ntype_slug" id="ntype_slug"
                       placeholder="Slug" value="<?php echo $this->ntype['ntype_slug']; ?>">
            </div>
            <div class="form-group">
                <label for="input-content">Nội dung</label>

                <div id="ntype_content"><?php echo $this->ntype['ntype_content']; ?></div>
            </div>
            <div class="form-group">
                <label for="input-slug">Parent Category</label>
                <select id="ntype_parent_id" class="form-control">
                    <option value="">None</option>
                    <?php echo sortOptionSelectNType($ntypes, $this->ntype['ntype_parent_id']); ?>
                </select>
            </div>
            <div class="form-group">
                <label for="input-seo-title">SEO Title</label>
                <input type="text" class="form-control" id="ntype_seo_title" name="ntype_seo_title"
                       placeholder="SEO Title">
            </div>
            <div class="form-group">
                <label for="input-seo-description">SEO Description</label>
                                <textarea class="form-control" id="ntype_seo_description" name="ntype_seo_description"
                                          placeholder="SEO Description" rows="4"></textarea>
            </div>
            <div id="btn-group" class="form-group">
                <button id="btn-update-ntype" type="submit" class="btn btn-default">Update</button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </div>
            <input type="hidden" id="ntype_id" name="ntype_id" value="<?php echo $this->ntype['ntype_id']; ?>">
        </form>
    </div>
</div>