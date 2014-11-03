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
	
	if($id >= 0 && $action=="list"){
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
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script><!--http://maps.google.com/maps/api/js?sensor=false-->
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
		div.info img{width:300px;border:0;}
		
		
    </style>
    
    <script type="text/javascript">
	$(function() {
		var opts = {
			zoom: 15,
			center: new google.maps.LatLng(40.902667,20.659189), // Tirane
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		var map = new google.maps.Map(document.getElementById('map'), opts);
		
		
		var oldMarkers = [];
		var userinterval = null;
		var tmout = null;
		var infoW = new google.maps.InfoWindow();
		
		function hideInfo()
		{
			infoW.close();
		}
		
		
		function loadService(id){
			$.getJSON('index.php',{action:"list",id:id}, function(data) {
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
						infoW = new google.maps.InfoWindow({content: "<div class='info'><h2>" + val.service_name + "</h2><br/><img src='"+val.service_img+"' /><br/>Tel: " + val.service_mobile + "<br/>Email: " + val.service_email + "<br/>Yje... (m) :" + val.service_rating + "", maxWidth: 350});
						infoW.open(map, this);
					});
					google.maps.event.addListener(marker, 'mouseout', function(e){
						tmout = setTimeout(hideInfo,3000);
					});
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
	
</body>
</html>
<?php mysql_close($link);?>