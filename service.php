<?php 
	//implement location logic
	
    require_once("start.php");
    require_once("config.php");
    require_once("db.php");
    //require_once("check.php");
    //include_once("cls/security.php");
    include_once("cls/cls_web_category.php");
    include_once("cls/cls_web_service.php");
    //$security = new Security();
	global $link;
    
    //if(!$security->IsAuthorized("SERVICE-ADD")) { die( 'Ju nuk jeni te autorizuar te aksesoni kete faqe! <a href="login.php">Login perseri</a>' );}
	$service = new web_service();
	
	$action = isset($_REQUEST["action"])?addslashes($_REQUEST["action"]):"new";
	$id = isset($_REQUEST["id"])?addslashes($_REQUEST["id"]):0;
	//$lat = isset($_REQUEST["map_lat"])?addslashes($_REQUEST["map_lat"]):0;
	//$lng = isset($_REQUEST["map_lng"])?addslashes($_REQUEST["map_lng"]):0;
	
	
	if($id == 0 && $action=="add"){
		
		
		$service->id_parent=null;
		$service->id_category=addslashes($_REQUEST["id_category"]);
		$service->service_name=addslashes($_REQUEST["service_name"]);
		$service->service_desc=addslashes($_REQUEST["service_desc"]);
		$service->service_nipt=addslashes($_REQUEST["service_nipt"]);
		$service->service_email=addslashes($_REQUEST["service_email"]);
		$service->service_mobile=addslashes($_REQUEST["service_mobile"]);
		$service->service_address=addslashes($_REQUEST["service_address"]);
		$service->service_rating=0;
		$service->map_lat=addslashes($_REQUEST["map_lat"]);
		$service->map_lng=addslashes($_REQUEST["map_lng"]);
		$service->service_hours=addslashes($_REQUEST["service_hours"]);
		$service->service_img=addslashes($_REQUEST["service_img"]);
		$service->dt_created=date("Y-m-d H:i:s");
		$service->id_user=$_SESSION["id_user"];
		$service->id_status=1;
		$service = $service->Insert();
		header("Location:service.php?action=edit&id=".$service->id_service);
		die();
		
	}else if($id > 0 && $action=="update"){
		
		$service = new web_service();
		$service = $service->get_by_id_service($id);
		$service->id_parent=null;
		$service->id_category=addslashes($_REQUEST["id_category"]);
		$service->service_name=addslashes($_REQUEST["service_name"]);
		$service->service_desc=addslashes($_REQUEST["service_desc"]);
		$service->service_nipt=addslashes($_REQUEST["service_nipt"]);
		$service->service_email=addslashes($_REQUEST["service_email"]);
		$service->service_mobile=addslashes($_REQUEST["service_mobile"]);
		$service->service_address=addslashes($_REQUEST["service_address"]);
		//$service->service_rating=0;
		$service->map_lat=addslashes($_REQUEST["map_lat"]);
		$service->map_lng=addslashes($_REQUEST["map_lng"]);
		$service->service_hours=addslashes($_REQUEST["service_hours"]);
		$service->service_img=addslashes($_REQUEST["service_img"]);
		//$service->dt_created=date("Y-m-d H:i:s");
		//$service->id_user=$_SESSION["id_user"];
		//$service->id_status=1;
		$service = $service->Update();
		header("Location:service.php?action=edit&id=".$service->id_service);
		die();

	}else if($action=="new"){
		$action="add";
	}else if($action=="edit"){
		$action="update";
		$service = new web_service();
		$service = $service->get_by_id_service($id);
	}
	else if($id > 0 && $action=="remove"){
		$service = new web_service();
		$service = $service->get_by_id_service($id);
		$service->id_status=0;
		$service->Update();
	}else if($id >= 0 && $action=="list"){
		$query = "select id_service,service_name, map_lat as lat, map_lng as lng, service_mobile, service_email, service_rating, service_img FROM web_service where '". $id."'='0' or id_service='". $id."'";
		$res     = mysql_query($query, $link) or die(mysql_error());
		$results = array();
		while ($row = mysql_fetch_array( $res )) {
		  // All results onto a single array
		  $results[] = $row;
		}
		// Supply header for JSON mime type
		header("Content-type: application/json");
		// Depending on how you want the JSON to look, you may wish to use
		// JSON_FORCE_OBJECT
		echo json_encode($results);
		mysql_close($link);die();
	}
	
?>

<!doctype html>  

