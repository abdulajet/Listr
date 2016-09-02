<?php

/**
 * Description of GroupListManagement
 *
 * @author testy
 */
include_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/dao/GroupListDAO.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/model/GroupList.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/dao/Listr_ListDAO.php");

class GroupListManagement {

    public static function actionList($groupId) {
        return GroupListDAO::findGroupList(array("group_id" => $groupId));
    }

    public static function actionListId($listId) {
        return GroupListDAO::findGroupList(array("list_id" => $listId));
    }

    public static function actionCreate() {

        if (isset($_POST['group_list_name']) && isset($_POST['group_id'])) {
            $list_name = $_POST['group_list_name'];
            $group_id = $_POST['group_id'];
            $create_item = 1;
            $delete_item = 1;
            $update_item = 1;
            $upload_att = 1;
            $download_att = 1;

            $groupList = new GroupList($group_id, $list_name, $create_item, $delete_item, $update_item, $upload_att, $download_att, $list_id = null);

            if (GroupListDAO::addGroupList($groupList)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function actionDelete() {

        if (isset($_POST['var'])) {
            $list_id = $_POST['var'];

            if (GroupListDAO::deleteList($list_id)) {
                return true;
            }
        }
    }
    
    

}
