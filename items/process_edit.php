<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/list/ListItemManagement.php");

if (ListItemManagement::actionEdit() == true){
    echo 'Changes saved';
}else{
    echo 'error';
}