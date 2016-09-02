<?php

/**
 * Description of GroupList
 *
 * @author testy
 */
class GroupList {
    private $list_id;
    private $group_id;
    private $list_name;
    private $create_item;
    private $delete_item;
    private $update_item;
    private $upload_att;
    private $download_att;
    
    public function __construct($group_id, $list_name, $create_item, $delete_item, $update_item, $upload_att, $download_att, $list_id = null) {
        if ($list_id){
            $this->list_id = $list_id;
        }
        
        $this->group_id = $group_id;
        $this->list_name = $list_name;
        $this->create_item = $create_item;
        $this->delete_item = $delete_item;
        $this->update_item = $update_item;
        $this->upload_att = $upload_att;
        $this->download_att = $download_att;
    }

    
    public function getList_name() {
        return $this->list_name;
    }

    public function setList_name($list_name) {
        $this->list_name = $list_name;
    }

    public function getList_id() {
        return $this->list_id;
    }

    public function getGroup_id() {
        return $this->group_id;
    }

    public function getCreate_item() {
        return $this->create_item;
    }

    public function getDelete_item() {
        return $this->delete_item;
    }

    public function getUpdate_item() {
        return $this->update_item;
    }

    public function getUpload_att() {
        return $this->upload_att;
    }

    public function getDownload_att() {
        return $this->download_att;
    }

    public function setList_id($list_id) {
        $this->list_id = $list_id;
    }

    public function setGroup_id($group_id) {
        $this->group_id = $group_id;
    }

    public function setCreate_item($create_item) {
        $this->create_item = $create_item;
    }

    public function setDelete_item($delete_item) {
        $this->delete_item = $delete_item;
    }

    public function setUpdate_item($update_item) {
        $this->update_item = $update_item;
    }

    public function setUpload_att($upload_att) {
        $this->upload_att = $upload_att;
    }

    public function setDownload_att($download_att) {
        $this->download_att = $download_att;
    }


}
