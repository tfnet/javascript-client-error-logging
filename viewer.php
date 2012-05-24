<?php
include('config.inc.php');

if ((isset($_GET['refresh'])) && (!empty($_GET['refresh']))){	
	$refresh = (int)$_GET['refresh'];	
}else{ 
	$refresh = $default_refresh;
}
$currdate = date('d.m.Y - H:i:s');
$firstrow = 0;
$mtime = explode(" ",microtime());
$starttime = $mtime[1] + $mtime[0];
unset($mtime);
?>
<html>
	<head>
		<title>Frontend Errorlog Console - <?php echo $currdate; ?></title>
		<script type="text/javascript" src="log.js"></script>
		<script type="text/javascript" src="js/jquery-1-6-1.min.js"></script>
		<script type="text/javascript" src="js/flexigrid.pack.js"></script>
		<link rel="stylesheet" type="text/css" href="css/flexigrid.pack.css" />
		<meta http-equiv="refresh" content="<?php echo $refresh; ?>">
	</head>
	<body>
	
	<script type="text/javascript">
		$(function() {		
			$('#flextable').flexigrid({	title: 'JS Error Log - <?php echo $currdate; ?> - Refresh every <?php echo $refresh; ?> Seconds',
										showTableToggleBtn: true,
										height:150,
										striped:true
									  });			  
			$('#flextable_error_log').flexigrid({ title: 'Apache Error Log - <?php echo $currdate; ?> - Refresh every <?php echo $refresh; ?> Seconds',
													showTableToggleBtn: true,
													height:150,
													striped:true
												  });
			$('#flextable_access_log').flexigrid({ title: 'Apache Access Log - <?php echo $currdate; ?> - Refresh every <?php echo $refresh; ?> Seconds',
													showTableToggleBtn: true,
													height:150,
													striped:true
												  });				  						  
		});
	</script>
	
	<table id="flextable">
		<?php
		$logtable_sql = 'select url as URL, line as Zeile, description as Beschreibung, user_agent as Agent, parent_url as Referer, max(timestamp) as Last from js_error 
				group by description,url,line,parent_url,user_agent
				order by timestamp DESC
				LIMIT 0,50';
		
		$res = mysql_query($logtable_sql,$link);		
		while($row = mysql_fetch_assoc($res)){				
			if ($firstrow == 0){
				echo '<thead>';
				foreach ($row as $key => $value) {			
					switch ($key) {
						case 'Beschreibung':
							$thwidth = 320;
							break;				
						case 'Zeile':
							$thwidth = 40;
							break;
						case 'Last':
							$thwidth = 145;
							break;
						case 'URL':
							$thwidth = 320;
							break;
						case 'Referer':
							$thwidth = 320;
							break;										
						default:
							$thwidth = 220;
						break;
					}			
					echo '<th width="'.$thwidth.'">'.$key.'</th>';
				}
				echo '</thead>';
				echo '<tbody>';		
				$firstrow =1;
			}
			
			echo "<tr>";
				foreach ($row as $key => $value) {
					echo '<td>'.$value.'</td>';
				}
			echo "</tr>";
		}
		?>
		</tbody>
	</table>
	
	<br/>
	
	<table id="flextable_error_log">
	<thead>
	<th>Error Log Meldungen</th>
	</thead>
	<tbody>
	<?php
		$file = '/var/log/httpd/error_log';
		$afile_array = file($file);
		$i=0;
		foreach (array_reverse($afile_array) as $value) {
			echo '<tr>';
			echo '<td>'.$value.'</td>';
			echo '</tr>';
			if ($i >= 50){
				break;
			}
		}
		unset($afile_array);
	?>	
	</tbody>
	</table>
	
	<br/>
	
	<table id="flextable_access_log">
	<thead>
	<th>Access Log Meldungen</th>
	</thead>
	<tbody>
	<?php
		$file = '/var/log/httpd/access_log';
		$afile_array = file($file);
		$i=0;
		foreach (array_reverse($afile_array) as $value) {			
			if (strpos($value,'viewer.php') == false) {
				echo '<tr>';
				echo '<td>'.$value.'</td>';
				echo '</tr>';
				if ($i >= 50){
					break;
				}
			}
		}
		unset($afile_array);
	?>	
	</tbody>
	</table>
	<?php 
		$mem_usage = memory_get_usage(true); 
		echo 'Script Mem:'.round($mem_usage/1048576,2)." megabytes";
		echo '<br/>';
		$mem_usage = memory_get_peak_usage(true); 
		echo 'Script Max Mem:'.round($mem_usage/1048576,2)." megabytes";
		$mtime = explode(" ",microtime());
		$endtime = $mtime[1] + $mtime[0];
		$totaltime = ($endtime - $starttime);
		echo '<br/>';
		echo "Script Runtime: ".round($totaltime,4)." seconds";  	
	?>	
	</body>
</html>