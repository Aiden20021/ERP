<?php

@include 'db.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:login_form.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>manager pagina</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="siu.css">

   <style>
      body {
         background-color: #bb278a; 
         color: #0099f7; 
      }
   </style>

</head>
<body>
   
<div class="container">

   <div class="content">
      <h3>Hallo, <span>Manager</span></h3>
      <h1>welcome <span><?php echo $_SESSION['admin_name'] ?></span></h1>
      <p></p>
      <a href="manger.php" class="btn">Home</a>
      <a href="register_form.php" class="btn">medewerker registreren</a>
      <a href="logout.php" class="btn">log uit</a>
   </div>

</div>

</body>
</html>