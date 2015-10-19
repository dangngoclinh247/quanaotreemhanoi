<?php include '/templates/admin/template_start.php'; ?>
<?php include '/templates/admin/page_head.php'; ?>
<?php
function getElement($form, $options)
{
    $result = "";
    $value = "";
    if(isset($options[$form['option_name']]))
    {
        $value = $options[$form['option_name']];
    }
    if ($form['type'] == "input") {
        $result .= "<label for=\"{$form['option_name']}\" class=\"col-sm-3 control-label\">{$form['name']}</label>";
        $result .= "<div class=\"col-sm-9\">";
        $result .= "<input type=\"text\" class=\"form-control\" name=\"{$form['option_name']}\" placeholder=\"{$form['name']}\" value='{$value}'>";
        $result .= "</div>";
    } else if ($form['type'] == "textarea") {
        $result .= "<label for=\"{$form['option_name']}\" class=\"col-sm-3 control-label\">{$form['name']}</label>";
        $result .= "<div class=\"col-sm-9\">";
        $result .= "<textarea class=\"form-control\" rows='{$form['size']}' name=\"{$form['option_name']}\" placeholder=\"{$form['name']}\">{$value}</textarea>";
        $result .= "</div>";
    }
    return $result;
}

?>
<?php
if(isset($this->message))
{
    echo $this->message->toString();
}
?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Thiết Lập Website</h3>
        </div>
        <div class="panel-body">
            <!--form add users-->
            <form class="form-horizontal" action="" method="post">
                <?php
                if (isset($this->form)) {
                    foreach ($this->form as $form) {
                        ?>
                        <div class="form-group">
                            <?php echo getElement($form, $this->options); ?>
                        </div>
                        <?php
                    }
                }
                ?>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" name="save" class="btn btn-success">Lưu</button>
                    </div>
                </div>
            </form>
            <!--#end form-->
        </div>
    </div>

<?php include '/templates/admin/page_footer.php'; ?>
<?php include '/templates/admin/template_script.php'; ?>

    <!-- Load javascript use on this page -->
    <script src="/templates/admin/js/plugins/validation/jquery.validate.min.js"></script>
    <script src="/templates/admin/js/script.js"></script>
    <script src="/templates/admin/js/pages/users.js"></script>
    <script>$(function () {
            readyUserAdd.init();
        })</script>


<?php include '/templates/admin/template_end.php'; ?>