<?php
	require_once("../start.php");
	require_once("../config.php");
	require_once("db.php");
	require_once("../cls/cls_web_category.php");
	require_once("../cls/cls_web_category_fields.php");
	require_once("../cls/cls_web_field_group.php");
	require_once("../cls/cls_web_field_types.php");
	
	$id="0";
	$arrfieldgroups = array();
	$arrfieldtypes = array();
	
	if(isset($_GET["field"]))
	{
		$field = addslashes($_REQUEST["field"]);
		$field_self = new web_category_fields();
		$field_self->get_by_id_category_field($field);
		$id = $field_self->id_category;
		$field_groups = new web_field_group();
		$arrfieldgroups = $field_groups->GetAll();
		// Denisi
		//$arrfields = $category_fields->get_by_id_category_field($id);
	}
	if($_POST)
	{
		$cat_field = new web_category_fields();
		$kot =  new web_category_fields();
		$kot = $cat_field->get_by_id_category_field($_POST["id_category_field"]);	
		$kot->field_label=$_POST["field_label"];
		$kot->field_order=$_POST["field_order"];
		$kot->id_group=$_POST["id_group"];
		$kot->Update();
		/**********/
		header("Location:category-fields.php?id=".$_POST["id"]);die();
	}
	
?>
<!DOCTYPE HTML>
<!--[if lt IE 7 ]> <html class="ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" class=""> <!--<![endif]-->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Post Edit" />
		<meta name="Publisher" content="www.dyqaniim.com" />
		<meta name="Author" content="DS LZ" />
		<meta name="copyright" content="www.dyqaniim.com 2013-2015" />
		<meta name="keywords" content="" />
		<meta name="robots" content="index, follow" />
		<meta name="abstract" content="Projekt per turizmin ne Pogradec" />
		
		<link rel="shortcut icon" href="favicon.ico" />
		<title>Lista e sherbimeve te kategorive</title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" type="text/css" />
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<style type="text/css">
			.widget .panel-body { padding:0px; }
			.widget .list-group { margin-bottom: 0; }
			.widget .panel-title { display:inline }
			.widget .label-info { float: right; }
			.widget li.list-group-item {border-radius: 0;border: 0;border-top: 1px solid #ddd;}
			.widget li.list-group-item:hover { background-color: rgba(86,61,124,.1); }
			.widget .mic-info { color: #666666;font-size: 11px; }
			.widget .action { margin-top:5px; }
			.widget .comment-text { font-size: 12px; }
			.widget .btn-block { border-top-left-radius:0px;border-top-right-radius:0px; }
		</style>
	</head>
	<body>
		
		<?php
			//Denisi
			include_once("menu.php");
		?>
		<div id="main" class="container">
			<div class="row">
				
			</div>
			<div class="row">
				<div class="panel panel-default widget">
					<!-- Default panel contents -->
					<div class="panel-heading">
					</div>
					<div class="panel-body">
						<form action="" method="post">
							<div class="form-group col-md-12">
								<br>
								<div class="row">
									<div class="col-md-1">
										Description:
									</div>
									<div class="col-md-4">
										<input type="hidden" class="form-control" name="id" value="<?php echo $field_self->id_category;?>">
										<input type="hidden" class="form-control" name="id_category_field" value="<?php echo $field_self->id_category_field?>">
										<input type="text" class="form-control" name="field_label" value="<?php echo $field_self->field_label?>">
									</div>
									<div class="col-md-1">
										Group:
									</div>
									<div class="col-md-4">
										<select class="form-control" name="id_group">
											<?php
												foreach($arrfieldgroups as $grupi)
												{
													$select = "";
													if($grupi->id_group==$field_self->id_group)
													{$select = " selected='selected' ";}
													echo "<option value='".$grupi->id_group."' ".$select." >".$grupi->group_name."</option>";
												}
											?>
										</select>
									</div>
									<div class="col-md-1">
										Order:
									</div>
									<div class="col-md-1">
										<input type="number" min="1" max="30" class="form-control" name="field_order" value="<?php echo $field_self->field_order?>">
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-md-6">
										<?php
											if( $field != 0 )
											{
												echo  "<input type='submit' class='btn btn-success' value='Save'/>";
											}
										?>
										<a href='category-fields.php?id=<?php echo $id; ?>' class='btn btn-danger' role='button'>Anullo </a>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	</body>
<html>