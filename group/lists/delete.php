<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/list/GroupListManagement.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/doctype_includes.php");

if (count($_POST) == 1) {

    if (GroupListManagement::actionDelete() == true) {
        echo 'List deleted, redirecting...';
    } else {
        echo 'Error deleting list, redirecting...';
    }
    ?>

    <script>

        $('<form action="/listr/group/lists_index.php" method="POST">' +
                '<input type="hidden" name="group_id" value="' + <?php echo $_POST['var'] ?> + '">' +
                '</form>').submit();
    </script>



    <?php
}