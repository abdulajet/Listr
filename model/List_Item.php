<?php

/**
 * Description of List
 *
 * @author testy
 */
class List_Item {

    private $list_item_id;
    private $list_id;
    private $item_name;
    private $item_details;
    private $priority;
    private $start_date;
    private $due_date;
    private $completion_date;
    private $status;
    private $finished_by;
    private $is_personal;
    private $attachments;
    private $creator_id;

    public function __construct($list_item_id, $list_id, $item_name, $item_details, $priority, $start_date, $due_date, $completion_date, $status, $finished_by, $is_personal, $attachments, $creator_id) {
        $this->setList_item_id($list_item_id);
        $this->setList_id($list_id);
        $this->setItem_name($item_name);
        $this->setItem_details($item_details);
        $this->setPriority($priority);
        $this->setStart_date($start_date);
        $this->setDue_date($due_date);
        $this->setCompletion_date($completion_date);
        $this->setStatus($status);
        $this->setFinished_by($finished_by);
        $this->setIs_personal($is_personal);
        $this->setAttachments($attachments);
        $this->setCreator_id($creator_id);
    }
    
    public function getPriority() {
        return $this->priority;
    }

    public function getCreator_id() {
        return $this->creator_id;
    }

    public function setPriority($priority) {
        $this->priority = $priority;
    }

    public function setCreator_id($creator_id) {
        $this->creator_id = $creator_id;
    }

        
    public function getList_item_id() {
        return $this->list_item_id;
    }

    public function getList_id() {
        return $this->list_id;
    }

    public function getitem_name() {
        return $this->item_name;
    }

    public function getItem_details() {
        return $this->item_details;
    }
    
    public function getStart_date() {
        return $this->start_date;
    }

    public function getDue_date() {
        return $this->due_date;
    }

    public function getCompletion_date() {
        return $this->completion_date;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getFinished_by() {
        return $this->finished_by;
    }

    public function getIs_personal() {
        return $this->is_personal;
    }

    public function getAttachments() {
        return $this->attachments;
    }

     public function setList_item_id($list_item_id) {
        $this->list_item_id = $list_item_id;
    }

    
    public function setList_id($list_id) {
        $this->list_id = $list_id;
    }

    public function setItem_name($item_name) {
        $this->item_name = $item_name;
    }

    public function setItem_details($item_details) {
        $this->item_details = $item_details;
    }

    public function setStart_date($start_date) {
        $this->start_date = $start_date;
    }

    public function setDue_date($due_date) {
        $this->due_date = $due_date;
    }

    public function setCompletion_date($completion_date) {
        $this->completion_date = $completion_date;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setFinished_by($finished_by) {
        $this->finished_by = $finished_by;
    }

    public function setIs_personal($is_personal) {
        $this->is_personal = $is_personal;
    }

    public function setAttachments($attachments) {
        $this->attachments = $attachments;
    }
}
