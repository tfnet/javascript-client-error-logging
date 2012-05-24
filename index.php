<?php 

/**
 * Log for JS Errors on Page
 */

include('config.inc.php');

$description = $_GET['description'];
$url = $_GET['url'];
$line = $_GET['line'];
$parent_url = $_GET['parent_url'];
$user_agent = $_GET['user_agent'];

if ((isset($description)) && (!empty($description))){
	
	$sql = 'insert into js_error(description,url,line,parent_url,user_agent) values(
				"'.mysql_real_escape_string($description,$link).'",
				"'.mysql_real_escape_string($url,$link).'",
				"'.mysql_real_escape_string($line,$link).'",
				"'.mysql_real_escape_string($parent_url,$link).'",
				"'.mysql_real_escape_string($user_agent,$link).'"
			)';
	
	$rs = mysql_query($sql,$link);
	
	echo "LOG OK";
}else{
	echo "LOG NOT OK";
}
?>