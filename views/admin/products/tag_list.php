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
        <tr<?php if($this->ptag_id_highlight != -1 && $this->ptag_id_highlight == $ptag['ptag_id']) echo " class='bg-color-3'";?>>
            <td><input class='ptag-check' type='checkbox' name='ptag_select' value='<?php echo $ptag['ptag_id'];?>' /></td>
            <td><?php echo $ptag['ptag_name']; ?>
                <p class='minimenu'>
                    <a class="btn_ptag_edit" href='#' onclick='ptag_edit(<?php echo $ptag['ptag_id']; ?>, this); return false;'>edit</a> -
                    <a href='#' onclick='ptag_delete(<?php echo $ptag['ptag_id'];?>, this); return false;'>delete</a></p>
            </td>
            <td><?php echo $ptag['ptag_slug']; ?></td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>