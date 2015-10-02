<?php
function sortOptionSelectNType($data, $prot_id, $prefix = "", $remove_id = -1)
{
    $result = "";
    foreach ($data as $key => $item) {
        if($item['prot_id'] != $remove_id) {
            if ($item['prot_id'] == $prot_id) {
                $result .= '<option value="' . $item['prot_id'] . '" selected="selected">' . $prefix . " " . $item['prot_name'] . '</option>';
            } else {
                $result .= '<option value="' . $item['prot_id'] . '">' . $prefix . " " . $item['prot_name'] . '</option>';
            }
            if (isset($item['submenu']) && $item['submenu'] != null) {
                $result .= sortOptionSelectNType($item['submenu'], $prot_id, $prefix . "--", $remove_id);
            }
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
        <form id="form-update-prot" action="" method="post">
            <div class="form-group">
                <label for="input-name">Tên Category (<span
                        style="color: red; font-weight: bold;">*</span>)</label>
                <input type="prot_name" class="form-control" name="prot_name" id="prot_name"
                       placeholder="Tên category" value="<?php echo $this->prot['prot_name']; ?>">
            </div>
            <div class="form-group">
                <label for="input-slug">Slug</label>
                <input type="text" class="form-control" name="prot_slug" id="prot_slug"
                       placeholder="Slug" value="<?php echo $this->prot['prot_slug']; ?>">
            </div>
            <div class="form-group">
                <label for="input-content">Nội dung</label>

                <div id="prot_content"><?php echo $this->prot['prot_content']; ?></div>
            </div>
            <div class="form-group">
                <label for="input-slug">Parent Category</label>
                <select id="prot_parent_id" class="form-control">
                    <option value="">None</option>
                    <?php echo sortOptionSelectNType($this->prots, $this->prot['prot_parent_id'], "", $this->prot['prot_id']); ?>
                </select>
            </div>
            <div class="form-group">
                <label for="input-seo-title">SEO Title</label>
                <input type="text" class="form-control" id="prot_seo_title" name="prot_seo_title"
                       placeholder="SEO Title" value="<?php echo $this->prot['prot_seo_title']; ?>">
            </div>
            <div class="form-group">
                <label for="input-seo-description">SEO Description</label>
                                <textarea class="form-control" id="prot_seo_description" name="prot_seo_description"
                                          placeholder="SEO Description" rows="4"><?php echo $this->prot['prot_seo_description']; ?></textarea>
            </div>
            <div id="btn-group" class="form-group">
                <button id="btn-update-prot" type="submit" class="btn btn-default">Update</button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </div>
            <input type="hidden" id="prot_id" name="prot_id" value="<?php echo $this->prot['prot_id']; ?>">
        </form>
    </div>
</div>