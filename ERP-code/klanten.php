<?php
session_start();

// Controleer of de gebruiker is ingelogd als admin of medewerker
if (!isset($_SESSION['admin_name']) && !isset($_SESSION['user_name'])) {
    header('location:index.html'); 
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
            max-width: 800px;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
        }
        
        h2 {
            color: #fff;
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
        input[type="text"],
        input[type="email"],
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
        
        input[type="submit"],
        .button {
            padding: 8px 16px;
            background-color: #6227bb;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            border-radius: 4px;
        }
        
        input[type="submit"]:hover,
        .button:hover {
            background-color: #451e8e;
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

        .delete-button {
            background-color: #6227bb;
            color: #fff;
            padding: 4px 8px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .delete-button:hover {
            background-color: #451e8e;
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
    <main>
        <h2>Klanten beheren</h2>
        <form method="post">
            <table>
                <tr>
                    <td><input type="text" name="bedrijfsnaam" placeholder="Bedrijfsnaam"></td>
                    <td><input type="email" name="email" placeholder="E-Mail"></td>
                    <td><input type="text" name="adres" placeholder="Adres"></td>
                    <td><input type="text" name="telefoon" placeholder="Telefoonnummer"></td>
                    <td><input type="text" name="postcode" placeholder="Postcode"></td>
                    <td><button class="button" type="submit" name="add">Toevoegen</button></td>
                </tr>
            </table>
        </form>

        <?php
            include 'db.php';
            
            $conn = getConnection();
            if (!$conn) {  
                die("Connection failed: " . mysqli_connect_error());
            }
            
            mysqli_set_charset($conn, "utf8mb4");
            
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST["add"])) {
                    $bedrijfsnaam = trim($_POST["bedrijfsnaam"]);
                    $email = trim($_POST["email"]);
                    $adres = trim($_POST["adres"]);
                    $telefoon = trim($_POST["telefoon"]);
                    $postcode = trim($_POST["postcode"]);

                    // Controleer of alle velden leeg zijn
                    if (empty($bedrijfsnaam) && empty($email) && empty($adres) && empty($telefoon) && empty($postcode)) {
                        echo "<p>Alle velden zijn leeg. Voeg alstublieft gegevens in.</p>";
                    } else {
                        $insertSql = "INSERT INTO klanten (Bedrijfsnaam, `E-Mail`, Adres, `Telefoon nummer`, Postcode) VALUES ('$bedrijfsnaam','$email', '$adres', '$telefoon', '$postcode')";
                        $insertResult = mysqli_query($conn, $insertSql);

                        if ($insertResult) {
                            echo "<p>Klant succesvol toegevoegd.</p>";
                        } else {
                            echo "<p>Fout bij het toevoegen van de rij: " . mysqli_error($conn) . "</p>";
                        }
                    }
                }

                if (isset($_POST["delete_row"])) {
                    $id = $_POST["delete_row"];
                    $deleteSql = "DELETE FROM klanten WHERE ID = '$id'";
                    $deleteResult = mysqli_query($conn, $deleteSql);
                    
                    if ($deleteResult) {
                        echo "<p>Klant succesvol verwijderd.</p>";
                    } else {
                        echo "<p>Fout bij het verwijderen van de rij: " . mysqli_error($conn) . "</p>";
                    }
                }
            }

            $sql = "SELECT * FROM klanten";
            if (isset($_GET["search"])) {
                $searchTerm = $_GET["search"];
                $sql .= " WHERE ID LIKE '%$searchTerm%'";
            }
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr><th>KlantID</th><th>Bedrijfsnaam</th><th>E-Mail</th><th>Adres</th><th>Telefoon nummer</th><th>Postcode</th><th></th></tr>";
                
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='id' value='" . $row["ID"] . "'>";
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
                
                echo "</table>";
            } else {
                echo "<p>Geen klantgegevens gevonden.</p>";
            }

            $conn->close();
        ?>
    </main>
</body>
</html>
