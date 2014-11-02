<?php
	require_once("../start.php");
	require_once("../config.php");
	require_once("db.php");	
	
	/* BESMIR ALIA
	 * 02-11-2014
	 * CHECK IF THE USER HAS ACCESS
	 */
	if(!checkAccess("Edit-Sherbim")){ header("Location:index.php");die(); }
	
	require_once("../cls/cls_web_service.php");
	require_once("../cls/cls_web_service_rel.php");
	
	$service = new web_service();
	$service_rel = new web_service_rel();
	
	$id=0;
	if(isset($_REQUEST["id"])) $id = addslashes($_REQUEST["id"]);
	$msg="";
	if(isset($_REQUEST["msg"])) $msg = addslashes($_REQUEST["msg"]);
	
	$service->service_img="http://placehold.it/900x300.png";
	$sid=0;if(isset($_REQUEST["sid"])) $sid = addslashes($_REQUEST["sid"]);
	$a="";if(isset($_REQUEST["a"])) $a = addslashes($_REQUEST["a"]);//action
	if($a=="delete") {
		$srel = $service_rel->get_by_id_service_rel($sid);
		$srel->Delete();
	}
	if($id){
		$service = $service->get_by_id_service($id);
		$service_rels = $service_rel->get_by_id_main_service($id);
		
	}
	
	if($_POST){
		$service_rel->id_main_service=$id;
		$service_rel->id_related_service=addslashes($_REQUEST["id_service"]);
		
		$service_rel = $service_rel->Insert();
		
		header("Location:service-rel.php?id=".$id);die(); //redirect to second step
		
	}
