<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/list/GroupListItemManagement.php");

if (GroupListItemManagement::actionEdit() == true){
    echo 'Changes saved';
}else{
    echo 'error';
}
