<?php
/*
 * Header: Create: 2019-05-13 Auther: wooken<wk471159717@gmail.com>.
 */
class NoticeAccess {
	public $db;
    public function __construct($db = false)
    {
        if($db != false){
            $this->db = $db;
        }
    }

    public function Add($obj) {

		$sql = "INSERT INTO Survey_Notice(title,content,update_time,is_del,update_survId)" . " VALUES('" . $obj->title . "'" . ",'" . $obj->content . "'" . ",'" . $obj->update_time . "'" . ",'" . $obj->is_del . "'" . ",'" . $obj->update_survId . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}

    public function SelectLast(){
	    $sql = "SELECT * FROM Survey_Notice " . " ORDER BY id desc Limit 0,1";
        $this->db->query ( $sql );
        $rows = array ();
        while ( $rs = $this->db->next_record () ) {
            $rows  = $rs;
        }
        return $rows;
	}

    public function UpdateLast($obj) {
        $sql = "UPDATE Survey_Notice " . " SET title = '" . $obj->title . "'" . " ,content = '" . $obj->content . "'" . " ,update_time = '" . $obj->update_time . "'" . " ,is_del = '" . $obj->is_del . "'" . " ,update_survId = '" . $obj->update_survId . "'" . " WHERE id=(select MAX(id) from Survey_Notice)";
        $this->db->query ( $sql );
    }

    public function Update($obj) {
		$sql = "UPDATE Survey_Notice " . " SET title = '" . $obj->title . "'" . " ,content = '" . $obj->content . "'" . " ,update_time = '" . $obj->update_time . "'" . " ,is_del = '" . $obj->is_del . "'" . " ,update_survId = '" . $obj->update_survId . "'" . " WHERE 1=1  AND aId = '" . $obj->aId . "'";
		$this->db->query ( $sql );
	}
}
?>