?>	
<!DOCTYPE HTML>
<!--[if lt IE 7 ]> <html class="ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" class=""> <!--<![endif]-->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Modifikim sherbimi" />
		<meta name="Publisher" content="www.dyqaniim.com" />
		<meta name="Author" content="Besmir Alia" />
		<meta name="copyright" content="www.dyqaniim.com 2013-2015" />
		<meta name="keywords" content="" />
		<meta name="robots" content="index, follow" />
		<meta name="abstract" content="Pogradeci online" />
		
		<link rel="shortcut icon" href="favicon.ico" />
		<title>Related Services</title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" type="text/css"/>
		<link rel="stylesheet" href="css/wizard.css" type="text/css"/>
		<!--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/simplex/bootstrap.min.css" type="text/css" />-->
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<style>
			
			.typeahead,
			.tt-query,
			.tt-hint {
			width: 100%;
			
			padding: 8px 12px;
			
			line-height: 30px;
			border: 2px solid #ccc;
			-webkit-border-radius: 8px;
			-moz-border-radius: 8px;
			border-radius: 8px;
			outline: none;
			}
			
			.typeahead {
			background-color: #fff;
			}
			
			.typeahead:focus {
			border: 2px solid #0097cf;
			}
			
			.tt-query {
			-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
			-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
			box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
			}
			
			.tt-hint {
			color: #999
			}
			
			.tt-dropdown-menu {
			width: 422px;
			margin-top: 12px;
			padding: 8px 0;
			background-color: #fff;
			border: 1px solid #ccc;
			border: 1px solid rgba(0, 0, 0, 0.2);
			-webkit-border-radius: 8px;
			-moz-border-radius: 8px;
			border-radius: 8px;
			-webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
			-moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
			box-shadow: 0 5px 10px rgba(0,0,0,.2);
			}
			
			.tt-suggestion {
			padding: 3px 20px;
			font-size: 18px;
			line-height: 24px;
			}
			
			.tt-suggestion.tt-cursor {
			color: #fff;
			background-color: #0097cf;
			
			}
			
			.tt-suggestion p {
			margin: 0;
			}
		</style>
	</head>
	<body>
		<?php include_once("menu.php");?>
		<div class="container">
			
			
			<div class="stepwizard"> 
				<div class="stepwizard-row"> 
					<div class="stepwizard-step"> <a class="btn btn-primary btn-circle" href='service-edit.php?id=<?php echo $id;?>'>1</a> 
						<p>Basic Data</p>
					</div>
					<div class="stepwizard-step"> <a class="btn btn-primary btn-circle" <?php if($id==0) echo 'disabled="disabled"';?> href='service-extra.php?id=<?php echo $id;?>'>2</a> 
						<p>Extra Info</p>
					</div>
					<div class="stepwizard-step"> <a class="btn btn-primary btn-circle" <?php if($id==0) echo 'disabled="disabled"';?> href='service-subs.php?id=<?php echo $id;?>'>3</a> 
						<p>Services</p>
					</div>
					<div class="stepwizard-step"> <a class="btn btn-primary btn-circle" <?php if($id==0) echo 'disabled="disabled"';?> href='service-gallery.php?id=<?php echo $id;?>'>4</a> 
						<p>Gallery</p>
					</div>
					<div class="stepwizard-step"> <a class="btn btn-primary btn-circle" <?php if($id==0) echo 'disabled="disabled"';?> href='service-rel.php?id=<?php echo $id;?>'>5</a> 
						<p>Related Services</p>
					</div>
				</div>
			</div>
			
		</div>
		<div class="container" id="main">
			<form method='post' action='' role="form" class="" enctype="multipart/form-data" id="frm">
				<input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
				<input type="hidden" name="id_service" id="id_service" value="" />
				<?php if($msg){echo '<div class="alert alert-success alert-dismissable ">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div>';}?>
				<div class="row">
					<div class="form-group col-md-12">
						<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
						<a href="service-edit.php" class="btn btn-info"><span class="glyphicon glyphicon-plus"></span> New</a>
						<a href="service-list.php" class="btn btn-info"><span class="glyphicon glyphicon-list"></span> View List</a>
						<?php if($id) echo '<a href="../service.php?id='.$id.'" class="btn btn-default" target="_blank"><span class="glyphicon glyphicon-eye-open"></span> Preview</a>';?>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						
						<label for="main_service_name">Emri i sherbimit kryesor</label>
						<input type="text" class="form-control" id="main_service_name" name="main_service_name" placeholder="Emri i sherbimit" value="<?php echo $service->service_name;?>" disabled="disabled">
						<div id="remote">
							<label for="service_name">Emri i sherbimit sekondar</label>
							<input type="text" class="typeahead form-control" id="service_name" name="service_name" placeholder="Emri i sherbimit" value="">							
						</div>
						<div class="clearfix"></div>
						<div class="clearfix"></div>
						<div id="results">
							<?php
								foreach($service_rels as $sr)
								{
									$ssr = $service->get_by_id_service($sr->id_related_service);
								?>
								<!--<label ><?php echo $ssr->service_name;?></label><a href="service-rel.php?a=delete&sid=<?php echo $sr->id_service_rel;?>&id=<?php echo $id;?>" class="btn btn-danger"><span class="glyphicon glyphicon-remove">Delete</span> </a>-->
								
								<div class="input-group">
									<input type="text" class="form-control"  value='<?php echo $ssr->service_name;?>' disabled='disabled'>
									<span class="input-group-btn">
										<a class="btn btn-danger" href='service-rel.php?a=delete&sid=<?php echo $sr->id_service_rel;?>&id=<?php echo $id;?>'><span class="glyphicon glyphicon-remove">Delete</span></a>
									</span>
								</div><!-- /input-group -->
							<?php }?>
						</div>
					</div>
				</div>
				
			</form>
		</div>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script src="ckeditor/ckeditor.js"></script>
		<script src="js/typeahead.min.js"></script>
		<script type="text/javascript">
			// Waiting for the DOM ready...
			$(function(){				
				
				var serv = new Bloodhound({
					datumTokenizer: Bloodhound.tokenizers.obj.whitespace('service_name'),
					queryTokenizer: Bloodhound.tokenizers.whitespace,
					remote: '../kerko.php?q=%QUERY'
				});
				
				serv.initialize();
				
				$('#remote .typeahead').typeahead(null, {
					
					displayKey: 'service_name',
					source: serv.ttAdapter()
				});
				
				$("#remote .typeahead").on("typeahead:selected typeahead:autocompleted", function(e,datum) { $("#id_service").val(datum.id_service);$("#frm").submit(); })
			});
		</script>
		
	</body>
</html>