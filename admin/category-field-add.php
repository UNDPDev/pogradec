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
	
	if(isset($_GET["id"]))
	{
		$id = addslashes($_REQUEST["id"]);
		$field_groups = new web_field_group();
		$arrfieldgroups = $field_groups->GetAll();
		$field_types = new web_field_types();
		$arrfieldtypes = $field_types->GetAll();
		// Denisi
		//$arrfields = $category_fields->get_by_id_category_field($id);
	}
	if($_POST)
	{
		$cat_field = new web_category_fields();
		$cat_field->field_label=$_POST["field_label"];
		$cat_field->id_category=$_POST["id"];
		$cat_field->field_name=$_POST["field_name"];
		$cat_field->field_order=$_POST["field_order"];
		$cat_field->id_group=$_POST["id_group"];
		$cat_field->field_type=$_POST["field_type"];
		$cat_field->Insert();
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
										Emri identifikues:
									</div>
									<div class="col-md-5">
										<input type="hidden" name="id" value="<?php echo $id; ?>"/>
										<input type="text" class="form-control" name="field_name">
									</div>
									<div class="col-md-1">
										Grupi:
									</div>
									<div class="col-md-5">
										<select class="form-control" name="id_group">
											<?php
												foreach($arrfieldgroups as $grupi)
												{
													echo "<option value='".$grupi->id_group."'  >".$grupi->group_name."</option>";
												}
											?>
										</select>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-md-1">
										Pershkrimi:
									</div>
									<div class="col-md-5">
										<input type="text" class="form-control" name="field_label">
									</div>
									<div class="col-md-1">
										Lloji:
									</div>
									<div class="col-md-3">
										<select class="form-control" name="field_type">
											<?php
												foreach($arrfieldtypes as $lloji)
												{
													echo "<option value='".$lloji->field_type."'  >".$lloji->field_type."</option>";
												}
											?>
										</select>
									</div>
									<div class="col-md-1">
										Renditja:
									</div>
									<div class="col-md-1">
										<input type="number" min="1" max="30" value="1" class="form-control" name="field_order">
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-md-6">
										<?php
											if( $id != 0 )
											{
												echo  "<input type='submit' class='btn btn-success' value='Shto'/>";
											}
										?>
										<a href='category-fields.php?id=<?php echo $cat; ?>' class='btn btn-danger' role='button'>Anullo </a>
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