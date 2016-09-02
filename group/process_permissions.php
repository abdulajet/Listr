<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/group/GroupManagement.php");


if(GroupManagement::actionUpdatePermissions() == true){
    echo 'Changes saved';
}else{
    echo 'Error';
}