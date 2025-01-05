<?php
session_start();

// Controleer of de gebruiker is ingelogd als admin of medewerker
if (!isset($_SESSION['admin_name']) && !isset($_SESSION['user_name'])) {
    header('location:index.html'); 
    exit();
}
?>

<?php

@include 'db.php';



if(!isset($_SESSION['user_name'])){
   header('location:login_form.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>medewerker pagina</title>

 
   <link rel="stylesheet" href="css/style.css">
   <style>
      body {
         background-color: #f5af19; 
         color: #0099f7; 
      }
   </style>
</head>
<body>
   
<div class="container">

   <div class="content">
      <h3>Hallo, <span>Medewerker</span></h3>
      <h1>welcome <span><?php echo $_SESSION['user_name'] ?></span></h1>
      <p></p>
      <a href="uren.php" class="btn">Home</a>
      <a href="logout.php" class="btn">logout</a>
   </div>

</div>

</body>
</html>