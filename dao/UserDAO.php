<?php

/**
 * Description of UserDAO
 *
 * @author testy
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/listr/includes/psl-config.php';

class UserDAO {

    public static function addUser($userC) {
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");

        try {
            $sql = "INSERT INTO user (username, password, salt, email, r_question, r_answer) VALUES (?, ?, ?, ?, ?, ?)";
            $insert_stmt = $dbh->prepare($sql);

            $username = $userC->getUsername();
            $password = $userC->getPassword();
            $salt = $userC->getSalt();
            $email = $userC->getEmail();
            $r_question = $userC->getR_question();
            $r_answer = $userC->getR_answer();

            //$insert_stmt->bind_param('ssssss', $username, $password, $salt, $email, $r_question, $r_answer);
            $insert_stmt->execute(array($username, $password, $salt, $email, $r_question, $r_answer));

            $user_id = $dbh->lastInsertId();
            $dbh = null;

            $user = UserDAO::findUser(array("user_id" => $user_id));

            return $user;
        } catch (Exception $e) {
            //error handling stuff
            echo 'insert falied';
        }
    }

    public static function findUser($constraints = array()) {
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");

        try {
            $dbColumns = array("user_id", "username", "password", "salt", "email", "r_question", "r_answer");
            $query = "SELECT * FROM user ";
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
            $x = array_values($constraints);
            $stmt->execute($x);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (is_array($results) && !empty($results)) {
                foreach ($results as $userData) {
                    $resultUsers[] = new User($userData['username'], $userData['password'], $userData['salt'], $userData['email'], $userData['r_question'], $userData['r_answer'], $userData['user_id']);
                }
                $dbh = null;
                return $resultUsers;
            } else {
                $dbh = null;
                return false;
            }
        } catch (Exception $ex) {
            //error handling
        }
    }

    public static function findUserOr($constraints = array()) {
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");

        try {
            $query = "SELECT * FROM user ";
            if (count($constraints) > 0) {
                $query .= "WHERE ";
                foreach ($constraints as $constraint) {
                    $query .= "user_id" . " = ? OR ";
                }
                $query = substr($query, 0, -3);
            }

            $stmt = $dbh->prepare($query);
            $x = array_values($constraints);
            $stmt->execute($x);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (is_array($results) && !empty($results)) {
                foreach ($results as $userData) {
                    $resultUsers[] = new User($userData['username'], $userData['password'], $userData['salt'], $userData['email'], $userData['r_question'], $userData['r_answer'], $userData['user_id']);
                }
                $dbh = null;
                return $resultUsers;
            } else {
                $dbh = null;
                return false;
            }
        } catch (Exception $ex) {
            //error handling
        }
    }

    public static function deleteUser($user_id) {
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");

        try {
            $stmt_user = $dbh->prepare("DELETE FROM user WHERE user_id=?");
            //$stmt_user->bind_param('i', $user_id);

            $stmt_list = $dbh->prepare("DELETE FROM list WHERE user_id=?");
            //$stmt_list->bind_param('i', $user_id);

            $stmt_groupuser = $dbh->prepare("DELETE FROM group_user WHERE user_id=?");
            //$stmt_groupuser->bind_param('i', $user_id);

            $stmt_login = $dbh->prepare("DELETE FROM login_attempts WHERE user_id=?");
            //$stmt_login->bind_param('i', $user_id);

            if ($stmt_user->execute(array($user_id)) && $stmt_list->execute(array($user_id)) && $stmt_groupuser->execute(array($user_id)) && $stmt_login->execute(array($user_id))) {
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

    public static function updateUser($user) {
        include ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/db_connect.php");

        $sql = "UPDATE user SET password=?, salt=?, email=?, r_question=?, r_answer=? WHERE user_id = ?";
        $stmt = $dbh->prepare($sql);


        $user_id = $user->getUser_id();
        $password = $user->getPassword();
        $salt = $user->getSalt();
        $email = $user->getEmail();
        $r_question = $user->getR_question();
        $r_answer = $user->getR_answer();

        //$stmt->bind_param('sssssi', $password, $salt, $email, $r_question, $r_answer, $user_id);

        if ($stmt->execute(array($password, $salt, $email, $r_question, $r_answer, $user_id))) {
            $dbh = null;
            return true;
        } else {
            $dbh = null;
            return false;
        }
    }

}
