<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/group/GroupManagement.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/doctype_includes.php");


if (GroupManagement::actionRemoveUser() == true) {
    echo 'Left group, redirecting...';
} else {
    echo 'Error leaving group, redirecting...';
}
?>

  <meta http-equiv="refresh" content="2;URL='http://localhost/listr/group/index.php'" />  
