<?php

/**
 * Description of List_ItemDAO
 *
 * @author testy
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/listr/includes/psl-config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/listr/model/Listr_list.php';

class Listr_ListDAO {

    public static function addList($list_name, $user_id) {
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");
        try {
            $stmt = $dbh->prepare("INSERT INTO list (list_name, user_id) VALUES (?,?)");
            $stmt->execute(array($list_name, $user_id));
            $list_id = $dbh->lastInsertId();
            $dbh = null;
            $list = Listr_ListDAO::findList(array("list_id" => $list_id));
            return $list;
        } catch (Exception $e) {
            //error handling stuff
        }
    }

    public static function findList($constraints = array()) {
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");

        try {
            $dbColumns = array("list_id", "list_name", "user_id");
            $query = "SELECT * FROM list ";
            if (count($constraints) > 0) {
                $query .= "WHERE ";
                foreach ($constraints as $column => $constraint) {
                    if (in_array($column, $dbColumns)) {
                        $query .= $column . " = ? AND ";
                    }
                }
                $query = substr($query, 0, -4);
            }

            $stmt = $dbh->prepare($query);
            $stmt->execute(array_values($constraints));
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (is_array($results) && !empty($results)) {
                foreach ($results as $listData) {
                    $resultLists[] = new Listr_List($listData['list_id'], $listData['list_name'], $listData['user_id']);
                }

                if (!empty($resultLists)) {
                    $dbh = null;
                    return $resultLists;
                } 
                
            } else {
                $dbh = null;
                return false;
            }
        } catch (Exception $ex) {
            //error handling
        }
    }

    public static function deleteList($list) {
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");
        try {
            $stmt = $dbh->prepare("DELETE FROM list WHERE list_id=?");
            $stmt_item = $dbh->prepare("DELETE FROM list_item WHERE list_id=?");
            
            
            
            
            if($stmt->execute(array($list)) && $stmt_item->execute(array($list))){
                $dbh = null;
                return true;
            }
        } catch (Exception $ex) {
            //error handling
        }
    }

    public static function updateList($list = null) {
        if (gettype($list) == "object") {
            $stmt = $dbh->prepare("UPDATE user SET list_id=?, list_name=?, user_id=?");
           if($stmt->execute(array($list->getList(), $list->getList_name(), $list->getUser_id()))){
               $dbh = null;
               return true;
           }
        }
    }

}
