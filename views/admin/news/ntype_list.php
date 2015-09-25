<?php
$ntypes = \library\Func::sortNType($this->ntypes);
function genListNType($data, $prefix = "")
{
    $result = "";
    foreach ($data as $item) {
        if (isset($item['submenu']) && $item['submenu'] != null) {
            $result .= "<tr>
                                <td>&nbsp;</td>
                                <td>$prefix {$item['ntype_name']}
                                <p class='minimenu'><a href='/admin.php?c=news&m=ntype_edit&p={$item['ntype_id']}'>edit</a></p>
                                </td>
                                <td>{$item['ntype_slug']}</td>
                            </tr>";
            $result .= genListNType($item['submenu'], $prefix . "--");
        } else {
            $result .= "<tr>
                                <td><input type='checkbox' name='ntype_select' value='{$item['ntype_id']}' /></td>
                                <td>$prefix {$item['ntype_name']}
                                <p class='minimenu'><a href='/admin.php?c=news&m=ntype_edit&p={$item['ntype_id']}'>edit</a> - <a href='#' onclick='ntype_delete({$item['ntype_id']}); return false;'>delete</a></p>
                                </td>
                                <td>{$item['ntype_slug']}</td>
                            </tr>";
            $result .= genListNType($item['submenu'], $prefix . "--");
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
    <?php echo genListNType($ntypes); ?>
    </tbody>
</table>