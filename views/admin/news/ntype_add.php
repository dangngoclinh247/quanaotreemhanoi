<?php
$ntypes = \library\Func::sortNType($this->ntypes);
function getStringOptionNType($data, $prefix = "")
{
    $result = "";
    foreach($data as $key => $item)
    {
        $result .= '<option value="' . $item['ntype_id'] . '">' . $prefix . " " . $item['ntype_name'] . '</option>';
        if(isset($item['submenu']) && $item['submenu'] != null)
        {
            $result .= getStringOptionNType($item['submenu'], $prefix . "--");
        }
    }
    return $result;
}
?>
<div id="add-ntype-message" class="messages">
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Thêm category</h3>
    </div>
    <div class="panel-body">
        <form id="form-add-ntype" action="" method="post">
            <div class="form-group">
                <label for="input-name">Tên Category (<span
                        style="color: red; font-weight: bold;">*</span>)</label>
                <input type="ntype_name" class="form-control" name="ntype_name" id="ntype_name"
                       placeholder="Tên category">
            </div>
            <div class="form-group">
                <label for="input-slug">Slug</label>
                <input type="text" class="form-control" name="ntype_slug" id="ntype_slug"
                       placeholder="Slug">
            </div>
            <div class="form-group">
                <label for="input-content">Slug</label>

                <div id="ntype_content"></div>
            </div>
            <div class="form-group">
                <label for="input-slug">Parent Category</label>
                <select id="ntype_parent_id" class="form-control">
                    <option value="">None</option>
                    <?php echo getStringOptionNType($ntypes, ""); ?>
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
                <button id="btn-add-ntype" type="submit" class="btn btn-default">Thêm Category
                </button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </div>
        </form>
    </div>
</div>
