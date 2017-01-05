<?php
//if(isset($_SESSION['user']) ) {

	session_start();

	mysql_connect("localhost", "root", "") or die (mysql_error()); 
    mysql_select_db("photoapp") or die ("Eroare DB");

	$email = $_SESSION['user'];
	$query = mysql_query("SELECT * FROM users WHERE Email = '$email'");
	while($row = mysql_fetch_array($query))
		$UserId = $row['UserId'];

 

    if($_SERVER["REQUEST_METHOD"] == "GET") {
    	$PhotoId = mysql_real_escape_string($_GET['like']);
    	//echo $PhotoId;
    	$query = mysql_query(
    			"UPDATE commlike SET Likes = 0 WHERE (UserId = '$UserId') AND (PhotoId = '$PhotoId') "
    		);
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {

    	$PhotoId = mysql_real_escape_string($_POST['like']);
    	//echo $PhotoId;

    	$query = mysql_query(
    			"UPDATE commlike SET Likes = 1 WHERE (UserId = '$UserId') AND (PhotoId = '$PhotoId') "
    		);

    	if (mysql_affected_rows() == 0) {
    		//	echo "HERE";
    		mysql_query(
    			"INSERT INTO commlike (PhotoId,UserId,Likes) VALUES ('$PhotoId','$UserId',1) "
    		);
    		//echo mysql_affected_rows();
    	}
    }


  Print '<script>window.location.assign("feed.php");</script>';



//}
//else
//	Print '<script>window.location.assign("login.php");</script>';

?>
