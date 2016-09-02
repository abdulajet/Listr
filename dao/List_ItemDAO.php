<?php

/**
 * Description of Listr_List
 *
 * @author testy
 */
class List_ItemDAO {

    public static function addItem($listItem) {
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");


        $list_id = $listItem->getList_id();
        $item_name = $listItem->getItem_name();
        $item_details = $listItem->getItem_details();
        $priority = $listItem->getPriority();
        $start_date = $listItem->getStart_date();
        $due_date = $listItem->getDue_date();
        $completion_date = $listItem->getCompletion_date();
        $status = $listItem->getStatus();
        $finished_by = $listItem->getFinished_by();
        $is_personal = $listItem->getIs_personal();
        $attachments = $listItem->getAttachments();
        $creator_id = $listItem->getCreator_id();



        try {
            $stmt = $dbh->prepare("INSERT INTO list_item (list_id, item_name, item_details, priority, start_date, due_date, "
                    . "completion_date, status, finished_by, is_personal, attachments, creator_id)"
                    . " VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute(array($list_id, $item_name, $item_details, $priority, $start_date, $due_date, $completion_date, $status,
                $finished_by, $is_personal, $attachments, $creator_id));

            $dbh = null;
            return true;
        } catch (Exception $e) {
            //error handling stuff
        }
    }

    public static function findItem($constraints = array()) {
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");

        try {
            $dbColumns = array("list_item_id", "list_id", "item_name", "item_details", "priority", "start_date", "due_date", "completion_date",
                "status", "finished_by", "is_personal", "attachments", "creator_id");
            $query = "SELECT * FROM list_item ";
            if (count($constraints) > 0) {
                $query .= "WHERE ";
                foreach ($constraints as $column => $constraint) {
                    if (in_array($column, $dbColumns)) {
                        $query .= $column . " = ? AND ";
                    }
                }
                $query = substr($query, 0, -4);
            }

            $query .= "ORDER BY priority DESC";

            $stmt = $dbh->prepare($query);
            $stmt->execute(array_values($constraints));
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (is_array($results) && !empty($results)) {
                foreach ($results as $itemData) {
                    $resultItems[] = new List_Item($itemData['list_item_id'], $itemData['list_id'], $itemData['item_name'], $itemData['item_details'], $itemData['priority'], $itemData['start_date'], $itemData['due_date'], $itemData['completion_date'], $itemData['status'], $itemData['finished_by'], $itemData['is_personal'], $itemData['attachments'], $itemData['creator_id']);
                }

                if (!empty($resultItems)) {
                    $dbh = null;
                    return $resultItems;
                }
            } else {
                $dbh = null;
                return false;
            }
        } catch (Exception $ex) {
            //error handling
        }
    }

    public static function deleteItem($list_item_id) {
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");
        try {
            $stmt = $dbh->prepare("DELETE FROM list_item WHERE list_item_id=?");


            if ($stmt->execute(array($list_item_id))) {
                $dbh = null;
                return true;
            } else {
                $dbh = null;
                return false;
            }
        } catch (Exception $ex) {
            //error handling
        }
    }

    public static function updateItem($list_item = null) {
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");
        if (gettype($list_item) == "object") {
            $stmt = $dbh->prepare("UPDATE list_item SET item_name=?, item_details=?, priority=?, start_date=?, due_date=?, completion_date=?, "
                    . "status=?, finished_by=?, is_personal=?, attachments=? WHERE list_item_id = ?");
            if($stmt->execute(array($list_item->getItem_name(), $list_item->getItem_details(), $list_item->getPriority(),
                        $list_item->getStart_date(), $list_item->getDue_date(), $list_item->getCompletion_date(), $list_item->getStatus(),
                        $list_item->getFinished_by(), $list_item->getIs_personal(), $list_item->getAttachments(), $list_item->getList_item_id()))){
                $dbh = null;
                return true;
            }
        }
    }

}
