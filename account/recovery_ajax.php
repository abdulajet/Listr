<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/listr/includes/functions.php';
include_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/model/User.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/dao/UserDAO.php");
sec_session_start();

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $_SESSION['email'] = $email;
}

$user = UserDAO::findUser(array("email" => $email));
if (!empty($user)) {
    foreach ($user as $user) {
        $rQuestion = $user->getR_question();
    }
    echo $rQuestion;
}






