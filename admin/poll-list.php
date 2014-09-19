<?php
	require_once("../start.php");
	require_once("../config.php");
	require_once("db.php");
	require_once("../cls/cls_web_post.php");
	require_once("../cls/cls_web_postmeta.php");
	
	global $root_path;
	$post = new web_post();
	$postmeta = new web_postmeta();
	
	$q="";if(isset($_REQUEST["q"])) $q = addslashes($_REQUEST["q"]);
	$c="0";if(isset($_REQUEST["c"])) $c = addslashes($_REQUEST["c"]);
	$s="0";if(isset($_REQUEST["s"])) $s = addslashes($_REQUEST["s"]);
	
	
	
?>
<!DOCTYPE HTML>
<!--[if lt IE 7 ]> <html class="ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" class=""> <!--<![endif]-->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Poll Edit" />
		<meta name="Publisher" content="www.dyqaniim.com" />
		<meta name="Author" content="Besmir Alia" />
		<meta name="copyright" content="www.dyqaniim.com 2013-2015" />
		<meta name="keywords" content="" />
		<meta name="robots" content="index, follow" />
		<meta name="abstract" content="Best Company for Web Design" />
		
		<link rel="shortcut icon" href="favicon.ico" />
		<title>Lista e Anketave</title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" type="text/css" />
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		
	</head>
	<body>
		<?php include_once("menu.php");?>
		<div id="main" class="container">
			<div class="row">
				<div class="col-md-12"><a href="poll-edit.php?t=poll" class="btn btn-primary btn-success" role="button">Shto nje Ankete</a></div>
			</div>
			<div class="panel panel-default">
				<!-- Default panel contents -->
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-3 form-inline">
							<label class="sr-only" for="chk_all"></label><input type="checkbox" id='chk_all'>
							<div class="form-group">
								<select class="form-control">
									<option value='0' >Zgjidh Opsionin</option>
									<option value='1' >Modifiko</option>
									<option value='2' >Fshi</option>
								</select>
							</div>
							<button type="button" class="btn btn-default">Apliko</button>
						</div>
						<div class="col-md-4">
							<form class="form-inline pull-right" role="form">
								<div class="form-group">									
									<input type="hidden" class="form-control" id="t" name="t" value="poll">
									<input type="search" class="form-control" id="q" name="q" placeholder="Kerko" value="<?php echo $q;?>">
								</div>
								<button type="submit" class="btn btn-default">Kerko</button>
							</form>
						</div>
							<div class="col-md-2">
								<div class="btn-toolbar pull-right" role="toolbar">
									<div class="btn-group">
										<?php if($s>0) {?><a href="<?php echo '?q='.$q.'&t=poll&s='.($s-1).'&c='.$c;?>" type="button" class="btn btn-default"><span class="glyphicon glyphicon-step-backward"></span></a>
										<?}?>
										<button type="button" class="btn btn-default"><?php echo ($s+1);?></button>
										<a href="<?php echo '?q='.$q.'&t=poll&s='.($s+1).'&c='.$c;?>" type="button" class="btn btn-default"><span class="glyphicon glyphicon-step-forward"></span></a>
									</div>
								</div>
							</div>
					</div>
					
				</div>
				
				<!-- Table -->
				<table class="table table-hover">
					<?php
						$posts = $post->Find(" post_type='poll' and (title_al like '%".$q."%' or title_en like '%".$q."%') order by id_post desc limit ".($s*20).",20");
						foreach($posts as $post){
							$id = $post->id_post;
						?>
						<tr>
							<td class="col-xs-1"><label><input type="checkbox" id='chk_<?php echo $id;?>'></label></td>
							<td class="col-xs-6"><?php echo $post->title_al;?> <br/><?php echo $post->title_en;?><br/><span class="small"><a href="poll-edit.php?t=poll&id=<?php echo $id;?>" class="">Modifiko</a></span>&nbsp;|&nbsp;<span class="small"><a href="poll-edit.php?id=<?php echo $id;?>&a=delete&t=poll" class="text-danger">Fshi</a></span></td>
							<td class="col-xs-2">
								<?php 
								//start date
								?>
							</td>
							<td class="col-xs-2">
								<?php 
								//end date
								?>
							</td>
						</tr>
						<?php
						}
					?>	
				</table>
			</div>
		</div>
		
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	</body>
<html>