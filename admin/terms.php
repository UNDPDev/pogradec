<?php
	require_once("../start.php");
	require_once("../config.php");
	require_once("db.php");
	require_once("../cls/cls_web_term.php");
	require_once("../cls/cls_web_termrel.php");
	
	$term = new web_term();
	
	$q="";if(isset($_REQUEST["q"])) $q = addslashes($_REQUEST["q"]);
	$s="0";if(isset($_REQUEST["s"])) $s = addslashes($_REQUEST["s"]);
	$c="0";if(isset($_REQUEST["c"])) $c = addslashes($_REQUEST["c"]);
	$cl="";if(isset($_REQUEST["cl"])) $cl = addslashes($_REQUEST["cl"]);
	$t="category";if(isset($_REQUEST["t"])) $t = addslashes($_REQUEST["t"]);
	$a="";if(isset($_REQUEST["a"])) $a = addslashes($_REQUEST["a"]);
	$id=0;
	if(isset($_REQUEST["id"])) $id = addslashes($_REQUEST["id"]);
	
	if($id){
		$term = $term->get_by_id_term($id);
		if(!$c) $c = $term->term_parent;
		$t = $term->term_type;
	}
	
	if($a=="delete"){
		$term->Delete();
		header("Location:terms.php?t=".$t);die();
	}
	if($_POST){
		$term->term_al=$_POST["term_al"];
		$term->term_en=$_POST["term_en"];
		$term->term_parent=$c;
		$term->term_class=$cl;
		$term->term_type=$t;
		
		if($id==0){ //insert
			$term = $term->Insert();
			$id = $term->id_post;
			}else{ //update
			$term = $term->Update();
		}
		header("Location:terms.php?t=".$t);die();	
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
		<meta name="description" content="Terms Edit" />
		<meta name="Publisher" content="www.dyqaniim.com" />
		<meta name="Author" content="Besmir Alia" />
		<meta name="copyright" content="www.dyqaniim.com 2013-2015" />
		<meta name="keywords" content="" />
		<meta name="robots" content="index, follow" />
		<meta name="abstract" content="Best Company for Web Design" />
		
		<link rel="shortcut icon" href="favicon.ico" />
		<title>Lista e termave</title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" type="text/css" />
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		
	</head>
	<body>
		<?php include_once("menu.php");?>
		<div id="main" class="container">
			<ol class="breadcrumb">
				<li><a href="./">Home</a></li>
				<li><a href="terms.php?t=<?php echo $t;?>"><?php echo ucwords($t);?></a></li>
			</ol>
			<div class="row">
				<div class="col-md-3">
					<form role="form" method="post">
						<div class="form-group">
							<label for="term_al">Titulli AL</label>
							<input type="text" class="form-control" id="term_al" name="term_al" placeholder="Titulli AL" value="<?php echo $term->term_al;?>">
						</div>
						<div class="form-group">
							<label for="term_en">Titulli EN</label>
							<input type="text" class="form-control" id="term_en" name="term_en" placeholder="Titulli EN" value="<?php echo $term->term_en;?>">
						</div>
						<div class="form-group">
							<label for="term_en">Class</label>
							<input type="text" class="form-control" id="cl" name="cl" placeholder="Class" value="<?php echo $term->term_class;?>">
						</div>
						<div class="form-group">
							<label for="parent">Parent</label>
							<select class="form-control" name="c" id="parent" >
								<option value='0' >No Parent</option>
								<?php							
									$terms = $term->Find("term_type='".$t."' order by term_parent");
									foreach($terms as $tr){
										$selected ="";
										
										if($tr->id_term == $c) 
										$selected = ' selected="selected"';
										echo "<option value='".$tr->id_term."' ".$selected .">".$tr->term_al."</option>";
									}
								?>
							</select>
						</div>
						<button type="submit" class="btn btn-success">Ruaj</button>
					</form>
				</div>
				<div class="col-md-9">
					<div class="panel panel-default">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<div class="row">
								<div class="col-md-4 form-inline">
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
								<div class="col-md-6">
									<form class="form-inline pull-right" role="form">
									<input type='hidden' name='t' value='<?php echo $t;?>' />
										<div class="form-group">									
											<input type="search" class="form-control" id="q" name="q" placeholder="Kerko" value="<?php echo $q;?>">
										</div>
										<button type="submit" class="btn btn-default">Kerko</button>
									</form>
								</div>
								<div class="">
									
								</div>
							</div>
							
						</div>
						
						<!-- Table -->
						<table class="table table-hover">
							<?php
							function display_terms($id,$j){
								global $term;
								global $t;
								global $q;
								global $s;
								
								$sql="term_type='".$t."' and term_parent=".$id."";
								if($q) {$sql="term_type='".$t."' and (term_al like '%".$q."%' or term_en like '%".$q."%' ) ";$q="";}
								
								$terms = $term->Find($sql." limit $s,50");
								foreach($terms as $term){
									$id = $term->id_term;
								?>
								<tr>
									<td class="col-md-5">
									<label><input type="checkbox" id='chk_<?php echo $id;?>'></label>
									<?php for($i=0;$i<$j;$i++) echo "- ";?><?php echo $term->term_al;?> 
									</td>
									<td class="col-md-4"><?php echo $term->term_en;?></td>
									<td class="col-md-1"><?php echo $term->term_class;?></td>
									<td class="col-md-2"><a href="terms.php?id=<?php echo $id;?>" class="">Modifiko</a>&nbsp;|&nbsp;<a href="terms.php?a=delete&id=<?php echo $id;?>" class="text-danger">Fshi</a></td>
								</tr>
								<?php	
								
								display_terms($id,$j+1);
								}
							}
							display_terms(0,0);
							?>	
						</table>
						<div class="panel-footer">
							<div>
								<ul class="pagination pagination-sm">
									<li class="previous disabled"><a href="#">&larr;&nbsp;</a></li>
									<li class="next"><a href="#">&nbsp;&rarr;</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
			<script src="js/holder.js"></script>
		</body>
	<html>				