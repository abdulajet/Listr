<?php

/**
 * Description of AccountManagement
 *
 * @author testy
 */
require_once ( $_SERVER['DOCUMENT_ROOT'] . "/listr/includes/functions.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/model/User.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/dao/UserDAO.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/dao/Listr_ListDAO.php");

class AccountManagement {

    public static function actionIndex() {
        return UserDAO::findUser(array("user_id" => $_SESSION['user_id']));
    }

    public static function actionCreate() {


        //make var

        $username = $_POST['username'];
        $password = $_POST['p'];
        $email = $_POST['email'];
        $r_question = $_POST['rQuestion'];
        $r_answer = $_POST['rAnswer'];
        $salt = "";

        if (AccountManagement::validateUserName($username, $email) && AccountManagement::validatePassword($password) && AccountManagement::validateEmail($email)) {

            $userC = new User($username, $password, $salt, $email, $r_question, $r_answer, $user_id = null);


            if (UserDAO::addUser($userC)) {
                echo 'inserted';
                //mailUser($email, $username);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function actionUpdate() {
        sec_session_start();
        $user_id = $_SESSION['user_id'];
        $user = UserDAO::findUser(array("user_id" => $user_id));
        
        if (is_array($user)) {
            foreach ($user as $user) {
                $db_password = $user->getPassword();
                $salt = $user->getSalt();
                $email = $user->getEmail();
                $rA = $user->getR_answer();
            }
        } else {
            echo 'No user';
        }


        //recovery
        if (isset($_POST["current_answer"]) && !empty("current_answer") && isset($_POST["new_question"]) && !empty("new_question") && isset($_POST["new_answer"]) && !empty("new_answer")) {

            $oldAns = $_POST['current_answer'];
            $newQ = $_POST['new_question'];
            $newA = $_POST['new_answer'];

            if ($rA == $oldAns) {
                $user->setR_question($newQ);
                $user->setR_answer($newA);
            } else {
                return false;
            }
        } 

        //email
        if (isset($_POST["current_email"]) && !empty($_POST["current_email"]) && isset($_POST["new_email"]) && !empty($_POST["new_email"])) {

            $oldEmail = $_POST["current_email"];
            $newEmail = $_POST["new_email"];

            if (AccountManagement::validateEmail($newEmail)) {
                if ($email == $oldEmail) {
                    $user->setEmail($newEmail);
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        //password
        if (isset($_POST["p_current"]) && !empty($_POST["p_current"]) && isset($_POST["p_new"]) && !empty($_POST["p_new"])) {

            $oldPass = $_POST["p_current"];
            $newPass = $_POST["p_new"];

            if (AccountManagement::validatePassword($oldPass) && AccountManagement::validatePassword($newPass)) {
                $oldPass = hash('sha512', $oldPass . $salt);

                if ($db_password == $oldPass) {
                    $user->genSalt($newPass);
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }


        if (UserDAO::updateUser($user)) {
            //success mail user
            return true;
        } else {
            return false;
        }
    }

    public static function actionDelete() {
        //delete account
        sec_session_start();
        $user_id = $_SESSION['user_id'];

        if ($user_id != '' && AccountManagement::clearDelete($user_id)) {
            if (UserDAO::deleteUser($user_id)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function actionLogin() {
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");
        if (isset($_POST['email'], $_POST['p'])) {
            $email = $_POST['email'];
            $password = $_POST['p'];

            return login($email, $password, $dbh) == true;
        } else {
            // The correct POST variables were not sent to this page. 
            return false;
        }
    }
    
    
    public static function actionRecover($email){
        
        $user = UserDAO::findUser(array("email" => $email));
        
        if (is_array($user)) {
            foreach ($user as $user) {
                $rQ = $user->getR_question();
                $rA = $user->getR_answer();
            }
        } else {
            echo 'No user';
        }
    }
    
    public static function actionStats(){
        
        $lists = Listr_ListDAO::findList(array("user_id" => $_SESSION['user_id']));
        
        if(!empty($lists)){
        $count = count($lists);
        }else{
            $count = 0;
        }
        return $count;
    }
    
    
    
    
    
    

    //validation
    public static function clearDelete($user_id) {
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");

        $prep_stmt = "SELECT group_id FROM `group` WHERE creator_id = ?";
        $stmt = $dbh->prepare($prep_stmt);

        if ($stmt) {
            //$stmt->bind_param('i', $user_id);
            $stmt->execute(array($user_id));
            $stmt->fetchAll();

            if ($stmt->rowCount() >= 1) {
                // Ahas not left group where admin
                $dbh = null;
                return false;
            } else {
                return true;
            }
        } else {
            $dbh = null;
            return false;
        }
    }

    public static function validateUserName($username, $email) {
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");

        $prep_stmt = "SELECT user_id FROM user WHERE username = ?  OR email = ? LIMIT 1";
        $stmt = $dbh->prepare($prep_stmt);

        if ($stmt) {
            //$stmt->bind_param('ss', $username, $email);
            $stmt->execute(array($username, $email));
            $stmt->fetchAll();

            if ($stmt->rowCount() >= 1) {
                // A user with this username already exists
                $dbh = null;
                return false;
            } else {
                return true;
            }
        } else {
            $dbh = null;
            return false;
        }
    }

    public static function validatePassword($password) {

        if (strlen($password) != 128) {
            return false;
        } else {
            return true;
        }
    }

    public static function validateEmail($email) {

        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Not a valid email
            return false;
        } else {

            // check existing email  
            $prep_stmt = "SELECT user_id FROM user WHERE email = ? LIMIT 1";
            $stmt = $dbh->prepare($prep_stmt);
            if ($stmt) {
                //$stmt->bind_param('s', $email);
                $stmt->execute(array($email));
                $stmt->fetchAll();

                if ($stmt->rowCount() == 1) {
                    // A user with this email address already exists
                    $dbh = null;
                    return false;
                } else {
                    $dbh = null;
                    return true;
                }
            } else {
                $dbh = null;
                return false;
            }
        }
    }

}
