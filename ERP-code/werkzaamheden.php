<?php
require_once __DIR__ . '/vendor/autoload.php'; // Het pad naar de mpdf-bibliotheek

use Mpdf\Mpdf;

// Controleer of de "pdf" parameter aanwezig is in de URL
if (isset($_GET['pdf'])) {
    $pdfName = $_GET['pdf'];

    // Maak een verbinding met de MySQL-server
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "erp_systeem";

    // Maak een verbinding met de MySQL-server
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Controleer of de verbinding is gelukt
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Set the character set to utf8mb4
    mysqli_set_charset($conn, "utf8mb4");

    // Haal de gegevens op voor de geselecteerde rij
    $sql = "SELECT * FROM `uren` WHERE naam = '$pdfName'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    // Genereer de PDF met de gegevens van de geselecteerde rij
    $mpdf = new Mpdf();

$mpdf->WriteHTML('
<style>
@page {
    header: html_Urenregistraties;
    footer: html_Footer;
    margin-top: ;
    margin-left: 0;
    margin-right: 0;
    margin-bottom: 0; /* Voeg deze regel toe om de ondermarge te verwijderen */
}
#black-bar {
    background-color: #999;
    width: 100vw;
    height: 120px;
    text-align: center;
    color: #fff;
    line-height: 120px;
    font-size: 18px;
    position: absolute;
    top: -120px; /* Verander de waarde naar -120px om de balk naar boven te verplaatsen */
    left: 0;
}
#header-container {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 120px;
    background-color: #b91d73
    ;
    color: #000;
    text-align: center;
    line-height: 120px;
}
#logo {
    text-align: right;
    padding-right: 20px;
}
#logo img {
    width: 100px;
}
#title {
    text-align: left;
    padding-left: 20px;
}
.content {
    margin-top: 120px;
}
.content table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}
.content th,
.content td {
    padding: 8px;
    border-bottom: 1px solid #ddd;
}
.medewerker {
    width: 20%;
}
</style>
');





    // Definieer het pad naar het logo-bestand
    $logoPath = 'gilde.png';
    $htmlLogo = '<img src="' . $logoPath . '">';

    // Voeg de header HTML toe
    $mpdf->SetHTMLHeader('
    <div id="header-container">
        <div id="title">
            <h1>Gewerkte uren</h1>
        </div>
        <div id="logo">' . $htmlLogo . '</div>
    </div>
    ');

    // Voeg de footer HTML toe
    $mpdf->SetHTMLFooter('
    <div id="footer">
        
    </div>
    ');

    // Genereer de inhoud van de PDF
    $html = '
    <br/><br/>
    <div class="content">
        <table>
            <tr>
                <th class="medewerker">Medewerker</th>
                <th>Datum</th>
                <th>Uren</th>
                <th>Project</th>
                <th>Beschrijving</th>
            </tr>
            <tr>
                <td class="medewerker">' . $row["naam"] . '</td>
                <td>' . $row["datum"] . '</td>
                <td>' . $row["uren"] . '</td>
                <td>' . $row["project"] . '</td>
                <td>' . $row["beschrijving"] . '</td>
            </tr>
        </table>
    </div>
    ';

    // Voeg de inhoud van de PDF toe
    $mpdf->WriteHTML($html);

    // Uitvoer van de PDF als download met de bestandsnaam op basis van de medewerker
    $mpdf->Output($pdfName . '.pdf', 'D');
    exit;
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
            background-image: url("manger.jpg"); /* Voeg hier het pad naar je afbeelding in */
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
            margin-right: 4cm; /* Spatiëring van 4 cm */
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s ease;
            font-size: 20px; /* Lettergrootte van 20 pixels */
        }

        nav ul li a:hover {
            color: #ccc;
        }

        .header-greeting {
            color: #fff;
            margin-left: auto;
        }

        main {
            margin: 100px auto; /* Aangepaste marge */
            max-width: 800px; /* Aangepaste maximale breedte */
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

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .pdf-btn {
            margin-right: 5px;
            padding: 5px 10px;
            background-color: #6227bb;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 12px;
            transition: background-color 0.3s ease;
        }

        .pdf-btn:hover {
            background-color: #6227bb;
        }

        .delete-btn {
            margin-right: 5px;
            padding: 5px 10px;
            background-color: #6227bb;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 12px;
            transition: background-color 0.3s ease;
        }

        .delete-btn:hover {
            background-color: #bb2727;
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
        <table>
            <tr>
                <th>Naam</th>
                <th>Datum</th>
                <th>Uren</th>
                <th>Project</th>
                <th>Beschrijving</th>
                <th></th>
                <th></th>
            </tr>
            <?php
            // Maak een verbinding met de MySQL-server
            include 'db.php';
        
            // Maak een verbinding met de database
             $conn = getConnection();
             
            // Controleer of de verbinding is gelukt
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Set the character set to utf8mb4
            mysqli_set_charset($conn, "utf8mb4");

            // Voer de SQL-query uit om alle gegevens uit de tabel op te halen
            $sql = "SELECT * FROM `uren`";

            if (isset($_GET['delete'])) {
                $deleteName = $_GET['delete'];
            
                // Verwijder de geselecteerde rij uit de database
                $deleteSql = "DELETE FROM `uren` WHERE naam = '$deleteName'";
                mysqli_query($conn, $deleteSql);
            }
            $result = mysqli_query($conn, $sql);

            // Vul de tabel met de gegevens uit de database
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["naam"] . "</td>";
                echo "<td>" . $row["datum"] . "</td>";
                echo "<td>" . $row["uren"] . "</td>";
                echo "<td>" . $row["project"] . "</td>";
                echo "<td>" . $row["beschrijving"] . "</td>";
                echo "<td><a class='delete-btn' href='?delete=" . $row["naam"] . "'>Verwijderen</a></td>";
                echo "<td><a class='pdf-btn' href='?pdf=" . $row["naam"] . "'>PDF</a></td>";
                echo "</tr>";
            }

            // Sluit de verbinding met de database
            $conn->close();
            ?>
        </table>
    </main>

</body>

</html>
