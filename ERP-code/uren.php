<?php
session_start();

// Controleer of de gebruiker is ingelogd als admin of medewerker
if (!isset($_SESSION['admin_name']) && !isset($_SESSION['user_name'])) {
    header('location:index.html'); 
    exit();
}
?>

<?php
$opdrachtNamen = array(
    "opdracht1" => "Server fixen",
    "opdracht2" => "Server bouwen",
    "opdracht3" => "Website bouwen"
);

include 'db.php';
        
// Maak een verbinding met de database
 $conn = getConnection();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = $_POST["naam"];
    $datum = $_POST["datum"];
    $uren = $_POST["uren"];
    $opdrachtTekst = $_POST["opdrachtTekst"]; 
    $beschrijving = $_POST["beschrijving"];

    $sql = "INSERT INTO uren (naam, datum, uren, project, beschrijving)
            VALUES ('$naam', '$datum', '$uren', '$opdrachtTekst', '$beschrijving')";

    if ($conn->query($sql) === TRUE) {
        $message = "Gegevens succesvol toegevoegd aan de database.";

        header("Location: werkzaamhedenmed.php");
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
    <title>Urenregistratie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ff9800;
        }

        
    </style>
</head>

<body>
</body>
</html>





<!DOCTYPE html>
<html>
<head>
    <title>Urenregistratie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ff9800;
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
            font-size: 16px; 
        }
        
        nav ul li a:hover {
            color: #ccc;
        }
        
        .header-greeting {
            color: #fff;
            margin-left: auto;
        }
        
        .header-title {
            display: flex;
            align-items: center;
        }
        
        .header-title span {
            margin-left: 5px; 
        }
        
        main {
            margin: 20px auto;
            max-width: 600px;
            background-color: #fff;
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
            color: #555;
        }
        
        input[type="date"],
        input[type="name"],
        input[type="number"],
        input[type="text"],
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
            background-color: #ff9800;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        
        input[type="submit"]:hover {
            background-color: #ff6600;
        }

        .active {
            color: #fff;
            font-weight: bold;
        }

    </style>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="uren.php" class="active">
                        <div class="header-title">
                            <span>Uren</span>
                            <span>Invullen</span>
                        </div>
                    </a>
                </li>
                <li><a href="werkzaamhedenmed.php">Werkzaamheden</a></li>
                <li><a href="opdrachtenmed.php">Opdrachten</a></li>
                <li><a href="klantenmed.php">Klanten</a></li>
            </ul>
        </nav>
        <a href="user_page.php"><button style="position: absolute; top: 20px; left: 20px;">Terug</button></a>

        <span class="header-greeting"></span>
    </header>
      
    <main>
        <h2>Registratie</h2>

        <?php echo $message; ?>
    
        <form action="uren.php" method="post">

        <label for="naam">Naam:</label>
            <input type="name" id="naam" name="naam">
    

            <label for="datum">Datum:</label>
            <input type="date" id="datum" name="datum">
    
            <label for="uren">Aantal uren:</label>
            <input type="number" id="uren" min="1" name="uren">
    
            <label for="opdrachtTekst">Opdracht:</label> 
            <input type="text" id="opdrachtTekst" name="opdrachtTekst"> 
    
            <label for="beschrijving">Beschrijving:</label>
            <textarea id="beschrijving" rows="4" cols="50" name="beschrijving"></textarea> 
    
            <input type="submit" value="Toevoegen">
        </form>
    </main>
</body>
</html>
