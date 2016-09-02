<?php

/**
 * Description of ListManagement
 *
 * @author testy
 */
include_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/functions.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/dao/Listr_ListDAO.php");

class ListManagement {

    public static function actionList() {
       return Listr_ListDAO::findList(array("user_id" => $_SESSION['user_id']));

    }

    public static function actionCreate() {
        sec_session_start();
        $user_id = $_SESSION['user_id'];
        
        if(isset($_POST['list_name'])){
            $list_name = $_POST['list_name'];
            
            
            if(Listr_ListDAO::addList($list_name, $user_id)){
                return true;
            }else{
                return false;
            }
        }
        
    }
    
    public static function actionDelete(){
        
        if(isset($_POST['var'])){
            $list_id = $_POST['var'];
        }
        
        if(Listr_ListDAO::deleteList($list_id)){
            return true;
        }
        
    }

}
