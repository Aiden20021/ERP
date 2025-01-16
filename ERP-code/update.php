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

// Maak verbinding met de database
$conn = getConnection();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Controleer of het ID is opgegeven
if (!$id) {
    die("Geen geldig ID opgegeven.");
}

// Haal de gegevens op voor het gegeven ID
$sql = "SELECT * FROM opdrachten WHERE ID = $id";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    $row = []; // Zorg dat $row een lege array is als er geen resultaten zijn
    echo "Geen opdracht gevonden.";
}

// Verwerk formuliergegevens als deze zijn verzonden
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $opdracht = isset($_POST['opdracht']) ? $_POST['opdracht'] : '';
    $klant = isset($_POST['klanten']) ? intval($_POST['klanten']) : 0;
    $aanvraagdatum = isset($_POST['aanvraagdatum']) ? $_POST['aanvraagdatum'] : '';
    $benodigdeKennis = isset($_POST['benodigde_kennis']) ? $_POST['benodigde_kennis'] : '';

    $updateSql = "UPDATE opdrachten SET 
        Opdrachten = '$opdracht', 
        klant = $klant, 
        Aanvraagdatum = '$aanvraagdatum', 
        `Benodigde kennis` = '$benodigdeKennis' 
        WHERE ID = $id";

    if ($conn->query($updateSql)) {
        echo "Opdracht succesvol bijgewerkt.";
        header("Location: opdrachten.php");
        exit;
    } else {
        echo "Fout bij bijwerken: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Opdracht</title>
   <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #bb278a;
            color: #333;
        }
        header {
            background-color: #333;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        nav ul li {
            margin-right: 30px;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            transition: color 0.3s;
        }
        nav ul li a:hover {
            color: #ccc;
        }
        main {
            max-width: 300px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-weight: bold;
        }
        input, select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #6227bb;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #4f1e94;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        input, select {
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        input[type="submit"] {
            background-color: #4f1e94;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #4f1e94;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Update Opdracht</h2>
    <form method="POST">
        <label for="opdracht">Opdracht:</label>
        <input type="text" id="opdracht" name="opdracht" value="<?php echo isset($row['Opdrachten']) ? $row['Opdrachten'] : ''; ?>" required>

        <label for="klanten">Klant:</label>
        <select id="klanten" name="klanten">
            <?php
            $klantenSql = "SELECT ID, Bedrijfsnaam FROM klanten";
            $klantenResult = $conn->query($klantenSql);
            while ($klantRow = $klantenResult->fetch_assoc()) {
                $selected = (isset($row['klant']) && $row['klant'] == $klantRow['ID']) ? 'selected' : '';
                echo "<option value='{$klantRow['ID']}' $selected>{$klantRow['Bedrijfsnaam']}</option>";
            }
            ?>
        </select>

        <label for="aanvraagdatum">Aanvraagdatum:</label>
        <input type="date" id="aanvraagdatum" name="aanvraagdatum" value="<?php echo isset($row['Aanvraagdatum']) ? $row['Aanvraagdatum'] : ''; ?>" required>

        <label for="benodigde_kennis">Benodigde kennis:</label>
        <input type="text" id="benodigde_kennis" name="benodigde_kennis" value="<?php echo isset($row['Benodigde kennis']) ? $row['Benodigde kennis'] : ''; ?>" required>

        <input type="submit" value="Bijwerken">
    </form>
</div>
</body>
</html>
