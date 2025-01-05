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
    <title>Medewerker registreren</title>
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

        .delete-button {
            background-color: #6227bb;
            color: #fff;
            padding: 4px 8px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .delete-button:hover {
            background-color: #6227bb;
        }

        .delete-button {
    text-decoration: none; 
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
      //   print_r($_POST);
        $opdrachten = $_POST["opdracht"];
        $klantID = $_POST["klanten"];
        $aanvraagdatum = $_POST["aanvraagdatum"];
        $benodigdeKennis = $_POST["benodigde_kennis"];

        // Voer de SQL-query uit om de nieuwe rij toe te voegen
        $insertSql = "INSERT INTO opdrachten (Opdrachten, klant, Aanvraagdatum, `Benodigde kennis`) VALUES ('$opdrachten',$klantID, '$aanvraagdatum', '$benodigdeKennis')";
        // echo $insertSql; 
        $insertResult = mysqli_query($conn, $insertSql);

        if ($insertResult) {
            echo "Rij succesvol toegevoegd.";
        } else {
            echo "Fout bij het toevoegen van de rij: " . mysqli_error($conn);
        }
    }
    
    // Controleren of er een GET-verzoek is verzonden om een rij te verwijderen
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["delete"])) {
        $deleteID = $_GET["delete"];

        // Voer de SQL-query uit om de rij te verwijderen
        $deleteSql = "DELETE FROM opdrachten WHERE ID = $deleteID";
        
        $deleteResult = mysqli_query($conn, $deleteSql);

        if ($deleteResult) {
            echo "Rij succesvol verwijderd.";
        } else {
            echo "Fout bij het verwijderen van de rij: " . mysqli_error($conn);
        }
    }
    
    // Voer de SQL-query uit om alle gegevens uit de tabel op te halen
    $sql = "SELECT * FROM `opdrachten`";
    $result = mysqli_query($conn, $sql);
    



// Zoekbalk om klantID's te zoeken
echo "<form method='GET'>";
echo "<input type='text' name='search' placeholder='KlantID'>";
echo "<input type='submit' value='Zoeken'>";
echo "</form>";

// Controleren of er een GET-verzoek is verzonden om klantID's te zoeken
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search"])) {
    $search = $_GET["search"];
    // Voer de SQL-query uit om klanten te zoeken op basis van het klantID
    $searchSql = "SELECT * FROM `opdrachten` WHERE klant = '$search'";
    $searchResult = mysqli_query($conn, $searchSql);
    
    // Maak een HTML-tabel en vul deze met de zoekresultaten
    echo "<h2>Zoekresultaten:</h2>";
    echo "<div class='table-container'>";
    echo "<table>";
    echo "<tr><th>KlantID</th><th>Opdracht</th><th>Aanvraagdatum</th><th>Omschrijving</th><th></th></tr>";
    
    while ($row = mysqli_fetch_assoc($searchResult)) {
        echo "<tr>";
        echo "<td>" . $row["klant"] . "</td>";
        echo "<td>" . $row["opdrachten"] . "</td>";
        echo "<td>" . $row["Aanvraagdatum"] . "</td>";
        echo "<td>" . $row["Benodigde kennis"] . "</td>";
        echo "<td><a class='delete-button' href='?delete=" . $row["ID"] . "'>Verwijderen</a></td>";
                
        echo "</tr>";
    }
    
    echo "</table>";
    echo "</div>";
}














    // Maak een HTML-tabel en vul deze met de gegevens uit de database
    echo "<div class='table-container'>";
    echo "<table>";
    echo "<tr><th>KlantID</th><th>Opdracht</th><th>Aanvraagdatum</th><th>Omschrijving</th><th></th></tr>";
    
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["klant"] . "</td>";
        echo "<td>" . $row["opdrachten"] . "</td>";
        echo "<td>" . $row["Aanvraagdatum"] . "</td>";
        echo "<td>" . $row["Benodigde kennis"] . "</td>";
        echo "<td><a class='delete-button' href='?delete=" . $row["ID"] . "'>Verwijderen</a></td>";
                
        echo "</tr>";
    }
    
    // Voer de SQL-query uit om klanten uit de tabel op te halen
    $sql = "SELECT * FROM `klanten`;";
    $klanten = mysqli_query($conn, $sql);
    // print_r($klanten);
    // Formulier voor het toevoegen van een nieuwe rij
    echo "<tr>";
    echo "<form method='post'>";
    
    echo '<td>';
    echo "<select name=\"klanten\" id=\"klanten\">";
    // While loop through klanten
    while ($klant = mysqli_fetch_assoc($klanten)) {
        echo '<option value="'.$klant['ID'].'">'. $klant['Bedrijfsnaam'] .'</option>';
    }
    echo '</select>';
    echo '</td>';
    // echo "<td><input type='text' name='klant' placeholder='klant'></td>";


    echo "<td><input type='text' name='opdracht'></td>";
    echo "<td><input type='date' name='aanvraagdatum'></td>";
    echo "<td><input type='text' name='benodigde_kennis' placeholder=''></td>";
    echo "<td><input type='submit' value='Toevoegen'></td>";
    echo "</form>";
    echo "</tr>";
    
    echo "</table>";
    echo "</div>";
    

    // Sluit de verbinding met de database
    $conn->close();
?>
</body>
</html>
