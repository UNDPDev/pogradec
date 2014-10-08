<?php
/**
 * Class : web_service_fields
 * Date : 2014-10-08 01:52:13
 * 
 * This class was auto-generated by Database ORM
 * (Besmir Alia, besmiralia@gmail.com)
 */
include_once('start.php');
include_once('config.php');
include_once('db.php');

class web_service_fields {

	public $id_service_field=null;
	public $id_service=null;
	public $field_name=null;
	public $field_type=null;
	public $field_value=null;
	public $field_order=null;

	/**
	 * Public Constructor
	 *
	 */
	public function web_service_fields() {}
	public function get_by_id_service_field($id) {
		$SQL = "select * from `web_service_fields` where `id_service_field` = '".mysql_real_escape_string($id)."' limit 1";
		$result = mysql_query($SQL) or die("Error in SQL Syntax: $SQL," . mysql_error());

		if ($row = mysql_fetch_array($result)) {
			$this->id_service_field = $row['id_service_field'];
			$this->id_service = $row['id_service'];
			$this->field_name = $row['field_name'];
			$this->field_type = $row['field_type'];
			$this->field_value = $row['field_value'];
			$this->field_order = $row['field_order'];
		}
		return $this;
	}

	/**
	 * GetAll
	 *
	 * @return Array() of web_service_fields
	 */
	public function GetAll() {
		$SQL = "select * from `web_service_fields` ";
		$result = mysql_query($SQL) or die("Error in SQL Syntax: $SQL," . mysql_error());

		$items = array();$i=0;
		while ($row = mysql_fetch_array($result)) {
			$item = new web_service_fields();
			$item->id_service_field = $row['id_service_field'];
			$item->id_service = $row['id_service'];
			$item->field_name = $row['field_name'];
			$item->field_type = $row['field_type'];
			$item->field_value = $row['field_value'];
			$item->field_order = $row['field_order'];
			$items[$i++]=$item;
		}
		return $items;
	}

	/**
	 * Find
	 *
	 * @return Array() of web_service_fields
	 */
	public function Find($findStr) {
		$SQL = "select * from `web_service_fields` where ".$findStr;
		$result = mysql_query($SQL) or die("Error in SQL Syntax: $SQL," . mysql_error());

		$items = array();$i=0;
		while ($row = mysql_fetch_array($result)) {
			$item = new web_service_fields();
			$item->id_service_field = $row['id_service_field'];
			$item->id_service = $row['id_service'];
			$item->field_name = $row['field_name'];
			$item->field_type = $row['field_type'];
			$item->field_value = $row['field_value'];
			$item->field_order = $row['field_order'];
			$items[$i++]=$item;
		}
		return $items;
	}

	// Unique Methods

	/**
	 * Gets value of unique key
	 *
	 */
	public function get_by_unique($id_service,$field_name,$a=null){
		$SQL = "select * from `web_service_fields` where 1 and `id_service`='".$id_service."' and `field_name`='".$field_name."' ";
		$result = mysql_query($SQL) or die("Error in SQL Syntax: $SQL," . mysql_error());

		if ($row = mysql_fetch_array($result)) {
			$this->id_service_field = $row['id_service_field'];
			$this->id_service = $row['id_service'];
			$this->field_name = $row['field_name'];
			$this->field_type = $row['field_type'];
			$this->field_value = $row['field_value'];
			$this->field_order = $row['field_order'];
		}
		return $this;
	}

	// Indexer Methods

	/**
	 * Gets value of id_service
	 *
	 */
	public function get_by_id_service($id) {
		$SQL = "select * from `web_service_fields` where id_service='".$id."'";
		$result = mysql_query($SQL) or die("Error in SQL Syntax: $SQL," . mysql_error());

		$items = array();$i=0;
		while ($row = mysql_fetch_array($result)) {
			$item = new web_service_fields();
			$item->id_service_field = $row['id_service_field'];
			$item->id_service = $row['id_service'];
			$item->field_name = $row['field_name'];
			$item->field_type = $row['field_type'];
			$item->field_value = $row['field_value'];
			$item->field_order = $row['field_order'];
			$items[$i++]=$item;
		}
		return $items;
	}

	public function Insert() {
		$SQL = "insert into `web_service_fields`(`id_service`,`field_name`,`field_type`,`field_value`,`field_order`) values(
		'".mysql_real_escape_string($this->id_service)."'
,		'".mysql_real_escape_string($this->field_name)."'
,		'".mysql_real_escape_string($this->field_type)."'
,		'".mysql_real_escape_string($this->field_value)."'
,		'".mysql_real_escape_string($this->field_order)."')";
		$result = mysql_query($SQL);
		if ($result === false)
			return null;
		else{$this->id_service_field=mysql_insert_id();
			return $this;}
	}

	public function Update() {
		$SQL = "update `web_service_fields` set 
		`id_service`='".mysql_real_escape_string($this->id_service)."'
,		`field_name`='".mysql_real_escape_string($this->field_name)."'
,		`field_type`='".mysql_real_escape_string($this->field_type)."'
,		`field_value`='".mysql_real_escape_string($this->field_value)."'
,		`field_order`='".mysql_real_escape_string($this->field_order)."'
		where `id_service_field`='".mysql_real_escape_string($this->id_service_field)."' limit 1";
		$result = mysql_query($SQL);
		if ($result === false)
			return null;
		else
			return $this;
	}

	public function Delete() {
		$SQL = "Delete from `web_service_fields` where `id_service_field`='".mysql_real_escape_string($this->id_service_field)."' limit 1";
		$result = mysql_query($SQL);
		 return $result;
	}

}
