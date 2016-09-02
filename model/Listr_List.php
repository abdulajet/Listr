<?php

/**
 * Description of List_Item
 *
 * @author testy
 */
class Listr_List {
    private $list_id;
    private $list_name;
    private $user_id;
    
    public function __construct($list_id, $list_name, $user_id) {
        $this->setListId($list_id);
        $this->setList_name($list_name);
        $this->setUser_id($user_id);
    }

    
    public function getListId() {
        return $this->list_id;
    }

    public function getList_name() {
        return $this->list_name;
    }

    public function getUser_id() {
        return $this->user_id;
    }

    public function setListId($list_id) {
        $this->list_id = $list_id;
    }

    public function setList_name($list_name) {
        $this->list_name = $list_name;
    }

    public function setUser_id($user_id) {
        $this->user_id = $user_id;
    }
}
