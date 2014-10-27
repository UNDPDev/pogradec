<?php
/**
 * Class : web_category
 * Date : 2014-10-08 01:52:05
 * 
 * This class was auto-generated by Database ORM
 * (Besmir Alia, besmiralia@gmail.com)
 */


class web_category {


	public $id_category=null;
	public $category_name=null;
	public $category_desc=null;
	public $category_img=null;
	public $category_class=null;
	public $category_order=null;
	public $id_status=null;
	public $id_parent=null;

	/**
	 * Public Constructor
	 *
	 */
	public function web_category() {}
	public function get_by_id_category($id) {
        $SQL = "select * from `web_category` where `id_category` = '".mysql_real_escape_string($id)."' limit 1";
		$result = mysql_query($SQL) or die("Error in SQL Syntax: $SQL," . mysql_error());

		if ($row = mysql_fetch_array($result)) {
			$this->id_category = $row['id_category'];
			$this->category_name = $row['category_name'];
			$this->category_desc = $row['category_desc'];
			$this->category_img = $row['category_img'];
			$this->category_class = $row['category_class'];
			$this->category_order = $row['category_order'];
			$this->id_status = $row['id_status'];
			$item->id_parent = $row['id_parent'];
		}
		return $this;
	}

	/**
	 * GetAll
	 *
	 * @return Array() of web_category
	 */
	public function GetAll() {
        /*$SQL = "(SELECT id_category,id_category id_parent, category_name,category_desc,category_img,category_class,category_order,id_status
FROM web_category
where id_parent =0 or id_parent is null)
union all
(SELECT id_category,id_parent,
 concat('---',category_name), category_desc,category_img,
 category_class,category_order,id_status
FROM web_category 
where id_parent>0)
order by 2,3 desc ";
		*/
		$SQL = "select * from `web_category`";
		$result = mysql_query($SQL) or die("Error in SQL Syntax: $SQL," . mysql_error());

		$items = array();$i=0;
		while ($row = mysql_fetch_array($result)) {
			$item = new web_category();
			$item->id_category = $row['id_category'];
			$item->category_name = $row['category_name'];
			$item->category_desc = $row['category_desc'];
			$item->category_img = $row['category_img'];
			$item->category_class = $row['category_class'];
			$item->category_order = $row['category_order'];
			$item->id_status = $row['id_status'];
			$item->id_parent = $row['id_parent'];
			$items[$i++]=$item;
		}
		return $items;
	}

	/**
	 * Find
	 *
	 * @return Array() of web_category
	 */
	public function Find($findStr) {
		$SQL = "select * from `web_category` where ".$findStr;
		$result = mysql_query($SQL) or die("Error in SQL Syntax: $SQL," . mysql_error());

		$items = array();$i=0;
		while ($row = mysql_fetch_array($result)) {
			$item = new web_category();
			$item->id_category = $row['id_category'];
			$item->category_name = $row['category_name'];
			$item->category_desc = $row['category_desc'];
			$item->category_img = $row['category_img'];
			$item->category_class = $row['category_class'];
			$item->category_order = $row['category_order'];
			$item->id_status = $row['id_status'];
			$item->id_parent = $row['id_parent'];
			$items[$i++]=$item;
		}
		return $items;
	}

	public function Insert() {
		$SQL = "insert into `web_category`(`category_name`,`category_desc`,`category_img`,`category_class`,`category_order`,`id_status`,`id_parent`) values(
		'".mysql_real_escape_string($this->category_name)."'
,		'".mysql_real_escape_string($this->category_desc)."'
,		'".mysql_real_escape_string($this->category_img)."'
,		'".mysql_real_escape_string($this->category_class)."'
,		'".mysql_real_escape_string($this->category_order)."'
,		'".mysql_real_escape_string($this->id_status)."'
,		'".mysql_real_escape_string($this->id_parent)."')";
		$result = mysql_query($SQL);
		if ($result === false)
			return null;
		else{$this->id_category=mysql_insert_id();
			return $this;}
	}

	public function Update() {
		$SQL = "update `web_category` set 
		`category_name`='".mysql_real_escape_string($this->category_name)."'
,		`category_desc`='".mysql_real_escape_string($this->category_desc)."'
,		`category_img`='".mysql_real_escape_string($this->category_img)."'
,		`category_class`='".mysql_real_escape_string($this->category_class)."'
,		`category_order`='".mysql_real_escape_string($this->category_order)."'
,		`id_status`='".mysql_real_escape_string($this->id_status)."'
,		`id_parent`='".mysql_real_escape_string($this->id_parent)."'
		where `id_category`='".mysql_real_escape_string($this->id_category)."' limit 1";
		$result = mysql_query($SQL);
		if ($result === false)
			return null;
		else
			return $this;
	}

	public function Delete() {
		$SQL = "Delete from `web_category` where `id_category`='".mysql_real_escape_string($this->id_category)."' limit 1";
		$result = mysql_query($SQL);
		 return $result;
	}

}
