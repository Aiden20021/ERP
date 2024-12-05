<?php
@include 'db.php'; 

// Maak een verbinding met de database
$conn = getConnection();

session_start();

if (isset($_POST['submit'])) {
   $gebruiksnaam = mysqli_real_escape_string($conn, $_POST['gebruiksnaam']);
   $wachtwoord = md5($_POST['wachtwoord']);
   $cpass = md5($_POST['cpassword']);
   $role = $_POST['role'];
   $achternaam = $_POST['achternaam'];

   $select = "SELECT * FROM medewerkers WHERE `gebruiksnaam` = '$gebruiksnaam'";
   $result = mysqli_query($conn, $select);

   if (mysqli_num_rows($result) > 0) {
      $error[] = 'User already exists!';
   } else {
      if ($wachtwoord != $cpass) {
         $error[] = 'Password does not match!';
      } else {
         $insert = "INSERT INTO medewerkers (gebruiksnaam, wachtwoord, role, achternaam, voornaam, Functie) 
                    VALUES ('$gebruiksnaam', '$wachtwoord', '$role', '$achternaam', '{$_POST['voornaam']}', '{$_POST['Functie']}')";
         mysqli_query($conn, $insert);
         header('location:login_form.php');
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>registreren</title>

   <link rel="stylesheet" href="css/style.css">

   <style>
      .navbar {
         background-color: #f1f1f1;
         overflow: hidden;
      }

      .navbar a {
         float: left;
         display: block;
         color: #333;
         text-align: center;
         padding: 14px 16px;
         text-decoration: none;
         font-size: 18px;
      }

      .navbar a:hover {
         background-color: #ddd;
      }

      .active {
         background-color: #666;
         color: white;
      }

      .back-btn {
         margin-right: 10px;
      }
   </style>
</head>
<body>

<div class="navbar">
   <a href="admin_page.php" class="back-btn">Terug</a>
   <a href="login_form.php">Log in</a>
</div>

<div class="form-container">
   <form action="" method="post">
      <h3>registreren</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         }
      }
      ?>
      <input type="text" name="voornaam" required placeholder="Voer uw naam in"> 
      <input type="text" name="achternaam" required placeholder="Voer uw achternaam in"> 
      <input type="text" name="Functie" required placeholder="Voer uw functie in"> 

      <input type="text" name="gebruiksnaam" required placeholder="Voer uw gebruiksnaam in">
      <input type="password" name="wachtwoord" require placeholder="Stel uw wachtwoord in">
      <input type="password" name="cpassword" required placeholder="Bevestig uw wachtwoord">
      <select name="role">
         <option value="user">Medewerker</option>
         <option value="admin">Manager</option>
      </select>
      <input type="submit" name="submit" value="registreren" class="form-btn"> 
   </form>
</div>

</body>
</html>
