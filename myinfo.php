<?php
include_once('header.php');
?>

<?php 	


  if(isset($_SESSION['user']) ) {

 			$a = $_SESSION['user'];
 			echo "Salut, $a ";

      if($_SERVER["REQUEST_METHOD"] == "POST") { //inserez poza in BD
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

      }

 		}
 		else
 			Print '<script>window.location.assign("login.php");</script>';
 	
 	$email = $_SESSION['user'];

    
   mysql_connect("localhost", "root", "") or die (mysql_error()); 
   mysql_select_db("photoapp") or die ("Eroare DB"); 


    $query = mysql_query("Select * from users WHERE Email='$email'"); 

    while($row = mysql_fetch_assoc($query)) // afisez toate campurile
       {
          $nume = $row['Nume']; 
          $prenume = $row['Prenume']; 
          $UserId = $row['UserId'];
  
       }

    $query = mysql_query(" SELECT * FROM photo WHERE UserId = '$UserId'  ");

    $images = array();
    $info = array();
    $count = array();
    $countLikeArray = array();

    while ($row = mysql_fetch_assoc($query)) {

      $k = 0;
      $countLike = 0;
      $bd_img = $row['Image'];
      $PhotoId = $row['PhotoId'];

      $aux1 = array(
                      "Image" => $bd_img,
                      "PhotoId" => $PhotoId         
                    );


      array_push($images, $aux1);


      $query1 = mysql_query("
        SELECT CL.Comm, CL.Likes, U.Nume
        FROM commlike CL
        INNER JOIN users U ON CL.UserId = U.UserId
        WHERE CL.PhotoId = '$PhotoId'
      ");

      while ($row = mysql_fetch_assoc($query1)) { //creez vectorul de detine informatii despre fiecare imagine in parte

        $Comm = $row['Comm'];
        $Likes = $row['Likes'];
        $Nume = $row['Nume'];

        if($Likes == 1) {
          $countLike = $countLike + 1;
        }


      $aux = array(
                      "Comm" => $Comm,
                      "Likes" => $Likes,
                      "Nume" => $Nume
                
                    );
      $k = $k + 1;

      array_push($info, $aux);
    }

    $count[] = $k; //retin cate comentarii / likes exista pe fiecare poza
    $countLikeArray[] = $countLike;

  }

   
 ?>
<html>
	<head>
		<title>PhotoApp</title>
	</head>
	<br/><br/><b>Datele tale sunt : </b><br/><br/>

	Nume : <?php echo "$nume"; ?> <br/>
	Prenume : <?php echo "$prenume"; ?> <br/>
	Email : <?php echo "$email"; ?> <br/>

  <br/><br/>
  <b> Incarca o fotografie </b><br/><br/>

  <form action="myinfo.php" method="POST" enctype="multipart/form-data">
    <label>File: </label><input type="file" name="image" />
    <input type="submit" />
  </form>

  <br/><br/>
  POZELE TALE SUNT : <br/>

    <?php for($i = 0; $i < sizeof ($images); $i=$i+1): ?>
  <center>
    <div class="group">
      <div class="left">
        <img src="data:image/jpg;base64,<?php echo base64_encode($images[$i]["Image"]);?>" style="width:500px">
      </div>
      <div class="right">
        <label> Photo Id : <?php echo $images[$i]["PhotoId"]; ?> </label><br/><br/>
        <?php for($k = 0; $k < $count[$i]; $k=$k+1): ?>

          <label><?php echo  $info[$k]["Nume"]; ?> : </label>
          <label><?php echo  $info[$k]["Comm"]; ?></label><br/>
          <?php if($info[$k]["Likes"] == 1){ ?>
          <label><?php echo  $info[$k]["Nume"]; ?> iti apreciaza fotografia!</label><br/><br/>
          <?php } endfor ?>
          <br/><label>Nr total likes : <b> <?php echo $countLikeArray[$i]; ?> </b></label>
        <br/><br/>
          <form action = "delphoto.php" method="POST">
          <input type = "hidden" name = "PhotoId" value =" <?php echo $images[$i]["PhotoId"]; ?> " >
          <button type="submit">Delete Photo</button>
          </form>
        <br/><br/>

      </div>
    </div>

    <br/>

  </center>
    
    <?php endfor ?>


	</html>


<style>

.left {
    float: left;
    width: 50%;
}
.right {
    float: right;
    width: 50%;
}
.group:after {
    content:"";
    display: table;
    clear: both;
}
img {
    max-width: 100%;
    height: auto;
}
@media screen and (max-width: 480px) {
    .left, 
    .right {
        float: none;
        width: auto;
    }
}

</style>