<?php
include_once('header.php');

if(isset($_SESSION['user']) ) {

    mysql_connect("localhost", "root", "") or die (mysql_error()); 
    mysql_select_db("photoapp") or die ("Eroare DB"); 

	$email = $_SESSION['user'];
	$query = mysql_query(
		"SELECT UserId FROM users WHERE Email = '$email' "
		);
	while($row = mysql_fetch_array($query))
		$UserId = $row ['UserId'];

	$query = mysql_query(" 

		SELECT P.Image, P.PhotoId, U.Email
		FROM photo P
		INNER JOIN users U ON P.UserId = U.UserId
		WHERE P.UserId NOT IN (
    		SELECT UserId FROM users
    		WHERE UserId = '$UserId')

	  ");

    $images = array(); //pun img cu informatiile ei
    $info = array(); //adun info de la poze
    $count = array(); //numar cate comm are o poza
    $countLikeArray = array(); //nr like urile
    $likesVect = array(); //verific daca utilizatorul a dat deja like sau nu

    while ($row = mysql_fetch_assoc($query)) {

      $k = 0;
      $countLike = 0;
      $bd_img = $row['Image'];
      $PhotoId = $row['PhotoId'];
      $Email = $row ['Email'];

      $aux1 = array(
                      "Image" => $bd_img,
                      "PhotoId" => $PhotoId,
                      "Email" => $Email    
                    );


      array_push($images, $aux1);
      $alreadyLiked = 0;


      $query1 = mysql_query("
        SELECT CL.Comm, CL.Likes, U.Nume, U.Email
        FROM commlike CL
        INNER JOIN users U ON CL.UserId = U.UserId
        WHERE CL.PhotoId = '$PhotoId'
      ");

      while ($row = mysql_fetch_assoc($query1)) { //creez vectorul de detine informatii despre fiecare imagine in parte

        $Comm = $row['Comm']; //if($PhotoId == 16){echo $Comm;}
        $Likes = $row['Likes'];
        $Nume = $row['Nume'];
        $EmailQry = $row ['Email'];
       // if($PhotoId == 16){echo $Comm;echo $Likes;echo $Nume;echo $EmailQry;echo $email;}
       // if($PhotoId == 16) {$Comm = "DE TEST";}
        if($Likes == 1) {
          $countLike = $countLike + 1;
        }

        if($EmailQry == $email) {
        	$Nume = "Dvs";
        	if($Likes == 1) {
        		$alreadyLiked = 1;
        	}
        }


      $aux = array(
                      "Comm" => $Comm,
                      "Likes" => $Likes,
                      "Nume" => $Nume
                
                    );
      $k = $k + 1;
/*
      if(empty($Comm)) {
      	$aux = null;
      }
*/
      array_push($info, $aux);
    }

    $count[] = $k; //retin cate comentarii / likes exista pe fiecare poza
    $countLikeArray[] = $countLike;
    $likesVect[] = $alreadyLiked;

  }
//  echo  $info[0]["Comm"];
//  echo  $info[1]["Comm"];
//  echo  $info[2]["Comm"];



}

else
	Print '<script>window.location.assign("login.php");</script>';
?>
<html> 
    <?php $m = 0; for($i = 0; $i < sizeof ($images); $i = $i + 1): ?>
  <center>
    <div class="group">
      <div class="left">
        <img src="data:image/jpg;base64,<?php echo base64_encode($images[$i]["Image"]);?>" style="width:500px">
      </div>
      <div class="right">
        <label> Poza lui : <?php echo $images[$i]["Email"]; ?> </label><br/><br/>   <!-- evidentiez a cui poza afisez -->

        <?php for($k = $m; $k < $m + $count[$i]; $k = $k + 1): ?>

          <?php $apreciez = " apreciaza "; ?>
          <?php if($info[$k]["Nume"] == "Dvs") { $apreciez = " apreciati "; } ?>
          <?php if($info[$k]["Nume"] == "Dvs" && $info[$k]["Comm"] == NULL) { ?>
          		<form action = "addcomm.php" method = "POST">
	          		<label><b>Comenteaza : </b></label>
	    			<input type = "text" placeholder = "Introduceti Comentariul" name = "Comm" required>
	    			<input type = "hidden" name = "UserId" value = "<?php echo $UserId; ?>">
	    			<input type = "hidden" name = "PhotoId" value = "<?php echo $images[$i]["PhotoId"]; ?>">
	    			<button type="submit">OK</button>
          		</form>

          	<?php } else if( !$info[$k]["Comm"] == NULL ) { ?>
          			<label><?php echo  $info[$k]["Nume"]; ?> : </label>
					<label><?php echo  $info[$k]["Comm"]; ?></label><br/>

          <?php } if($info[$k]["Likes"] == 1){ ?>  <!-- acolada e de la else -->
          			<label><?php echo  $info[$k]["Nume"]; ?> <?php echo $apreciez; ?> fotografia!</label><br/><br/>

        <?php } endfor  ?>

          <?php $m = $k; ?>

          <br/><label>Nr total likes : <b> <?php echo $countLikeArray[$i]; ?> </b></label><br/>
          <?php // echo $images[$i]["PhotoId"]; ?>
          <?php if($likesVect[$i] == 0) { ?>
          	<form action = "addlike.php" method="POST"> 
            <input type="hidden" name="like" value = " <?php echo $images[$i]["PhotoId"]; ?> ">
            <button type="submit">LIKE</button>
            </form>
          <?php } ?>

          <?php if($likesVect[$i] == 1) { ?>
          	<form action = "addlike.php" method="GET"> 
            <input type="hidden" name="like" value = "<?php echo $images[$i]["PhotoId"]; ?>">
            <button type="submit">UnLike</button>
            </form>
          <?php } ?>
        <br/><br/><br/>
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