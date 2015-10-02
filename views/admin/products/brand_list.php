<table id="table-brand-list" class="table table-striped table-hover">
    <thead>
    <tr>
        <th><input id="brand-checkbox-all" type='checkbox' name='brand_select'></th>
        <th>Tên</th>
        <th>SEO Description</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($this->brands as $brand) {

        ?>
        <tr<?php if ($this->brand_id_highlight != -1 && $this->brand_id_highlight == $brand['brand_id']) echo " class='active_add_tran'"; ?>>
            <td><input class="brand_id" type="checkbox" name="brand_id" value="<?php echo $brand['brand_id']; ?>"/></td>
            <td><?php echo $brand['brand_name']; ?></td>
            <td><?php echo $brand['brand_seo_description']; ?></td>
            <td>
                <a class="btn btn-success btn-sm btn-brand-edit"
                   href="/admin.php?c=brand&m=edit&p=<?php echo $brand['brand_id']; ?>">
                    <i class="fa fa-pencil"></i></a>
                <a class="btn btn-danger btn-sm btn-brand-delete" href="/admin.php?c=brand&m=delete&p=<?php echo $brand['brand_id']; ?>">
                    <i class="fa fa-trash-o"></i></a>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>