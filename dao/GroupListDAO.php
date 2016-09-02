<?php

/**
 * Description of GroupListDAO
 *
 * @author testy
 */
class GroupListDAO {

    public static function addGroupList($groupList) {
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");

        $group_id = $groupList->getGroup_id();
        $list_name = $groupList->getList_name();
        $create_item = $groupList->getCreate_item();
        $delete_item = $groupList->getDelete_item();
        $update_item = $groupList->getUpdate_item();
        $upload_att = $groupList->getUpload_att();
        $download_att = $groupList->getDownload_att();

        try {
            $stmt = $dbh->prepare("INSERT INTO group_list (group_id, list_name, create_item, delete_item, update_item, upload_att, download_att) VALUES (?,?,?,?,?,?,?)");
            $stmt->execute(array($group_id, $list_name, $create_item, $delete_item, $update_item, $upload_att, $download_att));
$dbh = null;
            return true;
        } catch (Exception $e) {
            
        }
    }

    public static function findGroupList($constraints = array()) {
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");

        try {
            $dbColumns = array("list_id", "group_id", "list_name", "create_item", "delete_item", "update_item", "upload_att", "download_att");
            $query = "SELECT * FROM group_list ";
            if (count($constraints) > 0) {
                $query .= "WHERE ";
                foreach ($constraints as $column => $constraint) {
                    if (in_array($column, $dbColumns)) {
                        $query .= $column . " = ? AND ";
                    } else {
                        throw new Exception("invalid column name in code");
                    }
                }
                $query = substr($query, 0, -4);
            }

            $stmt = $dbh->prepare($query);
            $stmt->execute(array_values($constraints));
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (is_array($results) && !empty($results)) {
                foreach ($results as $groupListData) {
                    $resultGroupList[] = new GroupList($groupListData['group_id'], $groupListData['list_name'], $groupListData['create_item'], $groupListData['delete_item'], $groupListData['update_item'], $groupListData['upload_att'], $groupListData['download_att'], $groupListData['list_id']);
                }
                $dbh = null;
                return $resultGroupList;
            } else {
                $dbh = null;
                return false;
            }
        } catch (Exception $ex) {
            //error handling
        }
    }

    public static function updateGroupList($groupList = null) {
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");
        if (gettype($groupList) == "object") {

            $sql = "UPDATE group_list SET list_name=?, create_item=?, delete_item=?, update_item=?, upload_att=? , download_att=? WHERE list_id = ? AND group_id = ?";
            $stmt = $dbh->prepare($sql);

            $list_id = $groupList->getList_id();
            $group_id = $groupList->getGroup_id();
            $list_name = $groupList->getList_name();
            $create_item = $groupList->getCreate_item();
            $delete_item = $groupList->getDelete_item();
            $update_item = $groupList->getUpdate_item();
            $upload_att = $groupList->getUpload_att();
            $download_att = $groupList->getDownload_att();

            //$stmt->bind_param('siiiiiii', $list_name, $create_item, $delete_item, $update_item, $upload_att, $download_att, $list_id, $group_id);

            if ($stmt->execute(array($list_name, $create_item, $delete_item, $update_item, $upload_att, $download_att, $list_id, $group_id))) {
                $dbh = null;
                return true;
            } else {
                $dbh = null;
                return false;
            }
        }
    }

    public static function deleteList($list) {
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");
        try {
            $stmt = $dbh->prepare("DELETE FROM group_list WHERE list_id=?");
            $stmt_item = $dbh->prepare("DELETE FROM list_item WHERE list_id=?");




            if ($stmt->execute(array($list)) && $stmt_item->execute(array($list))) {
                $dbh = null;
                return true;
            }
        } catch (Exception $ex) {
            //error handling
        }
    }

}
