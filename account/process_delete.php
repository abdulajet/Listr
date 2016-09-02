<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/account/AccountManagement.php");

if (AccountManagement::actionDelete() == true) : 
    echo 'Farewell...';
    ?>
        
      <meta http-equiv="refresh" content="2;URL='http://localhost/listr/index.php'" />  
      
    <?php else : 
        echo 'Please leave all groups.';
        ?>
      
       <meta http-equiv="refresh" content="3;URL='http://localhost/listr/account/index.php'" />  
       
    <?php endif; ?>