<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/account/AccountManagement.php");

if (count($_POST) > 0) {
    
    if (AccountManagement::actionUpdate() == true) : 
        echo 'Update successful, redirecting... If you have changed your password please log back in';
        ?>
        
<!--      <meta http-equiv="refresh" content="3;URL='http://localhost/listr/account/index.php'" />  -->
      
    <?php else : 
        echo 'Error Updating, redirecting...  Please check your details';
        ?>
      
<!--       <meta http-equiv="refresh" content="3;URL='http://localhost/listr/account/update.php'" />  -->
       
    <?php endif; ?>


<?php }

