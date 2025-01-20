<?php
session_start();

// Controleer of de gebruiker is ingelogd als admin of medewerker
if (!isset($_SESSION['admin_name']) && !isset($_SESSION['user_name'])) {
    header('location:index.html'); 
    exit();
}
?>


<?php
include 'db.php';

// Maak een verbinding met de database
$conn = getConnection();

$message = "";

// Definieer een associatieve array met de opdrachtnamen en hun corresponderende waarden
$opdrachten = array(
    "Webservers fixen",
    "Webservers bouwen",
    "Webserver verbinden",
    "Database optimaliseren",
    "Netwerk configureren",
    "API ontwikkelen",
    "Gebruikersbeheer implementeren",
    "Systeembeveiliging verbeteren"
);

if ($conn->connect_error) {
    echo 'No db connection';
    die("Verbinding mislukt: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = $_POST["naam"];
    $datum = $_POST["datum"];
    $uren = $_POST["uren"];
    $opdrachtNaam = $_POST["opdracht"];
    $beschrijving = $_POST["beschrijving"];

    $sql = "INSERT INTO uren (naam, datum, uren, project, beschrijving)
            VALUES ('$naam', '$datum', '$uren', '$opdrachtNaam', '$beschrijving')";

    if ($conn->query($sql) === TRUE) {
        $message = "Gegevens succesvol toegevoegd aan de database.";
        header("Location: werkzaamheden.php");
        exit();
    } else {
        echo "Fout bij het toevoegen van gegevens: " . $conn->error;
    }
}

$conn->close();
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
            background-image: url("manger.jpg"); 
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            background-color: #00fffb;  
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
            padding: 5;
            display: flex;
            justify-content: center;
        }
        
        nav ul li {
            display: inline;
            margin-right: 3cm; 
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
        input[type="name"],
        input[type="text"],
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
    </style>
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="#">Uren invullen</a></li>
            <li><a href="werkzaamheden.php">Werkzaamheden</a></li>
            <li><a href="medewerkers.php" onclick="showTable()">Medewerkers</a></li>
            <li><a href="opdrachten.php">Opdrachten</a></li>
            <li><a href="klanten.php">Klanten</a></li>
        </ul>
    </nav>
    <a href="admin_page.php"><button style="position: absolute; top: 20px; left: 20px;">Terug</button></a>
</header>

<main>
    <h2>Registratie</h2>
    <form method="POST" action="manger.php">
        <label for="naam">Naam:</label>
        <input type="text" id="naam" name="naam" required>

        <label for="datum">Datum:</label>
        <input type="date" id="datum" name="datum" required>

        <label for="uren">Aantal uren:</label>
        <input type="number" id="uren" min="1" name="uren" required>

        <label for="opdracht">Opdracht:</label>
        <select id="opdracht" name="opdracht" required>
            <option value="">Selecteer een opdracht</option>
            <?php
            foreach ($opdrachten as $opdracht) {
                echo "<option value=\"$opdracht\">$opdracht</option>";
            }
            ?>
        </select>

        <label for="beschrijving">Beschrijving:</label>
        <textarea id="beschrijving" rows="4" cols="50" name="beschrijving"></textarea>

        <input type="submit" value="Toevoegen">
    </form>
</main>
</body>
</html>