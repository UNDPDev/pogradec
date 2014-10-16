<?php
/**
 * Class : web_category_fields
 * Date : 2014-10-16 08:17:40
 * 
 * This class was auto-generated by Database ORM
 * (Besmir Alia, besmiralia@gmail.com)
 */
include_once('start.php');
include_once('config.php');
include_once('db.php');

class web_category_fields {

	public $id_category_field=null;
	public $id_category=null;
	public $id_group=null;
	public $field_name=null;
	public $field_label=null;
	public $field_value=null;
	public $field_type=null;
	public $field_query=null;
	public $field_order=null;

	/**
	 * Public Constructor
	 *
	 */
	public function web_category_fields() {}
	public function get_by_id_category_field($id) {
		$SQL = "select * from `web_category_fields` where `id_category_field` = '".mysql_real_escape_string($id)."' limit 1";
		$result = mysql_query($SQL) or die("Error in SQL Syntax: $SQL," . mysql_error());

		if ($row = mysql_fetch_array($result)) {
			$this->id_category_field = $row['id_category_field'];
			$this->id_category = $row['id_category'];
			$this->id_group = $row['id_group'];
			$this->field_name = $row['field_name'];
			$this->field_label = $row['field_label'];
			$this->field_value = $row['field_value'];
			$this->field_type = $row['field_type'];
			$this->field_query = $row['field_query'];
			$this->field_order = $row['field_order'];
		}
		return $this;
	}

	/**
	 * GetAll
	 *
	 * @return Array() of web_category_fields
	 */
	public function GetAll() {
		$SQL = "select * from `web_category_fields` ";
		$result = mysql_query($SQL) or die("Error in SQL Syntax: $SQL," . mysql_error());

		$items = array();$i=0;
		while ($row = mysql_fetch_array($result)) {
			$item = new web_category_fields();
			$item->id_category_field = $row['id_category_field'];
			$item->id_category = $row['id_category'];
			$item->id_group = $row['id_group'];
			$item->field_name = $row['field_name'];
			$item->field_label = $row['field_label'];
			$item->field_value = $row['field_value'];
			$item->field_type = $row['field_type'];
			$item->field_query = $row['field_query'];
			$item->field_order = $row['field_order'];
			$items[$i++]=$item;
		}
		return $items;
	}

	/**
	 * Find
	 *
	 * @return Array() of web_category_fields
	 */
	public function Find($findStr) {
		$SQL = "select * from `web_category_fields` where ".$findStr;
		$result = mysql_query($SQL) or die("Error in SQL Syntax: $SQL," . mysql_error());

		$items = array();$i=0;
		while ($row = mysql_fetch_array($result)) {
			$item = new web_category_fields();
			$item->id_category_field = $row['id_category_field'];
			$item->id_category = $row['id_category'];
			$item->id_group = $row['id_group'];
			$item->field_name = $row['field_name'];
			$item->field_label = $row['field_label'];
			$item->field_value = $row['field_value'];
			$item->field_type = $row['field_type'];
			$item->field_query = $row['field_query'];
			$item->field_order = $row['field_order'];
			$items[$i++]=$item;
		}
		return $items;
	}

	// Indexer Methods

	/**
	 * Gets value of id_category
	 *
	 */
	public function get_by_id_category($id) {
		$SQL = "select * from `web_category_fields` where id_category='".$id."'";
		$result = mysql_query($SQL) or die("Error in SQL Syntax: $SQL," . mysql_error());

		$items = array();$i=0;
		while ($row = mysql_fetch_array($result)) {
			$item = new web_category_fields();
			$item->id_category_field = $row['id_category_field'];
			$item->id_category = $row['id_category'];
			$item->id_group = $row['id_group'];
			$item->field_name = $row['field_name'];
			$item->field_label = $row['field_label'];
			$item->field_value = $row['field_value'];
			$item->field_type = $row['field_type'];
			$item->field_query = $row['field_query'];
			$item->field_order = $row['field_order'];
			$items[$i++]=$item;
		}
		return $items;
	}

	// Indexer Methods

	/**
	 * Gets value of id_group
	 *
	 */
	public function get_by_id_group($id) {
		$SQL = "select * from `web_category_fields` where id_group='".$id."'";
		$result = mysql_query($SQL) or die("Error in SQL Syntax: $SQL," . mysql_error());

		$items = array();$i=0;
		while ($row = mysql_fetch_array($result)) {
			$item = new web_category_fields();
			$item->id_category_field = $row['id_category_field'];
			$item->id_category = $row['id_category'];
			$item->id_group = $row['id_group'];
			$item->field_name = $row['field_name'];
			$item->field_label = $row['field_label'];
			$item->field_value = $row['field_value'];
			$item->field_type = $row['field_type'];
			$item->field_query = $row['field_query'];
			$item->field_order = $row['field_order'];
			$items[$i++]=$item;
		}
		return $items;
	}

	// Indexer Methods

	/**
	 * Gets value of field_name
	 *
	 */
	public function get_by_field_name($id) {
		$SQL = "select * from `web_category_fields` where field_name='".$id."'";
		$result = mysql_query($SQL) or die("Error in SQL Syntax: $SQL," . mysql_error());

		$items = array();$i=0;
		while ($row = mysql_fetch_array($result)) {
			$item = new web_category_fields();
			$item->id_category_field = $row['id_category_field'];
			$item->id_category = $row['id_category'];
			$item->id_group = $row['id_group'];
			$item->field_name = $row['field_name'];
			$item->field_label = $row['field_label'];
			$item->field_value = $row['field_value'];
			$item->field_type = $row['field_type'];
			$item->field_query = $row['field_query'];
			$item->field_order = $row['field_order'];
			$items[$i++]=$item;
		}
		return $items;
	}

	public function Insert() {
		$SQL = "insert into `web_category_fields`(`id_category`,`id_group`,`field_name`,`field_label`,`field_value`,`field_type`,`field_query`,`field_order`) values(
		'".mysql_real_escape_string($this->id_category)."'
,		'".mysql_real_escape_string($this->id_group)."'
,		'".mysql_real_escape_string($this->field_name)."'
,		'".mysql_real_escape_string($this->field_label)."'
,		'".mysql_real_escape_string($this->field_value)."'
,		'".mysql_real_escape_string($this->field_type)."'
,		'".mysql_real_escape_string($this->field_query)."'
,		'".mysql_real_escape_string($this->field_order)."')";
		$result = mysql_query($SQL);
		if ($result === false)
			return null;
		else{$this->id_category_field=mysql_insert_id();
			return $this;}
	}

	public function Update() {
		$SQL = "update `web_category_fields` set 
		`id_category`='".mysql_real_escape_string($this->id_category)."'
,		`id_group`='".mysql_real_escape_string($this->id_group)."'
,		`field_name`='".mysql_real_escape_string($this->field_name)."'
,		`field_label`='".mysql_real_escape_string($this->field_label)."'
,		`field_value`='".mysql_real_escape_string($this->field_value)."'
,		`field_type`='".mysql_real_escape_string($this->field_type)."'
,		`field_query`='".mysql_real_escape_string($this->field_query)."'
,		`field_order`='".mysql_real_escape_string($this->field_order)."'
		where `id_category_field`='".mysql_real_escape_string($this->id_category_field)."' limit 1";
		$result = mysql_query($SQL);
		if ($result === false)
			return null;
		else
			return $this;
	}

	public function Delete() {
		$SQL = "Delete from `web_category_fields` where `id_category_field`='".mysql_real_escape_string($this->id_category_field)."' limit 1";
		$result = mysql_query($SQL);
		 return $result;
	}

}
