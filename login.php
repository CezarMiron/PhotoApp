<?php
include_once('header.php');
?>

<html>

<head>
    <title>PhotoApp</title>
      <link rel="stylesheet" type="text/css" href="CSS/styleLogin.css" /> 

  </head>

<form action="checklogin.php"  method="POST" >
  <div class="imgcontainer">
    <img src="Img/profile.jpg" alt="Avatar" class="avatar">
  </div>

  <div class="container">
    
    <label><b>Email</b></label>
    <input type="text" placeholder="Introduceti Email" name="email" required>

    <label><b>Parola</b></label>
    <input type="password" placeholder="Introduceti Parola" name="password" required>


    <button type="submit">Login</button>
    <input type="checkbox" checked="checked"> Tine-ma minte

  </div>

  <div class="container" style="background-color:#f1f1f1">
    <button onclick="location.href='index.php'" type="button" class="cancelbtn">Revocare</button>

    <span class="psw">Parola <a href="#">uitata?</a></span>
  </div>
</form>


</html>
