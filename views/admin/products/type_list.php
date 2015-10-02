<?php
function genListNType($data, $prefix = "", $prot_id_highlight = -1)
{
    $result = "";
    foreach ($data as $item) {
        if ($prot_id_highlight != -1 && $prot_id_highlight == $item['prot_id']) {
            $tr = "<tr class='bg-color-3'>";
        } else {
            $tr = "<tr>";
        }
        if (isset($item['submenu']) && $item['submenu'] != null) {
            $result .= $tr . "
                                <td>&nbsp;</td>
                                <td>$prefix {$item['prot_name']}
                                <p class='minimenu'><a class='btn_ptag_edit' href='#' onclick='prot_edit({$item['prot_id']}, this); return false;'>edit</a></p>
                                </td>
                                <td>{$item['prot_slug']}</td>
                            </tr>";
            $result .= genListNType($item['submenu'], $prefix . "--", $prot_id_highlight);
        } else {
            $result .= $tr . "
                                <td><input class='prot-check' type='checkbox' name='prot_select' value='{$item['prot_id']}' /></td>
                                <td>$prefix {$item['prot_name']}
                                <p class='minimenu'><a class='btn_ptag_edit' href='#' onclick='prot_edit({$item['prot_id']}, this); return false;'>edit</a> -
                                <a href='#' onclick='prot_delete({$item['prot_id']}, this); return false;'>delete</a></p>
                                </td>
                                <td>{$item['prot_slug']}</td>
                            </tr>";
            $result .= genListNType($item['submenu'], $prefix . "--", $prot_id_highlight);
        }
    }
    return $result;
}

?>
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
            </tr>
            </thead>
            <tbody>
            <?php echo genListNType($this->prots, "", $this->prot_id_highlight); ?>
            </tbody>
        </table>
    </div>
    <!--END table list-->
</div>