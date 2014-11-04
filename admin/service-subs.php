<?php
	require_once("../start.php");
	require_once("../config.php");
	require_once("db.php");
	require_once("../cls/cls_web_category.php");
	require_once("../cls/cls_web_service.php");
	require_once("../cls/cls_web_service_fields.php");
	require_once("../cls/cls_web_service_gallery.php");
	require_once("../cls/cls_web_category_fields.php");
	
	
	
	// Denisi
	$service = new web_service();
	$service_field = new web_service_fields();
	$service_fields = array();
	$category = new web_category();
	$category_field = new web_category_fields();
	$category_field_value = new web_service_fields();
	
	if(isset($_REQUEST["subservdele"])&&$_REQUEST["subservdele"]!=0)
	{
		$id = $_REQUEST["subservdele"];
		$service = new web_service();
		$service=$service->get_by_id_service($id);
		$SQL = "delete from web_service_fields where id_service=".$id;
		$result = mysql_query($SQL) or die("Error in SQL Syntax: $SQL," . mysql_error());
		
		$service->Delete();
		/**********/
		header("Location:service-subs.php?id=".$_REQUEST["id_parent"]);die();
		// Denisi
		//$arrfields = $category_fields->get_by_id_category_field($id);
	}
	
	
	if(isset($_REQUEST["id"])&&$_REQUEST["id"]!=0)
	{
		$id = $_REQUEST["id"];
		$service = new web_service();
		$service=$service->get_by_id_service($id);
		
		$SQL = "SELECT c2.*
		FROM `web_category` c1, `web_category` c2
		WHERE c1.id_category = c2.id_parent
		and c1.id_category=(SELECT id_category FROM `web_service` where id_service = ".$id.")
		order by c2.category_order";
		
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
			$items[$i++]=$item;
		}
		$arr_fields = array();
	}
	
	
	if($_POST)
	{
		$id = addslashes($_REQUEST["id"]);
		$serv = new web_service();
		if(isset($_REQUEST["tip"])&&$_REQUEST["tip"]=='shtim'){
		    $serv->id_category=$_REQUEST["kategoria"];
			$serv->id_parent=$id;
		    $serv->service_name=$_REQUEST["name".$serv->id_category];
			$serv->service_desc=$_REQUEST["desc".$serv->id_category];
			$serv->service_price=$_REQUEST["p".$serv->id_category];
			$serv=$serv->Insert();
			$subservice=$serv->id_service;
			
		}
		else{
			$subservice=addslashes($_REQUEST["subservice"]);
			$serv->get_by_id_service($subservice);
			$serv->service_desc=$_REQUEST["".$serv->service_name];
			$serv->service_price=$_REQUEST["p".$serv->service_name];
			$serv->Update();
			
		}
		
		$SQL = "delete from web_service_fields where id_service=".$subservice;
		$result = mysql_query($SQL) or die("Error in SQL Syntax: $SQL," . mysql_error());
		$category_field = new web_category_fields();
        
		$fields = $category_field->Find(" id_category='".$serv->id_category."'  order by field_order");
        foreach($fields as $field)
		{	   
			
			$category_field_value = new web_service_fields();
			$category_field_value->id_service=$subservice;
			$category_field_value->field_name=$field->field_name;
			$category_field_value->field_type=$field->field_type;
			$category_field_value->field_order=$field->field_order;
			
			
			switch($field->field_type)
			{
				case "textbox":case "numberbox":case "datepicker": case "timepicker": case "combobox": case "file": case "image":{
																		if(isset($_REQUEST[$subservice."".$field->field_name])) //or isset($_REQUEST[$serv->id_category."".$field->field_name]))
                                                                              $category_field_value->field_value=$_REQUEST[$subservice."".$field->field_name];
																	    else 
																		      $category_field_value->field_value=$_REQUEST[$serv->id_category."".$field->field_name];
																		 break;
                                                                        }
				case "checkbox": {
					$category_field_value->field_value=0;
					if(isset($_REQUEST[$subservice."".$field->field_name]) or isset($_REQUEST[$serv->id_category."".$field->field_name]))
					$category_field_value->field_value=1;
					break;
				}
				
				
			}
			$category_field_value->Insert();              
		} 
		/**********/
    	header("Location:service-subs.php?id=".$id);		die();
		
		
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
		<meta name="abstract" content="Best Company for Web Design" />
		
		<link rel="shortcut icon" href="favicon.ico" />
		<title>Nensherbimet</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" type="text/css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script src="js/holder.js"></script>
		<script src="js/typeahead.min.js"></script>
		<script>
			function getdesc(str)
			{
				return this.document.getElementById(str).value;
			}
		</script>
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
			form div.photos {
            margin-right: -19px;
            overflow: hidden;
			}
			form div.photos > div {
            border-radius: 3px;
            float: left;
            height: 90px;
            margin: 19px 19px 0 0;
            width: 120px;
			}
			form div.photos > div.uploading {
            border: 1px #ccc solid;
			}
			form div.photos > div.uploaded {
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
			}
			form div.photos > div.uploading span.progress {
            background: white;
            border-radius: 2px;
            display: block;
            height: 10px;
            margin: 40px 5px;
            overflow: hidden;
			}
			form div.photos > div.uploading span.progress span {
            display: block;
            height: 100%;
			}
		</style>
		<style>
			div#gmap { width: 100%; height: 300px; }
			
			.stepwizard-step p {
			margin-top: 10px;    
			}
			
			.stepwizard-row {
			display: table-row;
			}
			
			.stepwizard {
			display: table;     
			width: 100%;
			position: relative;
			}
			
			.stepwizard-step button[disabled] {
			opacity: 1 !important;
			filter: alpha(opacity=100) !important;
			}
			
			.stepwizard-row:before {
			top: 14px;
			bottom: 0;
			position: absolute;
			content: " ";
			width: 100%;
			height: 1px;
			background-color: #ccc;
			z-order: 0;
			
			}
			
			.stepwizard-step {    
			display: table-cell;
			text-align: center;
			position: relative;
			}
			
			.btn-circle {
			width: 30px;
			height: 30px;
			text-align: center;
			padding: 6px 0;
			font-size: 12px;
			line-height: 1.428571429;
			border-radius: 15px;
			}
		</style>
<style type="text/css">
.bs-example{
	font-family: sans-serif;
	position: relative;
	margin: 100px;
}
.typeahead, .tt-query, .tt-hint {
	border: 2px solid #CCCCCC;
	border-radius: 8px;
	font-size: 24px;
	height: 30px;
	line-height: 30px;
	outline: medium none;
	padding: 8px 12px;
	width: 396px;
}
.typeahead {
	background-color: #FFFFFF;
}
.typeahead:focus {
	border: 2px solid #0097CF;
}
.tt-query {
	box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
}
.tt-hint {
	color: #999999;
}
.tt-dropdown-menu {
	background-color: #FFFFFF;
	border: 1px solid rgba(0, 0, 0, 0.2);
	border-radius: 8px;
	box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
	margin-top: 12px;
	padding: 8px 0;
	width: 422px;
}
.tt-suggestion {
	font-size: 24px;
	line-height: 24px;
	padding: 3px 20px;
}
.tt-suggestion.tt-is-under-cursor {
	background-color: #0097CF;
	color: #FFFFFF;
}
.tt-suggestion p {
	margin: 0;
}
</style>
	</head>
	<body>
		
		<?php
			//Denisi
			include_once("menu.php");
		?>
		<div class="container">
			
			
  <div class="stepwizard"> 
    <div class="stepwizard-row"> 
      <div class="stepwizard-step"> <a class="btn btn-primary btn-circle" href='service-edit.php?id=<?php echo $id;?>'>1</a> 
        <p>Te dhenat baze</p>
      </div>
      <div class="stepwizard-step"> <a class="btn btn-primary btn-circle" <?php if($id==0) echo 'disabled="disabled"';?> href='service-subs.php?id=<?php echo $id;?>'>2</a> 
        <p>Sherbimet e ofruara</p>
      </div>
      <div class="stepwizard-step"> <a class="btn btn-default btn-circle" <?php if($id==0) echo 'disabled="disabled"';?> href='service-extra.php?id=<?php echo $id;?>'>3</a> 
        <p>Informactione shtese</p>
      </div>
      <div class="stepwizard-step"> <a class="btn btn-default btn-circle" <?php if($id==0) echo 'disabled="disabled"';?> href='service-gallery.php?id=<?php echo $id;?>'>4</a> 
        <p>Galeria</p>
      </div>
      <div class="stepwizard-step"> <a class="btn btn-default btn-circle" <?php if($id==0) echo 'disabled="disabled"';?> href='service-rel.php?id=<?php echo $id;?>'>5</a> 
        <p>Sherbimet e lidhura</p>
      </div>
    </div>
  </div>
			
		</div>
		<div id="main" class="container">
			<div class="row">
				
			</div>
			<div class="row">
				<div class="panel panel-default widget">
					<!-- Default panel contents -->
					<div class="panel-heading">
						<div class="row">
							<div class="col-md-6">
								<?php echo $service->service_name;  ?>
							</div>
						</div>
						
					</div>
					
					<!-- Table -->
					<div class="panel-body">
						<table><tr><td style="padding:5px">
							<div class="container">
								<div id="content">
									<ul id="tabs" class="nav nav-tabs" data-tabs="tabs"> 
										<?php 
											$j=1;
											foreach($items as $sub_cat1){
												$duket='';
												if($j==1) $duket='class="active"';
												$j++;
												echo '<li '.$duket.' ><a href="#a'.$sub_cat1->id_category.'" data-toggle="tab">'.$sub_cat1->category_name.'</a></li>';
											}?>
									</ul>
									<div id="my-tab-content" class="tab-content">
										
										<?php
											$j=1;
											foreach($items as $sub_cat)
											{
											    ?>
													<script type="text/javascript">
													
														$(document).ready(function() {
																  $('#<?php echo 'name'.$sub_cat->id_category;?>').typeahead({
																	   name : '<?php echo "name".$sub_cat->id_category;?>',
																	   remote: {
																		   url : 'service_search.php?id_category=<?php echo $sub_cat->id_category;?>&q=%QUERY'
																		  }
															});
													});
													</script>
						
												<?php
												$shtesadiv="";
												$shtesamodal="";
												$duket='';
												if($j==1) $duket='active';
												$j++;
												$shtesadiv.='<div class="tab-pane '.$duket.'" id="a'.$sub_cat->id_category.'">';
												
												$SQL = "SELECT *
												FROM `web_service`
												WHERE id_category = '".$sub_cat->id_category."' and id_parent='".$id."'";
												
												$resulti = mysql_query($SQL) or die("Error in SQL Syntax: $SQL," . mysql_error());
												
												$i=0;
												$shtesadiv.= '
												<table class="table table-condensed table-striped table-bordered table-hover">
												<thead>
												<tr>
												<td><b>Sherbimi</b></td>
												<td><b>Pershkrimi</b></td>
												<td><b>Cmimi</b></td>
												<td></td>
												<td></td>
												</tr>
												</thead>
												<tbody>
												';
												while ($rowi = mysql_fetch_array($resulti))
												{
													$itemi = new web_service();
													$itemi->get_by_id_service($rowi['id_service']);
													
													$shtesadiv.= ' <tr><td>'.$itemi->service_name.'</td>
													<td>'.$itemi->service_desc.'</td>
													<td>'.$itemi->service_price.'</td>
													<td style="width: 90px;"><a href="service-subs.php?subservdele='.$itemi->id_service.'&id_parent='.$itemi->id_parent.'" 
													class="btn btn-danger btn-xs" role="button">
													<span class="glyphicon glyphicon-remove"></span> Fshi </a></td>
													<td style="width: 90px;">	<a href="#" 
													data-toggle="modal"
													data-target="#modal'.$itemi->id_service.'" 
													class="btn btn-warning btn-xs" role="button">
													<span class="glyphicon glyphicon-edit"></span> Modifiko </a>
													</td></tr>';
													$shtesamodal.='<div class="modal fade" id="modal'.$itemi->id_service.'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
													<div class="modal-dialog">
													<div class="modal-content">
                                                    <div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="modal-title" id="myModalLabel"></h4>
                                                    </div>
                                                    <div class="modal-body">
													<form method="post" action="service-subs.php" role="form" class="" enctype="multipart/form-data">
													<input type="hidden" name="id" value="'.$id.'"/>
													<input type="hidden" name="subservice" value="'.$itemi->id_service.'"/>
													<p><input type="text" class="form-control" name="'.$itemi->service_name.'" id="'.$itemi->service_name.'"
													value="'.$itemi->service_desc.'" placeholder="'.$itemi->service_desc.'"/>
													</p><br/>
                                                    <p>Cmimi: <b><input type="text" class="form-control" name="p'.$itemi->service_name.'" id="p'.$itemi->service_name.'"
													value="'.$itemi->service_price.'" placeholder="'.$itemi->service_price.'"/></b></p><br/>
                                                    
													';
													$fields = $category_field->Find(" id_category='".$itemi->id_category."'  order by field_order");
													foreach($fields as $field)
													{
														$category_field_value->get_by_unique($itemi->id_service,$field->field_name);
														$shtesamodal.= "<div class='input-group'>";
														if($field->field_type != 'checkbox')
														{
															$shtesamodal.=   '<b>'.$field->field_label.'</b>';
														}
														/*
														else
														{
															$shtesamodal.=   '<span class="input-group-addon"><b>'.$field->field_label.'</b></span>';
														}
														*/
														switch($field->field_type)
														{
															case "textbox":case "numberbox":case "datepicker": case "timepicker": {
																$shtesamodal.= "<input type='text' class='form-control' name='".$itemi->id_service.$field->field_name."' id='".$field->field_name."'
																value='".$category_field_value->field_value."' placeholder='".$category_field_value->field_value."'/>";
																break;
															}
															case "checkbox": {
																$checked='';
																if($category_field_value->field_value==1)
																$checked='checked="checked"';
																//$shtesamodal.= "<input type='checkbox'  class='".$field->field_type."' name='".$itemi->id_service.$field->field_name."' id='".$field->field_name."' ".$checked."/>";
																$shtesamodal.= '<span class="button-checkbox"><button type="button" class="btn" data-color="info" id="btn_'.$field->field_name.'">'.$field->field_label.'</button><input type="checkbox" class="hidden" id="'.$field->field_name.'" name="'.$itemi->id_service.$field->field_name.'" '.($checked).' /></span>';
																break;
															}
															case "file": case "image": {
																$shtesamodal.= "<input type='file' class='form-control' name='".$itemi->id_service.$field->field_name."' id='".$field->field_name."' />";
																break;
															}
															case "combobox":{
																$shtesamodal.= "<select class='form-control' name='".$itemi->id_service.$field->field_name."' id='".$field->field_name."' >";
																if($field->field_query) {
																	$res = mysql_query($field->field_query) or die(mysql_error());
																	while($r = mysql_fetch_array($res))
																	{
																		$selected = '';
																		if($r[$field->field_value]==$category_field_value->field_value)
																		{
																			$selected = "selected='selected'";
																		}
																		$shtesamodal.= "<option value='".$r[$field->field_value]."' ".$selected."  >".$r[$field->field_label]."</option>";
																	}
																}
																$shtesamodal.= "</select>";
																break;
															}
														}
														$shtesamodal.= "</div><br/>";
													}
													
													$shtesamodal.=   '</div>
													<div class="modal-footer">'.
													'<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
													<button type="submit" class="btn btn-save">Save changes</button>
													</div>
													</form>
													</div>
													</div>
                                                    </div>';
													
													echo $shtesamodal;
												}
												
												////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
												$shtesamodal.='<div class="modal fade" id="modalshto'.$sub_cat->id_category.'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
												<div class="modal-dialog">
                                                <div class="modal-content">
												<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="modal-title" id="myModalLabel"></h4>
												</div>
												<div class="modal-body">
												<form method="post" action="service-subs.php" role="form" class="" enctype="multipart/form-data">
												<input type="hidden" name="id" value="'.$id.'"/>
												<input type="hidden" name="kategoria" value="'.$sub_cat->id_category.'"/>
												<input type="hidden" name="tip" value="shtim"/>
												<p><input type="text" class="typeahead tt-query" autocomplete="off" name="name'.$sub_cat->id_category.'" id="name'.$sub_cat->id_category.'"
												 spellcheck="false" value="" placeholder="Emri i produktit, psh Dhome Teke, Tave Dheu"/>
												</p><br/>
												<p><input type="text" class="form-control" name="desc'.$sub_cat->id_category.'" id="desc'.$sub_cat->id_category.'"
												value="" placeholder="Pershkrimi i gjate i produktit"/>
												</p><br/>
												<p>Cmimi: <b><input type="number" class="form-control numberbox" name="p'.$sub_cat->id_category.'" id="p'.$sub_cat->id_category.'"
												value="" placeholder="Cmimi i produktit ne Lek"/></b></p><br/>
												
												';
												$fields = $category_field->Find(" id_category='".$sub_cat->id_category."'  order by field_order");
												foreach($fields as $field)
												{
													
													$shtesamodal.= "<div class='input-group'>";
													if($field->field_type != 'checkbox')
													{
														$shtesamodal.=   '<b>'.$field->field_label.'</b>';
													}
													/*
													else
													{
														$shtesamodal.=   '<span class="input-group-addon"><b>'.$field->field_label.'</b></span>';
													}
													*/
													switch($field->field_type)
													{
														case "textbox":case "numberbox":case "datepicker": case "timepicker": {
															$shtesamodal.= "<input type='text' class='".$field->field_type."' name='".$sub_cat->id_category.$field->field_name."' id='".$sub_cat->id_category.$field->field_name."'
															value='' placeholder=''/>";
															break;
														}
														case "checkbox": {
															$checked='';
															//$shtesamodal.= "<input type='checkbox'  class='".$field->field_type."' name='".$sub_cat->id_category.$field->field_name."' id='".$sub_cat->id_category.$field->field_name."' ".$checked."/>";
															$shtesamodal.= '<span class="button-checkbox"><button type="button" class="btn" data-color="info" id="btn_'.$field->field_name.'">'.$field->field_label.'</button><input type="checkbox" class="hidden" id="'.$sub_cat->id_category.$field->field_name.'" name="'.$sub_cat->id_category.$field->field_name.'" '.($checked).' /></span>';
															break;
														}
														case "file": case "image": {
															$shtesamodal.= "<input type='file'  class='".$field->field_type."' name='".$sub_cat->id_category.$field->field_name."' id='".$sub_cat->id_category.$field->field_name."' />";
															break;
														}
														case "combobox":{
															$shtesamodal.= "<select class='form-control' name='".$itemi->id_service.$field->field_name."' id='".$field->field_name."' >";
															if($field->field_query) {
																$res = mysql_query($field->field_query) or die(mysql_error());
																while($r = mysql_fetch_array($res))
																{
																	$shtesamodal.= "<option value='".$r[$field->field_value]."' >".$r[$field->field_label]."</option>";
																}
															}
															$shtesamodal.= "</select>";
															break;
														}
													}
													$shtesamodal.= "</div><br/>";
												}
												
                                                $shtesamodal.=   '</div>
												<div class="modal-footer">'.
												'<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												<button type="submit" class="btn btn-primary btn-save">Save changes</button>
												</div>
												</form>
												</div>
												</div>
												</div>';
												
												echo $shtesamodal;
												
												
												/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
												$shtesadiv.= ' <tr href="#" 
												data-toggle="modal"
												data-target="#modalshto'.$sub_cat->id_category.'"><td colspan=5>';
												
												$shtesadiv.=  "<button type='button' class='btn btn-success' role='button'>".
												"<span class='glyphicon glyphicon-plus'></span> Shto nje nensherbim per kategorine";
												$shtesadiv.= '</td></tr>';
												$shtesadiv .= '</tbody></table></div>';
												echo $shtesadiv;
												
											}
											
										?>
									</div></div>
									<script type="text/javascript">
										jQuery(document).ready(function ($) {
											$('#tabs').tab();
										});
									</script>  
							</div>
							
							
							
						</td></tr>
						</table>
						<br/>
					</div>
				</div>
			</div>
		</div>
		
	</body>
<html>