<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/list/ListManagement.php");

if (count($_POST) == 1) {

    if (ListManagement::actionDelete() == true) :
        echo 'List deleted, redirecting...';
        ?>

        <meta http-equiv="refresh" content="1;URL='http://localhost/listr/lists/index.php'" />  


    <?php else : 
        echo 'Error deleting list, redirecting...';
        ?>

        <meta http-equiv="refresh" content="1;URL='http://localhost/listr/lists/index.php'" />  

    <?php endif; ?>

<?php
}