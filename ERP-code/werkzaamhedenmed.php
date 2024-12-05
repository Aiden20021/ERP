<?php
    include 'db.php';
        
    // Maak een verbinding met de database
     $conn = getConnection();

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

$sql = "SELECT * FROM uren";
$result = $conn->query($sql);
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
        
        table {
    margin: 40px auto 0; /* Aangepaste margin-top-waarde */
    border-collapse: collapse;
    width: 80%;
    background-color: #fff;
}

        table th,
        table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        table th {
            background-color: #333;
            color: #fff;
        }
        
        table tr:hover {
            background-color: #f5f5f5;
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
                    <a href="uren.php">
                        <div class="header-title">
                            <span>Uren</span>
                            <span>Invullen</span>
                        </div>
                    </a>
                </li>
                <li><a href="werkzaamhedenmed.php" class="active">Werkzaamheden</a></li>
                <li><a href="opdrachtenmed.php">Opdrachten</a></li>
                <li><a href="klantenmed.php">Klanten</a></li>
            </ul>
        </nav>
        <a href="user_page.php"><button style="position: absolute; top: 20px; left: 20px;">Terug</button></a>

        <span class="header-greeting"></span>
    </header>

    <table>
        <tr>
        <th>naam</th>
            <th>Datum</th>
            <th>Uren</th>
            <th>Project</th>
            <th>Beschrijving</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["naam"] . "</td>";
                echo "<td>" . $row["datum"] . "</td>";
                echo "<td>" . $row["uren"] . "</td>";
                echo "<td>" . $row["project"] . "</td>";
                echo "<td>" . $row["beschrijving"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Geen gegevens gevonden.</td></tr>";
        }
        ?>
    </table>
   
</body>
</html>

<?php
$conn->close();
?>
