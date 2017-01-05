<?php
	
	mysql_connect("localhost", "root", "") or die (mysql_error()); 
    mysql_select_db("photoapp") or die ("Eroare DB"); 

	$image = addslashes(file_get_contents($_FILES['image']['tmp_name'])); //SQL Injection defence!
	$image_name = addslashes($_FILES['image']['name']);
	$email = $_SESSION['user'];
	$query = mysql_query("SELECT * FROM users WHERE Email = '$email'");

	while ($row = mysql_fetch_array($query))
   		$UserId = $row['UserId'];

	$sql = "INSERT INTO `photo` (`UserId`, `Image`, `ImageName`) VALUES ('{$UserId}', '{$image}', '{$image_name}')";
	if (!mysql_query($sql)) { // Error handling
    	echo "Something went wrong! :("; 
	}
?>
