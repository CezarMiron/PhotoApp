<?php

	session_start();

	mysql_connect("localhost", "root", "") or die (mysql_error()); 
    mysql_select_db("photoapp") or die ("Eroare DB");

    if($_SERVER["REQUEST_METHOD"] == "POST") {

    	$PhotoId = mysql_real_escape_string($_POST['PhotoId']);
    	echo $PhotoId;

    	$query = mysql_query(
    		"
    		DELETE FROM commlike WHERE PhotoId = '$PhotoId'
    		"
    		);

    	$query1 = mysql_query(
    		"
    		DELETE FROM photo WHERE PhotoId = '$PhotoId'
    		"
    		);
    	Print '<script>window.location.assign("myinfo.php");</script>'; // 
    }

?>

