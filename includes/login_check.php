<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/listr/includes/db_connect.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/listr/includes/functions.php';

sec_session_start();

if (login_check($dbh) == true) {
    $loggedIn = true;
}else{
    $loggedIn = false;
}
?>