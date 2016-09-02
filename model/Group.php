<?php

/**
 * Description of group
 *
 * @author testy
 */
class Group {

    private $groupId;
    private $groupName;
    private $groupPassword;
    private $groupSalt;
    private $creatorId;

    public function __construct($groupName, $groupPassword, $groupSalt, $creatorId, $groupId = null ) {
        if ($groupId == ''){
             $this->genGroupSalt($groupPassword);
        }else{
            $this->setGroupId($groupId);
            $this->setGroupPassword($groupPassword);
            $this->setGroupSalt($groupSalt);
            
        }
       
        $this->setGroupName($groupName);
        $this->setCreatorId($creatorId);
    }

    public function getGroupId() {
        return $this->groupId;
    }

    public function getGroupName() {
        return $this->groupName;
    }

    public function getGroupPassword() {
        return $this->groupPassword;
    }

    public function getGroupSalt() {
        return $this->groupSalt;
    }

    public function getCreatorId() {
        return $this->creatorId;
    }

    public function setGroupId($groupId) {
        $this->groupId = $groupId;
    }

    public function setGroupName($groupName) {
        $this->groupName = $groupName;
    }

    public function setGroupPassword($groupPassword) {
        $this->groupPassword = $groupPassword;
    }

    public function setGroupSalt($groupSalt) {
        $this->groupSalt = $groupSalt;
    }

    public function setCreatorId($creatorId) {
        $this->creatorId = $creatorId;
    }

    public function genGroupSalt($groupPassword) {
        $this->setGroupSalt(hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true)));
        $this->setGroupPassword(hash('sha512', $groupPassword . $this->getGroupSalt()));
    }

}
