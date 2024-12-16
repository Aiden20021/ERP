<?php
session_start();

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['admin_name'])) {
    header('location:login_form.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Klanten beheren</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url("");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            background-color: #bb278a;
        }
        
        header {
            background-color: #333;
            padding: 20px; 
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        nav {
            flex: 1;
            display: flex;
            justify-content: center;
        }
        
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }
        
        nav ul li {
            display: inline;
            margin-right: 4cm; 
        }
        
        nav ul li a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s ease;
            font-size: 20px; 
        }
        
        nav ul li a:hover {
            color: #ccc;
        }
        
        .header-greeting {
            color: #fff;
            margin-left: auto;
        }
        
        main {
            margin: 100px auto; 
            max-width: 600px;
            background-color: #bb278a;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        
        input[type="date"],
        input[type="number"],
        select,
        textarea {
            margin-bottom: 10px;
            padding: 8px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }
        
        textarea {
            height: 100px;
        }
        
        input[type="submit"] {
            padding: 8px 16px;
            background-color: #6227bb;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        
        input[type="submit"]:hover {
            background-color: #6227bb;
        }

        table {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .add-form-row td:last-child {
            text-align: right;
        }

        .delete-button {
            background-color: #6227bb;
            color: #fff;
            padding: 4px 8px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .delete-button:hover {
            background-color: #6227bb;
        }

        .button {
            background-color: #6227bb;
            color: #fff;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #6227bb;
        }

        
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="manger.php">
                        <div class="header-title">
                            <span>Uren</span>
                            <span>Invullen</span>
                        </div>
                    </a>
                </li>
                <li><a href="werkzaamheden.php">Werkzaamheden</a></li>
                <li><a href="medewerkers.php">Medewerkers</a></li>
                <li><a href="opdrachten.php">Opdrachten</a></li>
                <li><a href="klanten.php" class="active">Klanten</a></li>
            </ul>
        </nav>
        <a href="admin_page.php"><button style="position: absolute; top: 20px; left: 20px;">Terug</button></a>
    </header>
    <div class="search-container">
            <form method="get" action="klanten.php">
                <input type="text" name="search" placeholder="Zoeken op KlantID...">
                <input type="submit" value="Zoeken">
    <?php
        include 'db.php';
        

       // Maak een verbinding met de database
        $conn = getConnection();
        
        // Controleer of de verbinding is gelukt
        if (!$conn) {  
            die("Connection failed: " . mysqli_connect_error());
        }
        
        // Set the character set to utf8mb4
        mysqli_set_charset($conn, "utf8mb4");
        
        
        // Controleren of er een POST-verzoek is verzonden om een rij toe te voegen
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["add"])) {
                $bedrijfsnaam = $_POST["bedrijfsnaam"];
                $email = $_POST["email"];
                $adres = $_POST["adres"];
                $telefoon = $_POST["telefoon"];
                $postcode = $_POST["postcode"];
                
                // Voer de SQL-query uit om de nieuwe rij toe te voegen
                $insertSql = "INSERT INTO klanten (Bedrijfsnaam,`E-Mail`, Adres, `Telefoon nummer`, Postcode) VALUES ('$bedrijfsnaam','$email', '$adres', '$telefoon', '$postcode')";
                $insertResult = mysqli_query($conn, $insertSql);
                
                if ($insertResult) {
                    echo "Klant succesvol toegevoegd.";
                } else {
                    echo "Fout bij het toevoegen van de rij: " . mysqli_error($conn);
                }
            }
            
            if (isset($_POST["delete_row"])) {
                $id = $_POST["delete_row"];
                
                // Voer de SQL-query uit om de rij te verwijderen
                $deleteSql = "DELETE FROM klanten WHERE ID = '$id'";
                $deleteResult = mysqli_query($conn, $deleteSql);
                
                if ($deleteResult) {
                    echo "Klant succesvol verwijderd.";
                } else {
                    echo "Fout bij het verwijderen van de rij: " . mysqli_error($conn);
                }
            }
        }
        
        // Voer de SQL-query uit om de klantgegevens op te halen
        $sql = "SELECT * FROM klanten";
        //echo '1 sql: '. $sql. "\r\n";
        
        // Controleren of er een zoekopdracht is verzonden
        if (isset($_GET["search"])) {
            $searchTerm = $_GET["search"];
            //echo $searchTerm;
            $sql .= " WHERE ID LIKE '%$searchTerm%'";
            //echo 'sql 2: '.$sql ."\r\n";
        }
        $result = mysqli_query($conn, $sql);
        // Controleer of er resultaten zijn
        if (mysqli_num_rows($result) > 0) {
            echo "<div class='table-container'>";
            echo "<table>";
            echo "<tr><th>KlantID</th><th>Bedrijfsnaam</th><th>E-Mail</th><th>Adres</th><th>Telefoon nummer</th><th>Postcode</th><th></th></tr>";
            
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='id' value='" . $row["ID"] . "'>";
                echo "<input type='hidden' name='bedrijfsnaam' value='" . $row["Bedrijfsnaam"] . "'>";
                echo "<input type='hidden' name='email' value='" . $row["E-Mail"] . "'>";
                echo "<input type='hidden' name='adres' value='" . $row["Adres"] . "'>";
                echo "<input type='hidden' name='telefoon' value='" . $row["Telefoon nummer"] . "'>";
                echo "<input type='hidden' name='postcode' value='" . $row["Postcode"] . "'>";
                
                echo "<td>" . $row["ID"] . "</td>";
                echo "<td>" . $row["Bedrijfsnaam"] . "</td>";
                echo "<td>" . $row["E-Mail"] . "</td>";
                echo "<td>" . $row["Adres"] . "</td>";
                echo "<td>" . $row["Telefoon nummer"] . "</td>";
                echo "<td>" . $row["Postcode"] . "</td>";
                echo "<td><button class='delete-button' type='submit' name='delete_row' value='" . $row["ID"] . "'>Verwijderen</button></td>";
                
                echo "</form>";
                echo "</tr>";
            }
            
            echo "<tr>";
            echo "<form method='post'>";
            echo "<td></td>";
            echo "<td><input type='text' name='bedrijfsnaam'></td>";
            echo "<td><input type='email' name='email'></td>";
            echo "<td><input type='text' name='adres'></td>";
            echo "<td><input type='text' name='telefoon'></td>";
            echo "<td><input type='text' name='postcode'></td>";
            echo "<td><button class='button' type='submit' name='add'>Toevoegen</button></td>";
            echo "</form>";
            echo "</tr>";
            
            echo "</table>";
            echo "</div>";
        } else {
            echo "Geen klantgegevens gevonden.";
        }
        
        
        // Sluit de verbinding met de MySQL-server
        $conn->close();
        
    ?>
</body>
</html>