<?php
/**
 * Class : web_field_types
<<<<<<< HEAD
 * Date : 2014-10-16 08:17:42
=======
 * Date : 2014-10-08 01:52:07
>>>>>>> origin/master
 * 
 * This class was auto-generated by Database ORM
 * (Besmir Alia, besmiralia@gmail.com)
 */
include_once('start.php');
include_once('config.php');
include_once('db.php');

class web_field_types {

	public $field_type=null;

	public $field_label=null;
	public $field_value=null;
	public $field_query=null;

	/**
	 * Public Constructor
	 *
	 */
	public function web_field_types() {}
	public function get_by_field_type($id) {
		$SQL = "select * from `web_field_types` where `field_type` = '".mysql_real_escape_string($id)."' limit 1";
		$result = mysql_query($SQL) or die("Error in SQL Syntax: $SQL," . mysql_error());

		if ($row = mysql_fetch_array($result)) {
			$this->field_type = $row['field_type'];

			$this->field_label = $row['field_label'];
			$this->field_value = $row['field_value'];
			$this->field_query = $row['field_query'];
		}
		return $this;
	}

	/**
	 * GetAll
	 *
	 * @return Array() of web_field_types
	 */
	public function GetAll($con) {
		$SQL = "select * from `web_field_types` ";
		$result = mysql_query($SQL) or die("Error in SQL Syntax: $SQL," . mysql_error());

		$items = array();$i=0;
		while ($row = mysql_fetch_array($result)) {
			$item = new web_field_types();
			$item->field_type = $row['field_type'];
			//$item->field_label = $row['field_label'];
			//$item->field_value = $row['field_value'];
			//$item->field_query = $row['field_query'];
			$items[$i++]=$item;
		}
		return $items;
	}

	/**
	 * Find
	 *
	 * @return Array() of web_field_types
	 */
	public function Find($findStr) {
		$SQL = "select * from `web_field_types` where ".$findStr;
		$result = mysql_query($SQL) or die("Error in SQL Syntax: $SQL," . mysql_error());

		$items = array();$i=0;
		while ($row = mysql_fetch_array($result)) {
			$item = new web_field_types();
			$item->field_type = $row['field_type'];
			$item->field_label = $row['field_label'];
			$item->field_value = $row['field_value'];
			$item->field_query = $row['field_query'];
			$items[$i++]=$item;
		}
		return $items;
	}

	public function Insert() {
		$SQL = "insert into `web_field_types`(`field_label`,`field_value`,`field_query`) values(
		'".mysql_real_escape_string($this->field_label)."'
,		'".mysql_real_escape_string($this->field_value)."'
,		'".mysql_real_escape_string($this->field_query)."')";
		$result = mysql_query($SQL);
		if ($result === false)
			return null;
		else{$this->field_type=mysql_insert_id();
			return $this;}
	}

	public function Update() {
    	$SQL = "update `web_field_types` set
		`field_label`='".mysql_real_escape_string($this->field_label)."'
,		`field_value`='".mysql_real_escape_string($this->field_value)."'
,		`field_query`='".mysql_real_escape_string($this->field_query)."'
		where `field_type`='".mysql_real_escape_string($this->field_type)."' limit 1";
		$result = mysql_query($SQL);
		if ($result === false)
			return null;
		else
			return $this;
	}

	public function Delete() {
		$SQL = "Delete from `web_field_types` where `field_type`='".mysql_real_escape_string($this->field_type)."' limit 1";
		$result = mysql_query($SQL);
		 return $result;
	}

}
