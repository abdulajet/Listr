<?php

/**
 * Description of ListItemManagement
 *
 * @author testy
 */
include_once $_SERVER['DOCUMENT_ROOT'] . '/listr/includes/functions.php';
include_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/model/List_Item.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/dao/List_ItemDAO.php");

class ListItemManagement {

    public static function actionList($list_id) {
        return List_ItemDAO::findItem(array("list_id" => $list_id));
    }

    public static function actionItem($list_item_id) {
        return List_ItemDAO::findItem(array("list_item_id" => $list_item_id));
    }

    public static function actionCreate() {
        sec_session_start();
        if (isset($_POST['item_name']) && isset($_POST['item_details']) && isset($_POST['due_date']) && isset($_POST['current_date']) && isset($_POST['file']) && isset($_POST['list_id']) && isset($_POST['priority'])) {

            $item_name = $_POST['item_name'];
            $item_details = $_POST['item_details'];
            $due_date = $_POST['due_date'] . ' 00:00:00';
            $start_date = $_POST['current_date'];
            $file = $_POST['file'];
            $list_id = $_POST['list_id'];
            $status = 'incomplete';
            $list_item_id = '';
            $completion_date = '';
            $finished_by = '';
            $is_personal = 1;
            $creator_id = $_SESSION['user_id'];
            $priority = $_POST['priority'];

            if ($file != '') {
                $attachments = 1;
            } else {
                $attachments = 0;
            }

            $listItem = new List_Item($list_item_id, $list_id, $item_name, $item_details, $priority, $start_date, $due_date, $completion_date, $status, $finished_by, $is_personal, $attachments, $creator_id);

            if (List_ItemDAO::addItem($listItem)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function actionDelete() {
        if (isset($_POST['item_id'])) {

            $list_item_id = $_POST['item_id'];

            if (List_ItemDAO::deleteItem($list_item_id)) {
                return true;
            }
        }
    }

    public static function actionEdit() {
        if (isset($_POST['item_name']) && isset($_POST['item_details']) && isset($_POST['due_date']) && isset($_POST['file']) && isset($_POST['list_item_id']) && isset($_POST['priority'])) {

            $list_item_id = $_POST['list_item_id'];
            $item_name = $_POST['item_name'];
            $item_details = $_POST['item_details'];
            $due_date = $_POST['due_date'] . ' 00:00:00';
            $file = $_POST['file'];
            $priority = $_POST['priority'];

            if ($file != '') {
                $attachments = 1;
            } else {
                $attachments = 0;
            }

            $list_item = List_ItemDAO::findItem(array("list_item_id" => $list_item_id));

            if (is_array($list_item)) {
                foreach ($list_item as $list_item) {
                    $list_item->setItem_name($item_name);
                    $list_item->setItem_details($item_details);
                    $list_item->setDue_date($due_date);
                    $list_item->setAttachments($attachments);
                    $list_item->setPriority($priority);
                }
            }


            if (List_ItemDAO::updateItem($list_item)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function actionComeplete() {
        sec_session_start();
        if (isset($_POST['item_id'])) {
            $user_id = $_SESSION['user_id'];
            $list_item_id = $_POST['item_id'];
            $completion_date = date('Y-m-d H:i:s');
            $list_item = List_ItemDAO::findItem(array("list_item_id" => $list_item_id));

            if (is_array($list_item)) {
                foreach ($list_item as $list_item) {
                    $status = $list_item->getStatus();
                }
            }

            if ($status != 'completed') {
                $list_item->setStatus('completed');
                $list_item->setFinished_by($user_id);
                $list_item->setCompletion_date($completion_date);
            }

            if (List_ItemDAO::updateItem($list_item)) {
                return true;
            } else {
                return false;
            }
        }
    }

}
