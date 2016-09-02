<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/group/GroupManagement.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/doctype_includes.php");

if (count($_POST) > 0) {

    if (GroupManagement::actionUpdate() == true) {
        echo 'Update successful, redirecting...';
    } else {
        echo 'Error Updating, redirecting...';
    }
    ?>

    <script>

        $('<form action="/listr/group/admin.php" method="POST">' +
                '<input type="hidden" name="group_id" value="' + <?php echo $_POST['group_id'] ?> + '">' +
                '</form>').submit();
    </script>


<?php
}