<?php
session_start();

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['admin_name'])) {
    header('location:index.html');
    exit();
}
?>

<?php
@include 'db.php'; 

// Maak een verbinding met de database
$conn = getConnection();


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

   /* Style for password strength meter */
   .strength-msg {
      margin-top: 10px;
      font-size: 14px;
      font-weight: bold;
      text-align: center;
      padding: 8px;
      border-radius: 5px;
      width: 100%;
      transition: all 0.3s ease-in-out;
   }

   .weak {
      background-color: #ffdddd;
      color: #ff4d4d;
      border: 1px solid #ff4d4d;
   }

   .medium {
      background-color: #fff3cd;
      color: #ffc107;
      border: 1px solid #ffc107;
   }

   .strong {
      background-color: #d4edda;
      color: #28a745;
      border: 1px solid #28a745;
   }

   .very-strong {
      background-color: #c3e6cb;
      color: #218838;
      border: 1px solid #218838;
   }
</style>


   <script>
      function checkPasswordStrength(password) {
         const strengthMsg = document.getElementById("strength-msg");
         let strength = 0;

         // Check the length of the password
         if (password.length >= 8) {
            strength += 1;
         }

         // Check if password contains both letters and numbers
         if (/[a-z]/.test(password) && /[0-9]/.test(password)) {
            strength += 1;
         }

         // Check if password contains both upper and lower case letters
         if (/[a-z]/.test(password) && /[A-Z]/.test(password)) {
            strength += 1;
         }

         // Check if password contains special characters
         if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
            strength += 1;
         }

         // Update the message and color based on the strength
         if (strength === 0) {
            strengthMsg.textContent = "Very Weak";
            strengthMsg.className = "weak";
         } else if (strength === 1) {
            strengthMsg.textContent = "Weak";
            strengthMsg.className = "weak";
         } else if (strength === 2) {
            strengthMsg.textContent = "Medium";
            strengthMsg.className = "medium";
         } else if (strength === 3) {
            strengthMsg.textContent = "Strong";
            strengthMsg.className = "strong";
         } else {
            strengthMsg.textContent = "Very Strong";
            strengthMsg.className = "strong";
         }
      }
   </script>

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
      <input type="password" name="wachtwoord" id="wachtwoord" required placeholder="Stel uw wachtwoord in" onkeyup="checkPasswordStrength(this.value)">
      
      <!-- Display password strength message -->
      <div id="strength-msg" class="strength-msg"></div>

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
