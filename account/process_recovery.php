<?php
include_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/model/User.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/dao/UserDAO.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/doctype_includes.php");
include_once $_SERVER['DOCUMENT_ROOT'] . '/listr/includes/functions.php';
sec_session_start();

if (count($_POST) > 1) {
    //update password
    if (isset($_POST["p"]) && !empty($_POST["p"])) {

        $user = UserDAO::findUser(array("email" => $_SESSION['email']));
        $newPass = $_POST["p"];

        if (strlen($newPass) == 128) {
            if (is_array($user)) {
                foreach ($user as $user) {
                    $user->genSalt($newPass);
                }
            } else {
                echo 'No user';
            }
        }


        if (UserDAO::updateUser($user)) {
            //mail user
            echo 'Password has been changed, redirecting...';
            ?>
            <meta http-equiv="refresh" content="3;URL='http://localhost/listr/index.php'" /> 

            <?php
        } else {
            echo 'falied';
            ?>
            <meta http-equiv="refresh" content="3;URL='http://localhost/listr/account/recover.php'" /> 
            <?php
        }
    }
} else if (count($_POST) == 1) {


    if (isset($_POST['rAnswer'])) {
        $rAnswer = $_POST['rAnswer'];
    }

    $user = UserDAO::findUser(array("email" => $_SESSION['email']));

    if (is_array($user)) {
        foreach ($user as $user) {
            $db_password = $user->getPassword();
            $salt = $user->getSalt();
            $db_answer = $user->getR_answer();
        }
    } else {
        echo 'No user';
    }


    if ($rAnswer == $db_answer) {
        ?>

        <div class="container">
            <h1>Change your password:</h1>

            <div>
                <div class="front-page-form">
                    <form id="password_form_r" class="login" name="password_form_r" action="../account/process_recovery.php" method="post" >
                        <div class="field">
                            <input type="password" class="form-control" id="new_pass_r" name="new_pass_r" placeholder="New password">
                        </div>
                        <div class="field">
                            <input type="password" class="form-control" id="confirm_new_password_r" name="confirm_new_password_r" placeholder="Confirm new password">
                        </div>
                        <br>
                        <input type="button" class="btn btn-success" value="Save changes" onclick=" return recoverPass(
                                        document.getElementById('password_form_r'),
                                        document.getElementById('new_pass_r'),
                                        document.getElementById('confirm_new_password_r'));" />
                    </form>
                </div>
            </div>
        </div>

        <?php
    } else {
        echo 'wrong answer';
        
        ?>
            <meta http-equiv="refresh" content="1;URL='http://localhost/listr/account/recover.php'" /> 
        <?php
    }
}
