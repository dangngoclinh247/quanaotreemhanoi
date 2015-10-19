<?php include '/templates/admin/template_start.php'; ?>
<?php include '/templates/admin/page_head.php'; ?>
<?php
function getStringOptionProt($data, $prefix = "")
{
    $result = "";
    foreach ($data as $item) {
        $result .= '<option value="' . $item['prot_id'] . '">' . $prefix . " " . $item['prot_name'] . '</option>';
        if (isset($item['submenu']) && $item['submenu'] != null) {
            $result .= getStringOptionProt($item['submenu'], $prefix . "--");
        }
    }
    return $result;
}

function genListNType($data, $prefix = "", $prot_id_highlight = -1)
{
    $result = "";
    foreach ($data as $item) {
        if (isset($prot_id_highlight) && $prot_id_highlight == $item['prot_id']) {
            $tr = "<tr class='bg-color-3'>";
        } else {
            $tr = "<tr>";
        }
        if (isset($item['submenu']) && $item['submenu'] != null) {
            $result .= $tr . "
                                <td>&nbsp;</td>
                                <td>$prefix {$item['prot_name']}</td>
                                <td>{$item['prot_slug']}</td>
                                <td>
                                    <a class='btn btn-sm btn-success' href='/admin.php?c=products_type&m=edit&p={$item['prot_id']}'>
                                        <i class=\"fa fa-pencil\"></i>
                                    </a>
                                </td>
                            </tr>";
            $result .= genListNType($item['submenu'], $prefix . "--", $prot_id_highlight);
        } else {
            $result .= $tr . "
                                <td><input class='prot-check' type='checkbox' name='prot_select' value='{$item['prot_id']}' /></td>
                                <td>$prefix {$item['prot_name']}</td>
                                <td>{$item['prot_slug']}</td>
                                <td>
                                <a class='btn btn-sm btn-success' href='/admin.php?c=products_type&m=edit&p={$item['prot_id']}'>
                                    <i class=\"fa fa-pencil\"></i>
                                </a>
                                <a class='btn btn-sm btn-danger' href='#' onclick='del({$item['prot_id']}, this);'>
                                    <i class=\"fa fa-trash-o\"></i>
                                </a>
                                </td>
                            </tr>";
            $result .= genListNType($item['submenu'], $prefix . "--", $prot_id_highlight);
        }
    }
    return $result;
}

?>
    <div id="products-type-wrapper" class="col-md-5 no-padding-left">
        <!--form add / edit-->
        <?php
        if (isset($this->message)) {
            echo $this->message->toString();
        }
        ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Thêm category</h3>
            </div>
            <div class="panel-body">
                <form id="form-add-type" action="" method="post">
                    <div class="form-group">
                        <label for="input-name">Tên Category (<span
                                style="color: red; font-weight: bold;">*</span>)</label>
                        <input type="prot_name" class="form-control" name="prot_name" id="prot_name"
                               placeholder="Tên category">
                    </div>
                    <div class="form-group">
                        <label for="input-slug">Slug</label>
                        <input type="text" class="form-control" name="prot_slug" id="prot_slug"
                               placeholder="Slug">
                    </div>
                    <div class="form-group">
                        <label for="input-content">Nội dung</label>

                        <textarea id="prot_content" name="prot_content"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="input-slug">Parent Category</label>
                        <select id="prot_parent_id" name="prot_parent_id" class="form-control">
                            <option value="">None</option>
                            <?php
                            echo getStringOptionProt($this->prots);
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="input-seo-title">SEO Title</label>
                        <input type="text" class="form-control" id="prot_seo_title" name="prot_seo_title"
                               placeholder="SEO Title">
                    </div>
                    <div class="form-group">
                        <label for="input-seo-description">SEO Description</label>
                                <textarea class="form-control" id="prot_seo_description" name="prot_seo_description"
                                          placeholder="SEO Description" rows="4"></textarea>
                    </div>
                    <div id="btn-group" class="form-group">
                        <button name="btn_products_type_add" type="submit" class="btn btn-success">Thêm Category
                        </button>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </div>
                </form>
            </div>
        </div>
        <!--END form add / edit-->
    </div>
    <div class="col-md-7 no-padding">
        <!--prot list-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Danh sách product tags</h3>
            </div>
            <!--table list-->
            <div class="panel-body">
                <table id="prot-list" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th><input id="prot-checkbox-all" type='checkbox' name='prot_select'></th>
                        <th>Tên</th>
                        <th>Slug</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php echo genListNType($this->prots); ?>
                    </tbody>
                </table>
            </div>
            <!--END table list-->
        </div>
        <!--END prot list-->
    </div>
<?php include '/templates/admin/page_footer.php'; ?>
<?php include '/templates/admin/template_script.php'; ?>

    <!-- Load javascript use on this page -->
    <script src="/templates/admin/js/plugins/validation/jquery.validate.min.js"></script>
    <script src="/templates/admin/js/summernote.min.js"></script>
    <script src="/templates/admin/js/script.js"></script>
    <script src="/templates/admin/js/pages/products_type.js"></script>
    <script>$(function () {readyProductsType.init();})</script>
<?php include '/templates/admin/template_end.php'; ?>