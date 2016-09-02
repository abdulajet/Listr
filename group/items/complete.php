<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/list/GroupListItemManagement.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/doctype_includes.php");

if (GroupListItemManagement::actionComeplete() == true) {
    ?>
    <script>

        $('<form action="/listr/group/items/index.php" method="POST">' +
                '<input type="hidden" name="var" value="' + <?php echo $_POST['list_id']; ?> + '">' +
                '<input type="hidden" name="group_id" value="' + <?php echo $_POST['group_id']; ?> + '">' +
                '</form>').submit();
    </script>
    <?php
} else {
    echo 'Error...';
}
