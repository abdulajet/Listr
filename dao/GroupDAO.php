<?php

/**
 * Description of GroupDAO
 *
 * @author testy
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/listr/includes/psl-config.php';

class GroupDAO {

    public static function createGroup($groupC) {
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");


        try {
            $sql = "INSERT INTO `group` (group_name, group_password, group_salt, creator_id) VALUES (?, ?, ?, ?)";
            $stmt = $dbh->prepare($sql);

            $group_name = $groupC->getGroupName();
            $group_password = $groupC->getGroupPassword();
            $group_salt = $groupC->getGroupSalt();
            $creator_id = $groupC->getCreatorId();


            //$stmt->bind_param('sssi', $group_name, $group_password, $group_salt, $creator_id);
            $stmt->execute(array($group_name, $group_password, $group_salt, $creator_id));

            $group_id = $dbh->lastInsertId();

            $groupC->setGroupId($group_id);
            $group = GroupDAO::findGroup(array("group_id" => $group_id));


// add admin to group_user relation table

            $sql2 = "INSERT INTO group_user (user_id, group_id, invite, remove, create_list, delete_list) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt2 = $dbh->prepare($sql2);

            $user_id = $groupC->getCreatorId();
            $group_id = $groupC->getGroupId();
            $invite = 1;
            $remove = 1;
            $create_list = 1;
            $delete_list = 1;

            //$stmt2->bind_param('iiiiii', $user_id, $group_id, $invite, $remove, $create_list, $delete_list);
            $stmt2->execute(array($user_id, $group_id, $invite, $remove, $create_list, $delete_list));
            
            $dbh = null;
            return $group;
        } catch (Exception $e) {
//error handling stuff
        }
    }

    public static function joinGroup($groupName, $groupPassword, $userId) {
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");



        $sql = "SELECT group_id, group_password, group_salt FROM `group` WHERE group_name = ? LIMIT 1";
        $stmt = $dbh->prepare($sql);

        //$stmt->bind_param('s', $groupName);
        $stmt->execute(array($groupName));

        $result = $stmt->fetch();
        
        $groupId = $result['group_id'];
        $db_password = $result['group_password'];
        $salt = $result['group_salt'];

        $groupPassword = hash('sha512', $groupPassword . $salt);

        if ($db_password == $groupPassword) {

            //check if already in group
            $check_stmt = $dbh->prepare("SELECT group_id FROM group_user WHERE user_id = :user_id");
            $check_stmt->bindParam(":user_id", $userId);
            $check_stmt->execute();
            $results = $check_stmt->fetchAll();

            if (is_array($results)) {
                if (count($results) > 1) {
                    return false;
                }
            }


            $sql2 = "INSERT INTO group_user (user_id, group_id, invite, remove, create_list, delete_list) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt2 = $dbh->prepare($sql2);
            $invite = 1;
            $remove = 0;
            $create_list = 1;
            $delete_list = 1;

            //$stmt2->bind_param('iiiiii', $userId, $groupId, $invite, $remove, $create_list, $delete_list);
            $stmt2->execute(array($userId, $groupId, $invite, $remove, $create_list, $delete_list));

            $dbh = null;
            return true;
        } else {
            $dbh = null;
            return false;
        }
    }

    public static function findGroup($constraints = array()) {
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");

        try {
            $dbColumns = array("group_id", "group_name", "group_password", "group_salt", "creator_id");
            $query = "SELECT * FROM `group`";
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
                foreach ($results as $groupData) {
                    $resultGroups[] = new Group($groupData['group_name'], $groupData['group_password'], $groupData['group_salt'], $groupData['creator_id'], $groupData['group_id']);
                }
                $dbh = null;
                return $resultGroups;
            } else {
                $dbh = null;
                return false;
            }
        } catch (Exception $ex) {
//error handling
        }
    }

    public static function findGroupUsers($constraints = array()) {
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");


        try {
            $dbColumns = array("group_user.user_id", "group_user.group_id", "group_user.invite", "group_user.remove", "group_user.create_list", "group_user.delete_list");
            $query = "SELECT * FROM `group_user` INNER JOIN `group` ON group_user.group_id=group.group_id ";
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

            if (!empty($results) && !empty($results)) {
                foreach ($results as $groupData) {
                    $group = new Group($groupData['group_name'], $groupData['group_password'], $groupData['group_salt'], $groupData['creator_id'], $groupData['group_id']);
                    $resultGroups[] = new GroupUser($groupData['user_id'], $groupData['group_id'], $groupData['invite'], $groupData['remove'], $groupData['create_list'], $groupData['delete_list'], $group);
                }
                $dbh = null;
                return $resultGroups;
            } else {
                $dbh = null;
                return false;
            }
        } catch (Exception $ex) {
//error handling
        }
    }

    public static function deleteGroup($group_id) {
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");
        try {

            $stmt = $dbh->prepare("DELETE FROM `group` WHERE group_id=?");
            //$stmt->bind_param('i', $group_id);

            $stmt_list = $dbh->prepare("DELETE FROM group_list WHERE group_id=?");
            //$stmt_list->bind_param('i', $group_id);

            $stmt_user = $dbh->prepare("DELETE FROM group_user WHERE group_id=?");
            //$stmt_user->bind_param('i', $group_id);



            if ($stmt->execute(array($group_id)) && $stmt_list->execute(array($group_id)) && $stmt_user->execute(array($group_id))) {
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

    public static function updateGroup($group = null) {
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");
        if (gettype($group) == "object") {

            $sql = "UPDATE `group` SET group_name=?, group_password=?, group_salt=?, creator_id=? WHERE group_id = ?";
            $stmt = $dbh->prepare($sql);

            $group_id = $group->getGroupId();
            $group_name = $group->getGroupName();
            $group_password = $group->getGroupPassword();
            $group_salt = $group->getGroupSalt();
            $creator_id = $group->getCreatorId();

            //$stmt->bind_param('sssii', $group_name, $group_password, $group_salt, $creator_id, $group_id);

            if ($stmt->execute(array($group_name, $group_password, $group_salt, $creator_id, $group_id))) {
                $dbh = null;
                return true;
            } else {
                $dbh = null;
                return false;
            }
        }
    }

    public static function updateGroupUser($create_list, $delete_list, $user_id) {
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");


        $sql = "UPDATE `group_user` SET create_list=?, delete_list=? WHERE user_id = ?";
        $stmt = $dbh->prepare($sql);

        //$stmt->bind_param('iii', $create_list, $delete_list, $user_id);
        if ($stmt->execute(array($create_list, $delete_list, $user_id))) {
            $dbh = null;
            return true;
        } else {
            $dbh = null;
            return false;
        }
    }

    public static function kickUser($user_id) {
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");
        try {

            $stmt = $dbh->prepare("DELETE FROM `group_user` WHERE user_id=?");
            //$stmt->bind_param('i', $user_id);

            if ($stmt->execute(array($user_id))) {
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

}
