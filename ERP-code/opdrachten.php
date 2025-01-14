<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opdrachten Beheren</title>
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
            max-width: 800px;
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
        .delete-button, .update-button {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            color: #fff;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .delete-button {
            background-color: #bb2727;
        }
        .delete-button:hover {
            background-color: #a12222;
        }
        .update-button {
            background-color: #28a745;
        }
        .update-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="manger.php">Uren Invullen</a></li>
            <li><a href="werkzaamheden.php">Werkzaamheden</a></li>
            <li><a href="medewerkers.php">Medewerkers</a></li>
            <li><a href="opdrachten.php">Opdrachten</a></li>
            <li><a href="klanten.php" class="active">Klanten</a></li>
        </ul>
    </nav>
    <a href="admin_page.php"><button>Terug</button></a>
</header>
<main>
    <h2>Opdrachten Beheren</h2>

    <?php
    include 'db.php';
    $conn = getConnection();

    if (!$conn) {
        die("Verbindingsfout: " . mysqli_connect_error());
    }

    mysqli_set_charset($conn, "utf8mb4");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $opdrachten = $_POST["opdracht"];
        $klantID = $_POST["klanten"];
        $aanvraagdatum = $_POST["aanvraagdatum"];
        $benodigdeKennis = $_POST["benodigde_kennis"];

        $insertSql = "INSERT INTO opdrachten (Opdrachten, klant, Aanvraagdatum, `Benodigde kennis`) VALUES ('$opdrachten', $klantID, '$aanvraagdatum', '$benodigdeKennis')";

        if (mysqli_query($conn, $insertSql)) {
            echo "<p>Rij succesvol toegevoegd.</p>";
        } else {
            echo "<p>Fout bij toevoegen: " . mysqli_error($conn) . "</p>";
        }
    }

    if (isset($_GET["delete"])) {
        $deleteID = $_GET["delete"];
        $deleteSql = "DELETE FROM opdrachten WHERE ID = $deleteID";

        if (mysqli_query($conn, $deleteSql)) {
            echo "<p>Rij succesvol verwijderd.</p>";
        } else {
            echo "<p>Fout bij verwijderen: " . mysqli_error($conn) . "</p>";
        }
    }

    $result = mysqli_query($conn, "SELECT * FROM opdrachten");
    ?>

    <form method="post">
        <label for="klanten">Klant</label>
        <select name="klanten" id="klanten">
            <?php
            $klantenResult = mysqli_query($conn, "SELECT * FROM klanten");
            while ($klant = mysqli_fetch_assoc($klantenResult)) {
                echo "<option value='" . $klant['ID'] . "'>" . $klant['Bedrijfsnaam'] . "</option>";
            }
            ?>
        </select>

        <label for="opdracht">Opdracht</label>
        <input type="text" id="opdracht" name="opdracht" required>

        <label for="aanvraagdatum">Aanvraagdatum</label>
        <input type="date" id="aanvraagdatum" name="aanvraagdatum" required>

        <label for="benodigde_kennis">Benodigde kennis</label>
        <input type="text" id="benodigde_kennis" name="benodigde_kennis">

        <input type="submit" value="Toevoegen">
    </form>

    <table>
        <thead>
        <tr>
            <th>KlantID</th>
            <th>Opdracht</th>
            <th>Aanvraagdatum</th>
            <th>Benodigde kennis</th>
            <th>Acties</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $klant = isset($row['klant']) ? $row['klant'] : 'Onbekend';
                $opdracht = isset($row['Opdrachten']) ? $row['Opdrachten'] : 'Geen opdracht';
                $aanvraagdatum = isset($row['Aanvraagdatum']) ? $row['Aanvraagdatum'] : 'Geen datum';
                $benodigdeKennis = isset($row['Benodigde kennis']) ? $row['Benodigde kennis'] : 'Geen kennis';

                echo "<tr>";
                echo "<td>" . htmlspecialchars($klant) . "</td>";
                echo "<td>" . htmlspecialchars($opdracht) . "</td>";
                echo "<td>" . htmlspecialchars($aanvraagdatum) . "</td>";
                echo "<td>" . htmlspecialchars($benodigdeKennis) . "</td>";
                echo "<td>";
                echo "<a class='delete-button' href='?delete=" . $row['ID'] . "'>Verwijderen</a> ";
                echo "<a class='update-button' href='update.php?id=" . $row['ID'] . "'>Bijwerken</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Geen opdrachten gevonden.</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <?php $conn->close(); ?>
</main>
</body>
</html>
