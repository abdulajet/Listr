<?php

/**
 * Description of GroupUser
 *
 * @author testy
 */
class GroupUser {
    Private $userId;
    Private $groupId;
    Private $invite;
    Private $remove;
    Private $create_list;
    private $delete_list;
    private $group;
    
    public function __construct($userId, $groupId, $invite, $remove, $create_list, $delete_list, $group) {
        $this->userId = $userId;
        $this->groupId = $groupId;
        $this->invite = $invite;
        $this->remove = $remove;
        $this->create_list = $create_list;
        $this->delete_list = $delete_list;
        $this->group = $group;
    }
    
    public function getUserId() {
        return $this->userId;
    }

    public function getGroupId() {
        return $this->groupId;
    }

    public function getInvite() {
        return $this->invite;
    }

    public function getRemove() {
        return $this->remove;
    }

    public function getCreate_list() {
        return $this->create_list;
    }

    public function getDelete_list() {
        return $this->delete_list;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setInvite($invite) {
        $this->invite = $invite;
    }

    public function setRemove($remove) {
        $this->remove = $remove;
    }

    public function setCreate_list($create_list) {
        $this->create_list = $create_list;
    }

    public function setDelete_list($delete_list) {
        $this->delete_list = $delete_list;
    }

    
    
    //Accessor methods for group
    public function getGroupName() {
        return $this->group->getGroupName();
    }

    public function getGroupPassword() {
        return $this->group->getGroupPassword();
    }

    public function getGroupSalt() {
        return $this->group->getGroupSalt();
    }

    public function getCreatorId() {
        return $this->group->getCreatorId();
    }

}
