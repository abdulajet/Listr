<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/list/ListItemManagement.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/doctype_includes.php");

if (ListItemManagement::actionComeplete() == true) {
    ?>
    <script>

        $('<form action="/listr/items/index.php" method="POST">' +
                '<input type="hidden" name="var" value="' + <?php echo $_POST['list_id'] ?> + '">' +
                '</form>').submit();
    </script>
    <?php
} else {
    echo 'Error...';
}
    
    
    
    