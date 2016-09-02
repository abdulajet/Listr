<?php

/**
 * Description of GroupManagement
 *
 * @author testy
 */
include_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/functions.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/model/Group.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/model/GroupUser.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/dao/GroupDAO.php");

class GroupManagement {

    public static function actionIndex() {
        return GroupDAO::findGroupUsers(array("group_user.user_id" => $_SESSION['user_id']));
    }

    public static function actionCreate() {


        sec_session_start();

        $groupName = $_POST['group_name'];
        $groupPassword = $_POST['p'];
        $groupSalt = '';
        $creatorId = $_SESSION['user_id'];

        if (GroupManagement::validateGroupName($groupName) && GroupManagement::validatePassword($groupPassword)) {

            $groupC = new Group($groupName, $groupPassword, $groupSalt, $creatorId, $groudId = null);

            if (GroupDAO::createGroup($groupC)) {
                echo 'Created, redirecting...';
                return true;
            } else {
                return false;
            }
        } else {
            echo 'Error group name taken, redirecting...';
            return false;
        }
    }

    public static function actionDelete($group_id) {
        if ($group_id != '') {
            if (GroupDAO::deleteGroup($group_id)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function actionUpdate() {
        $groupId = $_POST['group_id'];

        $groups = GroupDAO::findGroup(array("group_id" => $groupId));

        if (is_array($groups)) {
            foreach ($groups as $Group) {
                $db_password = $Group->getGroupPassword();
                $salt = $Group->getGroupSalt();
            }
        } else {
            echo 'No groups';
        }



        if (isset($_POST["p_current"]) && !empty($_POST["p_current"]) && isset($_POST["p_new"]) && !empty($_POST["p_new"])) {

            $oldPass = $_POST["p_current"];
            $newPass = $_POST["p_new"];

            if (GroupManagement::validatePassword($oldPass) && GroupManagement::validatePassword($newPass)) {
                $oldPass = hash('sha512', $oldPass . $salt);

                if ($db_password == $oldPass) {
                    $Group->genGroupSalt($newPass);
                } else {
                    return false;
                }
            } else {
                return false;
            }

            if (GroupDAO::updateGroup($Group)) {
                return true;
            } else {
                return false;
            }
        }
        
        if (isset($_POST['user_id'])){
            $new_admin = $_POST['user_id'];
            
            if($new_admin != ''){
                $Group->setCreatorId($new_admin);
            }else{
                return false;
            }
            
            if (GroupDAO::updateGroup($Group)) {
                return true;
            } else {
                return false;
            }
            
            
        }
    }

    public static function actionJoin() {
        sec_session_start();
        $groupName = $_POST['name'];
        $groupPassword = $_POST['p'];
        $userId = $_SESSION['user_id'];

        if (GroupManagement::validateGroupNameJoin($groupName) && GroupManagement::validatePassword($groupPassword)) {

            if (GroupDAO::joinGroup($groupName, $groupPassword, $userId)) {
                echo 'Joined group, redirecting...';
                return true;
            } else {
                echo 'dao falied';
                return false;
            }
        } else {
            echo 'validation falied';
            return false;
        }
    }

    public static function actionRemoveUser() {
        if (isset($_POST['user_id'])) {
            $user_id = $_POST['user_id'];

            if (GroupDAO::kickUser($user_id) == true) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function actionUpdatePermissions() {
        if (isset($_POST['createP']) && isset($_POST['deleteP']) && isset($_POST['user_id'])) {

            $create_list = $_POST['createP'];
            $delete_list = $_POST['deleteP'];
            $user_id = $_POST['user_id'];


            if (GroupDAO::updateGroupUser($create_list, $delete_list, $user_id)) {
                return true;
            } else {
                return false;
            }
        }
    }
    
    
    
    
    
    
    
    
    
    
    

    //validton methods
    public static function validatePassword($groupPassword) {

        if (strlen($groupPassword) != 128) {
            return false;
        } else {
            return true;
        }
    }

    public static function validateGroupName($groupName) {
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");

        if ($groupName == '') {
            return false;
        } else {
            $prep_stmt = "SELECT group_id FROM `group` WHERE group_name = ? LIMIT 1";
            $stmt = $dbh->prepare($prep_stmt);
            if ($stmt) {
                //$stmt->bind_param('s', $groupName);
                $stmt->execute(array($groupName));
                $stmt->fetchAll();
                

                if ($stmt->rowCount() == 1) {
                    // group exists
                    $dbh = null;
                    return false;
                } else {
                    $dbh = null;
                    return true;
                }
            } else {
                $dbh = null;
                return false;
            }
        }
    }

    public static function validateGroupNameJoin($groupName) {
        if ($groupName == '') {
            return false;
        } else {
            return true;
        }
    }

    public static function clearUpdate($groupId) {
        sec_session_start();
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");

        $userId = $_SESSION['user_id'];

        $prep_stmt = "SELECT creator_id FROM `group` WHERE group_id= ?";
        $stmt = $dbh->prepare($prep_stmt);

        if ($stmt) {
            //$stmt->bind_param('i', $groupId);
            $stmt->execute(array($groupId));
            $result = $stmt->fetch();
            
            $creatorId = $result['creator_id'];

            if ($userId == $creatorId) {
                $dbh = null;
                return true;
            } else {
                $dbh = null;
                return false;
            }
        } else {
            $dbh = null;
            return false;
        }
    }

}
