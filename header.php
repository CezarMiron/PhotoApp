	<link rel="stylesheet" type="text/css" href="CSS/style.css" /> 

		<ul>
 			 <?php session_start();
 			 
 			 if(isset($_SESSION['user']) ) { $a = $_SESSION['user']; ?> <!--verific daca exista deja un user pentru a afisa campurile corespunzatoare -->
 			  
 			 	<li><a class="active" href="feed.php">Noutati</a></li>
 				<li><a href="index.php">Informatii</a></li>

 			 	<li><a href="contact.php">Contact</a></li>
  				<li style="float:right"><a href="logout.php">Logout</a></li>
  				<li style="float:right"><a href="myinfo.php">Salut, <?php echo"$a" ?></a></li> 
  			 
  			 <?php 
  			 }  else { ?>

  			<li><a class="active" href="index.php">Informatii</a></li>
 				
 			 	<li><a href="contact.php">Contact</a></li>
  				<li style="float:right"><a href="login.php">Login</a></li>
  			 	<li style="float:right"><a href="register.php">Inregistrare</a></li>

  			<?php } ?>


 		</ul>
 		<br/>


