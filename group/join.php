<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/group/GroupManagement.php");
$g = new GroupManagement();

if (count($_POST) >= 2) {
    
    ?>
    
   <?php if ($g::actionJoin() == true) : ?>
        
      <meta http-equiv="refresh" content="2;URL='http://localhost/listr/group/index.php'" />  
      
    <?php else : ?>
      
       <meta http-equiv="refresh" content="2;URL='http://localhost/listr/home.php'" />  
       
    <?php endif; ?>


<?php }