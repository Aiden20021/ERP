<?php
@include 'db.php'; 

session_start();

// Maak een verbinding met de database
$conn = getConnection();

if (isset($_POST['submit'])) {
    $gebruiksnaam = mysqli_real_escape_string($conn, $_POST['gebruiksnaam']);
    $wachtwoord = md5($_POST['wachtwoord']);

    $select = "SELECT * FROM medewerkers WHERE gebruiksnaam = '$gebruiksnaam' AND wachtwoord = '$wachtwoord'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        if ($row['role'] == 'admin') {
            $_SESSION['admin_name'] = $row['gebruiksnaam'];
            $_SESSION['achternaam'] = $row['achternaam'];
            header('location:admin_page.php');
        } else {
            $_SESSION['user_name'] = $row['gebruiksnaam'];
            $_SESSION['voornaam'] = $row['voornaam'];
            header('location:user_page.php');
        }
    } else {
        $error[] = 'Onjuiste gebruiksnaam of wachtwoord!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Inlog form</title>
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="form-container">
   <form action="" method="post">
      <h3>Log In</h3>
      <?php
      if (isset($error)) {
         foreach ($error as $errorMsg) {
            echo '<span class="error-msg">' . $errorMsg . '</span>';
         }
      }
      ?>
      <input type="text" name="gebruiksnaam" required placeholder="Voer uw gebruiksnaam in">
      <input type="password" name="wachtwoord" required placeholder="Voer uw wachtwoord in">
      <input type="submit" name="submit" value="Inloggen" class="form-btn">
   </form>
</div>
</body>
</html>
