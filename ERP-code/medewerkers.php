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
            background-color: #2b69b0;
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

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        form input[type="submit"] {
            margin-top: 10px;
        }

        form .delete-button {
            margin-left: auto;
        }
        input[type="submit"],
    .button,
    .delete-button {
        padding: 8px 16px;
        background-color: #6227bb;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover,
    .button:hover,
    .delete-button:hover {
        background-color: #6227bb;
        opacity: 0.8;
    }

    .delete-button {
        margin-left: 8px;
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

// Controleren of er een POST-verzoek is verzonden om een rij bij te werken
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Controleren of de knop "Bijwerken" is ingedrukt
    if (isset($_POST["update"])) {
        $id = $_POST["id"];
        $voornaam = $_POST["voornaam"];
        $tussenvoegsel = $_POST["tussenvoegsel"];
        $achternaam = $_POST["achternaam"];
        $functie = $_POST["functie"];
        $gebruiksnaam = $_POST["gebruiksnaam"];

        // Voer de SQL-query uit om de geselecteerde rij bij te werken
        $updateSql = "UPDATE medewerkers SET voornaam='$voornaam', tussenvoegsel='$tussenvoegsel', achternaam='$achternaam', Functie='$functie', gebruiksnaam='$gebruiksnaam' WHERE ID='$id'";
        $updateResult = mysqli_query($conn, $updateSql);

        if ($updateResult) {
            echo "Rij succesvol bijgewerkt.";
        } else {
            echo "Fout bij het bijwerken van de rij: " . mysqli_error($conn);
        }
    }

    // Controleren of de knop "Verwijderen" is ingedrukt
    if (isset($_POST["delete"])) {
        $id = $_POST["id"];

        // Voer de SQL-query uit om de geselecteerde rij te verwijderen
        $deleteSql = "DELETE FROM medewerkers WHERE ID='$id'";
        $deleteResult = mysqli_query($conn, $deleteSql);

        if ($deleteResult) {
            echo "Rij succesvol verwijderd.";
        } else {
            echo "Fout bij het verwijderen van de rij: " . mysqli_error($conn);
        }
    }
}

// Haal alle medewerkers op uit de database
$search = $_GET["search"] ?? '';
$sql = "SELECT * FROM medewerkers WHERE voornaam LIKE '%$search%'";
$result = mysqli_query($conn, $sql);
?>

<form method="GET">
    <input type="text" name="search" placeholder="Voornaam zoeken">
    <input type="submit" value="Zoeken">
</form>

<table>
    <tr>
        <th>ID</th>
        <th>Voornaam</th>
        <th>Tussenvoegsel</th>
        <th>Achternaam</th>
        <th>Functie</th>
        <th>Gebruiksnaam</th>
        <th></th>
    </tr>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <form method="POST">
                <td><?php echo $row["ID"]; ?></td>
                <td><input type="text" name="voornaam" value="<?php echo $row["voornaam"]; ?>"></td>
                <td><input type="text" name="tussenvoegsel" value="<?php echo $row["tussenvoegsel"]; ?>"></td>
                <td><input type="text" name="achternaam" value="<?php echo $row["achternaam"]; ?>"></td>
                <td><input type="text" name="functie" value="<?php echo $row["Functie"]; ?>"></td>
                <td><input type="text" name="gebruiksnaam" value="<?php echo $row["gebruiksnaam"]; ?>"></td>
                <td>
                    <input type="hidden" name="id" value="<?php echo $row["ID"]; ?>">
                    <input type="submit" name="update" value="Bijwerken">
                </td>
            </form>
            <form method="POST" onsubmit="return confirm('Weet je zeker dat je deze rij wilt verwijderen?');">
            
                <input type="hidden" name="id" value="<?php echo $row["ID"]; ?>">
                <td>
                    <input type="submit" name="delete" value="Verwijderen">
                </td>
            </form>
        </tr>
        <?php
    }
    ?>
</table>

<?php
// Sluit de verbinding met de database
$conn->close();
?>
