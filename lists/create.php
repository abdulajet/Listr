<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/list/ListManagement.php");

if (count($_POST) == 1) {

    if (ListManagement::actionCreate() == true) :
        echo 'List created, redirecting...';
        ?>

        <meta http-equiv="refresh" content="1;URL='http://localhost/listr/lists/index.php'" />  


    <?php else : 
        echo 'Error creating list, redirecting...';
        ?>

        <meta http-equiv="refresh" content="1;URL='http://localhost/listr/home.php'" />  

    <?php endif; ?>

<?php
}