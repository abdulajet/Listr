<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/list/GroupListItemManagement.php");

if(GroupListItemManagement::actionCreate()){
    echo 'item added';
}else{
    echo 'error';
}