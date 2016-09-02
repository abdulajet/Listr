<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/list/ListItemManagement.php");

if(ListItemManagement::actionCreate()){
    echo 'item added';
}else{
    echo 'error';
}




