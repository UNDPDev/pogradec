<?php 
	require_once("start.php");
	require_once("config.php");
	require_once("db.php");
	
	$sql="";
	if (isset($_POST['sql_query'])){
		$sql=$_POST['sql_query'];	
		$sql=stripslashes($sql);
	}
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Advanced</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link href="http://static.bshpejt.com/p/js/dyqaniim/ui.all.css" type="text/css" rel="stylesheet">
	</head>
	
	<body>
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td colspan="3">
					<form name="sql" method="post" action="" >
						<textarea rows=5 cols=120 name="sql_query"><?php echo $sql;?></textarea>
						<input TYPE="SUBMIT" VALUE="Go" CLASS="buton">
					</form>
					<?php
						$start_time=microtime();
						if(isset($sql) && strlen($sql)){
							if(strpos($sql,";"))
							{
								$sql=explode(";",$sql);
								for($i=0;$i<count($sql)-1;$i++)
								{
									if($sql[$i])$res=mysql_query($sql[$i]) or die(mysql_error());
								}
							}
							else $res=mysql_query($sql) or die(mysql_error());
							$end_time=microtime();
							$interval=$end_time-$start_time;
							$nr_rows=mysql_num_rows($res);
							$nr=mysql_num_fields($res);
							echo "<span style='color:white'>".$interval." sec ".$nr_rows." rreshta</span>";
							
							echo '<table border=1 class="" width="100%" cellpadding="0" cellspacing="0">';
							echo '<tr >';
							for($i=0;$i<$nr;$i++)echo '<td class="ui-widget-header">'.mysql_field_name($res,$i).'</td>';
							echo '</tr>';
							if($nr){
								while($r=mysql_fetch_array($res))
								{
									echo '<tr>';
									for ($i=0;$i<$nr;$i++)
									{
										echo '<td class="ui-widget-content">'.$r[$i].'</td>';
									}
									echo '</tr>';
									
								}
							}
							echo '</table>';		
						}
						
						
					?>	</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>
	</body>
</html>
<?php mysql_close();?>