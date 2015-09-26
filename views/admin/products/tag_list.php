<table id="ptag-list" class="table table-striped table-hover">
    <thead>
    <tr>
        <th><input id="ptag-checkbox-all" type='checkbox' name='ptag_select'></th>
        <th>Tên</th>
        <th>Slug</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($this->ptags as $ptag) {
        ?>
        <tr>
            <td><input class='ntype-check' type='checkbox' name='ntype_select' value='<?php echo $ptag['ptag_id'];?>' /></td>
            <td><?php echo $ptag['ptag_name']; ?>
                <p class='minimenu'>
                    <a href='#' onclick='ntype_edit(<?php echo $ptag['ptag_id']; ?>, this); return false;'>edit</a> -
                    <a href='#' onclick='ntype_delete(<?php echo $ptag['ptag_id'];?>, this); return false;'>delete</a></p>
            </td>
            <td><?php echo $ptag['ptag_slug']; ?></td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>