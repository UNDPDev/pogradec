<?php
/**
 * Class : web_status
 * Date : 2014-10-08 01:52:16
 * 
 * This class was auto-generated by Database ORM
 * (Besmir Alia, besmiralia@gmail.com)
 */
include_once('start.php');
include_once('config.php');
include_once('db.php');

class web_status {

	public $id_status=null;
	public $status_name=null;
	public $status_class=null;

	/**
	 * Public Constructor
	 *
	 */
	public function web_status() {}
	public function get_by_id_status($id) {
		$SQL = "select * from `web_status` where `id_status` = '".mysql_real_escape_string($id)."' limit 1";
		$result = mysql_query($SQL) or die("Error in SQL Syntax: $SQL," . mysql_error());

		if ($row = mysql_fetch_array($result)) {
			$this->id_status = $row['id_status'];
			$this->status_name = $row['status_name'];
			$this->status_class = $row['status_class'];
		}
		return $this;
	}

	/**
	 * GetAll
	 *
	 * @return Array() of web_status
	 */
	public function GetAll() {
		$SQL = "select * from `web_status` ";
		$result = mysql_query($SQL) or die("Error in SQL Syntax: $SQL," . mysql_error());

		$items = array();$i=0;
		while ($row = mysql_fetch_array($result)) {
			$item = new web_status();
			$item->id_status = $row['id_status'];
			$item->status_name = $row['status_name'];
			$item->status_class = $row['status_class'];
			$items[$i++]=$item;
		}
		return $items;
	}

	/**
	 * Find
	 *
	 * @return Array() of web_status
	 */
	public function Find($findStr) {
		$SQL = "select * from `web_status` where ".$findStr;
		$result = mysql_query($SQL) or die("Error in SQL Syntax: $SQL," . mysql_error());

		$items = array();$i=0;
		while ($row = mysql_fetch_array($result)) {
			$item = new web_status();
			$item->id_status = $row['id_status'];
			$item->status_name = $row['status_name'];
			$item->status_class = $row['status_class'];
			$items[$i++]=$item;
		}
		return $items;
	}

	public function Insert() {
		$SQL = "insert into `web_status`(`status_name`,`status_class`) values(
		'".mysql_real_escape_string($this->status_name)."'
,		'".mysql_real_escape_string($this->status_class)."')";
		$result = mysql_query($SQL);
		if ($result === false)
			return null;
		else{$this->id_status=mysql_insert_id();
			return $this;}
	}

	public function Update() {
		$SQL = "update `web_status` set 
		`status_name`='".mysql_real_escape_string($this->status_name)."'
,		`status_class`='".mysql_real_escape_string($this->status_class)."'
		where `id_status`='".mysql_real_escape_string($this->id_status)."' limit 1";
		$result = mysql_query($SQL);
		if ($result === false)
			return null;
		else
			return $this;
	}

	public function Delete() {
		$SQL = "Delete from `web_status` where `id_status`='".mysql_real_escape_string($this->id_status)."' limit 1";
		$result = mysql_query($SQL);
		 return $result;
	}

}