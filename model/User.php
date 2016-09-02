<?php

/**
 * Description of User
 *
 * @author testy
 */
class User {

    private $user_id;
    private $username;
    private $password;
    private $salt;
    private $email;
    private $r_question;
    private $r_answer;

    public function __construct($username, $password, $salt, $email, $r_question, $r_answer, $user_id = null) {
        if ($user_id == '') {
            $this->genSalt($password);
        } else {
            $this->setUser_id($user_id);
            $this->setPassword($password);
            $this->setSalt($salt);
        }
        $this->setUsername($username);
        $this->setEmail($email);
        $this->setR_question($r_question);
        $this->setR_answer($r_answer);
    }

    public function getUser_id() {
        return $this->user_id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getSalt() {
        return $this->salt;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getR_question() {
        return $this->r_question;
    }

    public function getR_answer() {
        return $this->r_answer;
    }

    public function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setSalt($salt) {
        $this->salt = $salt;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setR_question($r_question) {
        $this->r_question = $r_question;
    }

    public function setR_answer($r_answer) {
        $this->r_answer = $r_answer;
    }

    public function genSalt($password) {
        $this->setSalt(hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true)));
        $this->setPassword(hash('sha512', $password . $this->getSalt()));
    }

}
