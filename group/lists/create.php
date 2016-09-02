<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/list/GroupListManagement.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/doctype_includes.php");

if (count($_POST) == 2) {

    if (GroupListManagement::actionCreate() == true) {
        echo 'List created, redirecting...';
        
    } else {
        echo 'Error creating list, redirecting...';
       
    }
    ?>

        <script>

            $('<form action="/listr/group/lists_index.php" method="POST">' +
                    '<input type="hidden" name="group_id" value="' + <?php echo $_POST['group_id'] ?> + '">' +
                    '</form>').submit();
        </script>


    <?php
}