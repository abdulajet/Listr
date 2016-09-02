<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/group/GroupManagement.php");


if (isset($_POST['group_id'])) {
    $group_id = $_POST['group_id'];

    if (GroupManagement::actionDelete($group_id) == true) {
        echo 'Group deleted, redirecting...';
    } else {
        echo 'Error deleting group, redirecting...';
    }
    ?>
    
        <meta http-equiv="refresh" content="1;URL='http://localhost/listr/group/index.php'" />  


    <?php
}