<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    
	<title>Vendosja e sherbimeve ne harte</title>
    <meta name="description" content="Map services on Google Map">
    <meta name="author" content="Besmir ALIA">
    <meta name="viewport" content="width=device-width, user-scalable=no" />
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/simplex/bootstrap.min.css" type="text/css" />
    <style type="text/css">

        html{color:#000;background:#FFF;}
		body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,code,form,fieldset,legend,input,textarea,p,blockquote,th,td{margin:0;padding:0;}
		table{border-collapse:collapse;border-spacing:0;}
		fieldset,img{border:0;}
		address,caption,cite,code,dfn,em,strong,th,var{font-style:normal;font-weight:normal;}
		li{list-style:none;}
		caption,th{text-align:left;}
		h1,h2,h3,h4,h5,h6{font-size:100%;font-weight:normal;}
		q:before,q:after{content:'';}
		abbr,acronym{border:0;font-variant:normal;}
		sup{vertical-align:text-top;}
		sub{vertical-align:text-bottom;}
		input,textarea,select{font-family:inherit;font-size:inherit;font-weight:inherit;}
		input,textarea,select{*font-size:100%;}
		legend{color:#000;}
        
        /* Mine */
        body { font-family: Helvetica, Arial, sans-serif; font-size: 12px; }
        div#map { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
        form#options { display:none;position: absolute; bottom: 5px; right: 10px; background: #fff; border: 1px solid #666; padding: 3px 5px; width: 300px;}
        form#options input,select{ display:block;}
        form#options em { margin: 0 10px; color: #666; }
		div.info {display:block;width:350px;}
		div.infobuttons {padding:5px;}
		div.infobuttons a{padding:3px;background-color:#3366FF;color:#fff;text-decoration:none;}
		div.info img{width:300px;border:0;}
		
    </style>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script><!--http://maps.google.com/maps/api/js?sensor=false-->
    
    <script type="text/javascript">
	$(function() {
		var opts = {
			zoom: 15,
			center: new google.maps.LatLng(40.902667,20.659189), // Tirane
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		var map = new google.maps.Map(document.getElementById('map'), opts);
		

		google.maps.event.addListener(map, 'click', addMarkerHandler);
		$('#id').change(function() {window.location="?action=edit&id="+$("#id").val();});
		
		var oldMarkers = [];
		var userinterval = null;
		var tmout = null;
		var infoW = new google.maps.InfoWindow();
		
		function hideInfo()
		{
			infoW.close();
		}
		
		function addMarkerHandler (e) {
			var lat = e.latLng.lat();
			var lng = e.latLng.lng();
			$("#map_lat").val(lat);
			$("#map_lng").val(lng);
			marker = new google.maps.Marker({
				position: new google.maps.LatLng(lat, lng),
				icon: {
					path: google.maps.SymbolPath.BACKWARD_CLOSED_ARROW,
					scale: 5,
					fillColor : "#FF0000",
					fillOpacity: 0.9,
					strokeWeight: 2,
					strokeColor: "white",
				},
				animation: google.maps.Animation.BOUNCE,
				draggable:true,
				map: map,
				title : "Ofrues i ri" 
			});
			oldMarkers.push( marker );
			$("#action").val("add");
			$("#options").show();
			google.maps.event.addListener(marker, 'rightclick', markerDestructionHandler);
			google.maps.event.addListener(marker, 'mouseover', function(e){
				//tooltip.show($("#id option:selected").text());
			});
			google.maps.event.addListener(marker, 'dragend', function(e){
				$("#map_lat").val(e.getLat());
				$("#map_lng").val(e.getLng());
			});
			
		};     
		
		
		function markerDestructionHandler (e) {
			//if($("#id").val()==0){alert("Kliko me butonin e majte per te zgjedhur dyqanin, me pas provoje ta heqesh perseri");return false;}
			if(window.confirm("Jeni te sigurte qe doni ta hiqni kete zone?")){
		
				this.setMap(null);

			}
		};
		
		function loadService(id){
			$.getJSON('service.php',{action:"list",id:id}, function(data) {
				//var items = [];
				//alert(data.rad);
				$.each(data, function(key, val) {
					
					var marker = new google.maps.Marker({
						position: new google.maps.LatLng(val.lat, val.lng),
						icon: {
							path: google.maps.SymbolPath.BACKWARD_CLOSED_ARROW,
							scale: 7,
							fillColor : "#FF0000",
							fillOpacity: 0.9,
							strokeWeight: 2,
							strokeColor: "white",
						},
						animation: google.maps.Animation.DROP,
						map: map,
						title : val.service_name 
					});
					oldMarkers.push( marker );
					
					//google.maps.event.addListener(marker, 'rightclick', markerDestructionHandler);
					google.maps.event.addListener(marker, 'mouseover', function(e){
						clearTimeout(tmout);
						if (infoW) infoW.close();
						infoW = new google.maps.InfoWindow({content: "<div class='info'><h2>" + val.service_name + "</h2><br/><img src='"+val.service_img+"' /><br/>Tel: " + val.service_mobile + "<br/>Email: " + val.service_email + "<br/>Yje... (m) :" + val.service_rating + "<div class='infobuttons'><a href='?action=edit&id="+val.id_service+"'>Modifiko</a><a href='?action=remove&id="+val.id_service+"'>Fshij</a></div></div>", maxWidth: 350});
						infoW.open(map, this);
					});
					google.maps.event.addListener(marker, 'mouseout', function(e){
						tmout = setTimeout(hideInfo,3000);
					});
					google.maps.event.addListener(marker, 'click', function(e){window.location="?action=edit&id="+val.id_service;this.setAnimation(google.maps.Animation.BOUNCE);});					
					map.panTo(new google.maps.LatLng(val.lat,val.lng));
					<?php if($id>0){?>
					$("#options").show();
					google.maps.event.addListener(marker, 'dragend', function(e){
						$("#map_lat").val(e.latLng.lat());
						$("#map_lng").val(e.latLng.lng());
					});
					<?php }?>
				});
				
				//if(id>0)
				//	userinterval = self.setInterval(function(){getLastUser(id);},10000);
				map.setZoom(15);
			});
		}
		<?php echo "loadService('".$id."');";?>
		
	});
    </script>
</head>

<body>
    <div id="map"></div>
	<form id="options" action='' method='post' role="form">
		<input type="hidden" name="action" value="<?php echo $action;?>" />
		<div class="form-group"><label for="id_category">Kategoria</label> 
		<select id="id_category" name="id_category" class="form-control">
			<?php 
				$cats = new web_category();
				$catlist = $cats->Find("id_status=1 order by category_order");
				foreach($catlist as $cat){
					echo "<option class='".$cat->category_class."' value='".$cat->id_category."'";
					if($cat->id_category==$service->id_category) echo " selected='selected'";
					echo ">".$cat->category_name."</option>";
				}
            ?>
        </select></div>
		<div class="form-group"><label for="service_name">Emri</label> <input type="text" value="<?php echo $service->service_name;?>" id="service_name" name="service_name" class="form-control input-sm" /></div>
        <div class="form-group"><label for="service_desc">Pershkrimi</label> <input type="text" value="<?php echo $service->service_desc;?>" id="service_desc" name="service_desc" class="form-control input-sm" /></div>
        <div class="form-group"><label for="service_address">Adresa</label> <input type="text" value="<?php echo $service->service_address;?>" id="service_address" name="service_address" class="form-control input-sm" /></div>
        <div class="form-group"><label for="service_mobile">Telefon</label> <input type="text" value="<?php echo $service->service_mobile;?>" id="service_mobile" name="service_mobile" class="form-control input-sm" /></div>
        <div class="form-group"><label for="service_email">Email</label> <input type="text" value="<?php echo $service->service_email;?>" id="service_email" name="service_email" class="form-control input-sm" /></div>
        <div class="form-group"><label for="service_nipt">Nipt/ID</label> <input type="text" value="<?php echo $service->service_nipt;?>" id="service_nipt" name="service_nipt" class="form-control input-sm" /></div>
		<div class="form-group"><label for="service_hours">Orari</label> <input type="text" value="<?php echo $service->service_hours;?>" id="service_hours" name="service_hours" class="form-control input-sm" /></div>
		<div class="form-group"><label for="service_img">Foto</label> <input type="text" value="<?php echo $service->service_img;?>" id="service_img" name="service_img" class="form-control input-sm" /></div>
		<div class="form-group"><label for="map_lat">Lat</label> <input type="text" value="<?php echo $service->map_lat;?>" id="map_lat" name="map_lat" class="form-control input-sm" /></div>
		<div class="form-group"><label for="map_lng">Lng</label> <input type="text" value="<?php echo $service->map_lng;?>" id="map_lng" name="map_lng" class="form-control input-sm" /></div>        
		
		<div class="form-group"><label for="id">Sherbimet aktuale
			<select id="id" name="id" class="form-control">
				<option value="0">Shfaq te gjithe sherbimet</option>
					<?php
					$query = "select id_service, service_name from web_service order by service_name";
					$res = mysql_query($query, $link);
					while($r = mysql_fetch_array($res))
					{
						$sel="";if($r["id_service"]==$id) $sel = "selected='selected'";
					?>
					<option value="<?php echo $r["id_service"];?>" <?php echo $sel;?>><?php echo $r["service_name"];?></option>
					<?php
					}
					
				?>
			</select>
		</label></div>
		<div class="form-group">
			<button type="submit" class="btn btn-xs">Ruaj</button>
		<?php if($id) {?><a type="button" class="btn btn-xs" href='#' title="Ploteso te dhenat shtese">Te dhenat shtese</a><?php }?>
		</div>
		
		<em>Kliko mbi harte per te shtuar nje sherbim te ri.</em><br/>
		<a href='index.php' title="Kthehu ne faqen kryesore">Faqja kryesore</a>
    </form>
</body>
</html>
<?php mysql_close($link);?>