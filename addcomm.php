<?php

	session_start();

	mysql_connect("localhost", "root", "") or die (mysql_error()); 
    mysql_select_db("photoapp") or die ("Eroare DB");

    if($_SERVER["REQUEST_METHOD"] == "POST") {

    	$PhotoId = mysql_real_escape_string($_POST['PhotoId']);
    	$UserId = mysql_real_escape_string($_POST['UserId']);
    	$Comm = mysql_real_escape_string($_POST['Comm']);

    	//echo "PHOTOID: "; echo $PhotoId;
    	//echo "UserId: "; echo $UserId;
    	//echo "Comm: "; echo $Comm;

    	$query = mysql_query(
    		"UPDATE commlike SET Comm = '$Comm' WHERE (UserId = '$UserId') AND (PhotoId = '$PhotoId') "
    	);

    	if (mysql_affected_rows() == 0) {
    		//	echo "HERE";
    		mysql_query(
    			"INSERT INTO commlike (PhotoId,UserId,Comm) VALUES ('$PhotoId','$UserId','$Comm') "
    		);
    		//echo mysql_affected_rows();
    	}
    }

	Print '<script>window.location.assign("feed.php");</script>';

?>