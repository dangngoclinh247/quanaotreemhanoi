<?php
function getStringOptionNType($data, $prefix = "")
{
    $result = "";
    foreach ($data as $key => $item) {
        $result .= '<option value="' . $item['ntype_id'] . '">' . $prefix . " " . $item['ntype_name'] . '</option>';
        if (isset($item['submenu']) && $item['submenu'] != null) {
            $result .= getStringOptionNType($item['submenu'], $prefix . "--");
        }
    }
    return $result;
}

function genListNType($data, $prefix = "", $ntype_id_highlight = -1)
{
    $result = "";
    foreach ($data as $item) {
        if ($ntype_id_highlight != -1 && $ntype_id_highlight == $item['ntype_id']) {
            $tr = "<tr class='bg-color-3'>";
        } else {
            $tr = "<tr>";
        }
        if (isset($item['submenu']) && $item['submenu'] != null) {
            $result .= $tr . "
                                <td>&nbsp;</td>
                                <td>$prefix {$item['ntype_name']}</td>
                                <td>{$item['ntype_slug']}</td>
                                <td><a class='btn btn-sm btn-success'
                                   href='/admin.php?c=news_type&m=edit&p={$item['ntype_id']}'>
                                    <i class='fa fa-pencil'></i>
                                </a></td>
                            </tr>";
            $result .= genListNType($item['submenu'], $prefix . "--", $ntype_id_highlight);
        } else {
            $result .= $tr . "
                                <td><input class='ntype-check' type='checkbox' name='ntype_select' value='{$item['ntype_id']}' /></td>
                                <td>$prefix {$item['ntype_name']}</td>
                                <td>{$item['ntype_slug']}</td>
                                <td>
                                <a class='btn btn-sm btn-success'
                                   href='/admin.php?c=news_type&m=edit&p={$item['ntype_id']}'>
                                    <i class='fa fa-pencil'></i>
                                </a>
                                <a class='btn btn-sm btn-danger' href='#' onclick='del({$item['ntype_id']}, this); return false;'><i class='fa fa-trash-o'></i></a>
                                </td>
                            </tr>";
            $result .= genListNType($item['submenu'], $prefix . "--", $ntype_id_highlight);
        }
    }
    return $result;
}
function sortOptionSelectNType($data, $ntype, $prefix = "")
{
    $result = "";
    foreach ($data as $key => $item) {
        if ($item['ntype_id'] == $ntype['ntype_parent_id']) {
            $result .= '<option value="' . $item['ntype_id'] . '" selected="selected">' . $prefix . " " . $item['ntype_name'] . '</option>';
        } else {
            if($item['ntype_id'] != $ntype['ntype_id']) {
                $result .= '<option value="' . $item['ntype_id'] . '">' . $prefix . " " . $item['ntype_name'] . '</option>';
                if (isset($item['submenu']) && $item['submenu'] != null) {
                    $result .= sortOptionSelectNType($item['submenu'], $ntype_id, $prefix . "--");
                }
            }
        }
    }
    return $result;
}
?>
<?php include '/templates/admin/template_start.php'; ?>
<?php include '/templates/admin/page_head.php'; ?>

    <div id="ntype-wrapper" class="col-md-5 no-padding-left padding-right">
        <?php
        if (isset($this->message)) {
            echo $this->message->toString();
        }
        ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Update category</h3>
            </div>
            <div class="panel-body no-padding">
                <form id="form-ntype-update" action="" method="post">
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

                        <textarea id="ntype_content" name="ntype_content"><?php echo $this->ntype['ntype_content']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="input-slug">Parent Category</label>
                        <select id="ntype_parent_id" name="ntype_parent_id" class="form-control">
                            <option value="">None</option>
                            <?php echo sortOptionSelectNType($this->ntypes, $this->ntype); ?>
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
                        <button id="btn-ntype-update" name="btn_ntype_update" type="submit" class="btn btn-success">Update</button>
                    </div>
                    <input type="hidden" id="ntype_id" name="ntype_id" value="<?php echo $this->ntype['ntype_id']; ?>">
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7 no-padding">
        <div id="panel-ntype-list" class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Danh sách category Tin tức</h3>
            </div>
            <div class="panel-body">
                <form class="form-inline" action="/admin.php" method="get">
                    <input type="hidden" name="c" value="news_type"/>
                    <input type="hidden" name="m" value="search"/>

                    <div class="form-group input-group">
                        <div class="input-group-addon">Tìm Kiếm</div>
                        <input type="text" class="form-control" id="p" name="p" placeholder="Text search">
                    </div>
                    <button type="submit" class="btn btn-success">Search</button>
                </form>
                <table id="ntype-list" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th><input id="ntype-checkbox-all" type='checkbox' name='ntype_select'></th>
                        <th>Tên</th>
                        <th>Slug</th>
                        <th><i class="fa fa-bolt fa-2x"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php echo genListNType($this->ntypes); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php include '/templates/admin/page_footer.php'; ?>
<?php include '/templates/admin/template_script.php'; ?>

    <!-- Load javascript use on this page -->
    <script src="/templates/admin/js/plugins/validation/jquery.validate.min.js"></script>
    <script src="/templates/admin/js/summernote.min.js"></script>
    <script src="/templates/admin/js/pages/news_type.js"></script>
    <script src="/templates/admin/js/script.js"></script>
    <script>$(function () {
            readyNewsTypeEdit.init();
        })</script>


<?php include '/templates/admin/template_end.php'; ?>