<?php
/**
 * Class : web_service_rel
 * Date : 2014-10-08 01:52:15
 * 
 * This class was auto-generated by Database ORM
 * (Besmir Alia, besmiralia@gmail.com)
 */
include_once('start.php');
include_once('config.php');
include_once('db.php');

class web_service_rel {

	public $id_service_rel=null;
	public $id_main_service=null;
	public $id_related_service=null;

	/**
	 * Public Constructor
	 *
	 */
	public function web_service_rel() {}
	public function get_by_id_service_rel($id) {
		$SQL = "select * from `web_service_rel` where `id_service_rel` = '".mysql_real_escape_string($id)."' limit 1";
		$result = mysql_query($SQL) or die("Error in SQL Syntax: $SQL," . mysql_error());

		if ($row = mysql_fetch_array($result)) {
			$this->id_service_rel = $row['id_service_rel'];
			$this->id_main_service = $row['id_main_service'];
			$this->id_related_service = $row['id_related_service'];
		}
		return $this;
	}

	/**
	 * GetAll
	 *
	 * @return Array() of web_service_rel
	 */
	public function GetAll() {
		$SQL = "select * from `web_service_rel` ";
		$result = mysql_query($SQL) or die("Error in SQL Syntax: $SQL," . mysql_error());

		$items = array();$i=0;
		while ($row = mysql_fetch_array($result)) {
			$item = new web_service_rel();
			$item->id_service_rel = $row['id_service_rel'];
			$item->id_main_service = $row['id_main_service'];
			$item->id_related_service = $row['id_related_service'];
			$items[$i++]=$item;
		}
		return $items;
	}

	/**
	 * Find
	 *
	 * @return Array() of web_service_rel
	 */
	public function Find($findStr) {
		$SQL = "select * from `web_service_rel` where ".$findStr;
		$result = mysql_query($SQL) or die("Error in SQL Syntax: $SQL," . mysql_error());

		$items = array();$i=0;
		while ($row = mysql_fetch_array($result)) {
			$item = new web_service_rel();
			$item->id_service_rel = $row['id_service_rel'];
			$item->id_main_service = $row['id_main_service'];
			$item->id_related_service = $row['id_related_service'];
			$items[$i++]=$item;
		}
		return $items;
	}

	// Unique Methods

	/**
	 * Gets value of unique key
	 *
	 */
	public function get_by_unique($id_main_service,$id_related_service,$a=null){
		$SQL = "select * from `web_service_rel` where 1 and `id_main_service`='".$id_main_service."' and `id_related_service`='".$id_related_service."' ";
		$result = mysql_query($SQL) or die("Error in SQL Syntax: $SQL," . mysql_error());

		if ($row = mysql_fetch_array($result)) {
			$this->id_service_rel = $row['id_service_rel'];
			$this->id_main_service = $row['id_main_service'];
			$this->id_related_service = $row['id_related_service'];
		}
		return $this;
	}

	// Indexer Methods

	/**
	 * Gets value of id_main_service
	 *
	 */
	public function get_by_id_main_service($id) {
		$SQL = "select * from `web_service_rel` where id_main_service='".$id."'";
		$result = mysql_query($SQL) or die("Error in SQL Syntax: $SQL," . mysql_error());

		$items = array();$i=0;
		while ($row = mysql_fetch_array($result)) {
			$item = new web_service_rel();
			$item->id_service_rel = $row['id_service_rel'];
			$item->id_main_service = $row['id_main_service'];
			$item->id_related_service = $row['id_related_service'];
			$items[$i++]=$item;
		}
		return $items;
	}

	public function Insert() {
		$SQL = "insert into `web_service_rel`(`id_main_service`,`id_related_service`) values(
		'".mysql_real_escape_string($this->id_main_service)."'
,		'".mysql_real_escape_string($this->id_related_service)."')";
		$result = mysql_query($SQL);
		if ($result === false)
			return null;
		else{$this->id_service_rel=mysql_insert_id();
			return $this;}
	}

	public function Update() {
		$SQL = "update `web_service_rel` set 
		`id_main_service`='".mysql_real_escape_string($this->id_main_service)."'
,		`id_related_service`='".mysql_real_escape_string($this->id_related_service)."'
		where `id_service_rel`='".mysql_real_escape_string($this->id_service_rel)."' limit 1";
		$result = mysql_query($SQL);
		if ($result === false)
			return null;
		else
			return $this;
	}

	public function Delete() {
		$SQL = "Delete from `web_service_rel` where `id_service_rel`='".mysql_real_escape_string($this->id_service_rel)."' limit 1";
		$result = mysql_query($SQL);
		 return $result;
	}

}
