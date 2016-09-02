<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/group/GroupManagement.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/login_check.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/doctype_includes.php");
?>
<title>Listr - Update Group</title>
</head>

<?php

if($loggedIn == true){
     require_once ( $_SERVER['DOCUMENT_ROOT'] . "/listr/includes/nav_bar.php");
     $groupID = $_POST['group_id'];
    ?>
    

 <body>
        <div class="container">
            <h1>Make changes to your group:</h1>

            <div>
                <h3>&nbsp Password:</h3>
                <div class="front-page-form">
                    <form id="password_form" class="login" name="password_form" action="../group/process_update.php" method="post" >
                        <div class="field">
                            <input type="password" class="form-control" id="current_pass" name="current_pass" placeholder="Current password">
                        </div>

                        <div class="field">
                            <input type="password" class="form-control" id="new_pass" name="new_pass" placeholder="New password">
                        </div>
                        <div class="field">
                            <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" placeholder="Confirm new password">
                        </div>
                        <div class="field">
                            <input type="hidden" id="group_id" name="group_id" value=<?php echo $groupID; ?>>
                        </div>
                        
                        <br>
                        <input type="button" class="btn btn-success" value="Save changes" onclick="return updatePass(
                                           document.getElementById('password_form'),
                                                document.getElementById('current_pass'),
                                                document.getElementById('new_pass'), 
                                                document.getElementById('confirm_new_password'));" />
                    </form>
                </div>
            </div>
        </div>
     
    <?php
}else{
    ?>
    <p class="returnLogBlue">
        <span >You are not authorized to access this page.</span> Please <a href="../index.php">login</a>.
    </p>
    <?php
}    
?>

 </body>
</html>

    
    
    
    
    
