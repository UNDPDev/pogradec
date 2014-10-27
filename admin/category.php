<?php
	require_once("../start.php");
	require_once("../config.php");
	require_once("db.php");
	require_once("../cls/cls_web_category.php");
	require_once("../cls/cls_web_category_fields.php");
	
	$category = new web_category();
	$arr = $category->Find("1 order by id_parent");
	// Denisi
	//$arr = $category->GetAll()
	
	$cat="0";
	$arrfields = array();
	if(isset($_REQUEST["cat"])&&$_REQUEST["cat"]!=0)
	{
		$cat = addslashes($_REQUEST["cat"]);
		$category_fields = new web_category_fields();
		$arrfields = $category_fields->get_by_id_category($cat);
		// Denisi
		//$arrfields = $category_fields->get_by_id_category_field($cat);
	}
	
	if(isset($_REQUEST["fielddele"])&&$_REQUEST["fielddele"]!=0)
	{
		$cat_field = new web_category_fields();
		$cat_field->id_category_field=$_REQUEST["fielddele"];
		$cat_field->Delete();
		/**********/
		header("Location:category.php?cat=".$_REQUEST["cat"]);die();
		// Denisi
		//$arrfields = $category_fields->get_by_id_category_field($cat);
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
						<div class="row">
							<div class="col-md-6">
								<select class="form-control" name="c" onchange="window.location='category.php?cat='+this.value">
									<option value='0' >Zgjidh Kategorine</option>
									<?php
										foreach($arr as $kategori)
										{
											$selected = '';
											if($kategori->id_category == $cat)
											$selected = ' selected="selected"';
											echo "<option value='".$kategori->id_category."' ".$selected." >".$kategori->category_name."</option>";
										}
									?>
								</select>
							</div>
							<div class="col-md-6">
								<?php
									if( $cat != 0 )
									{
										
										echo  "<a href='categoryfieldadd.php?cat=".$cat."' class='btn btn-success' role='button'>".
										"<span class='glyphicon glyphicon-plus'></span> Shto nje sherbim per kategorine</a>";
										
									}
								?>
							</div>
						</div>
						
					</div>
					
					<!-- Table -->
					<div class="panel-body">
						<br>
						<div class="table-responsive col-md-12">
							<table class="table table-condensed table-striped table-bordered table-hover">
								<thead>
									<tr>
										<td><b>Sherbimi</b></td>
										<td><b>Percaktimi</b></td>
										<td><b>Tipi</b></td>
										<td></td>
										<td></td>
									</tr>
								</thead>
								<tbody>
									<?php
										foreach($arrfields as $field){
										?>
										<tr>
											<td><?php echo $field->field_label; ?></td>
											<td><?php echo $field->field_name; ?></td>
											<td><?php echo $field->field_type; ?></td>
											<td style="width: 90px;"><a href='categoryfieldupdate.php?field=<?php echo $field->id_category_field; ?>'
												class='btn btn-warning btn-xs' role='button'>
												<span class='glyphicon glyphicon-edit'></span> Modifiko </a>
											</td>
											<td style="width: 90px;"><a href='category.php?fielddele=<?php echo $field->id_category_field; ?>
												&cat=<?php echo $cat; ?>'
												class='btn btn-danger btn-xs' role='button'>
												<span class='glyphicon glyphicon-remove'></span> Fshi </a>
											</td>
										</tr>
										
										<?php
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script src="js/holder.js"></script>
	</body>
<html>