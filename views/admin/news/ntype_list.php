<?php
$ntypes = \library\Func::sortNType($this->ntypes);
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
                                <td>$prefix {$item['ntype_name']}
                                <p class='minimenu'><a href='#' onclick='ntype_edit({$item['ntype_id']}, this); return false;'>edit</a></p>
                                </td>
                                <td>{$item['ntype_slug']}</td>
                            </tr>";
            $result .= genListNType($item['submenu'], $prefix . "--", $ntype_id_highlight);
        } else {
            $result .= $tr . "
                                <td><input class='ntype-check' type='checkbox' name='ntype_select' value='{$item['ntype_id']}' /></td>
                                <td>$prefix {$item['ntype_name']}
                                <p class='minimenu'><a href='#' onclick='ntype_edit({$item['ntype_id']}, this); return false;'>edit</a> -
                                <a href='#' onclick='ntype_delete({$item['ntype_id']}, this); return false;'>delete</a></p>
                                </td>
                                <td>{$item['ntype_slug']}</td>
                            </tr>";
            $result .= genListNType($item['submenu'], $prefix . "--", $ntype_id_highlight);
        }
    }
    return $result;
}

?>
<table id="ntype-list" class="table table-striped table-hover">
    <thead>
    <tr>
        <th><input id="ntype-checkbox-all" type='checkbox' name='ntype_select'></th>
        <th>Tên</th>
        <th>Slug</th>
    </tr>
    </thead>
    <tbody>
    <?php echo genListNType($ntypes, "", $this->ntype_id_highlight); ?>
    </tbody>
</table>