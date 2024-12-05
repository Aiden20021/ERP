<!DOCTYPE html>
<html>
<head>
    <title>Urenregistratie</title>
    <style>
        table, th, td{ 
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
            text-align: center;
            margin: auto; 
            background-color: #fff; 
            color: #000;
        }

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

        table tr:first-child th { 
            background-color: #333; 
            color: white; 
        }
        
        
    </style>
    <script>
        function searchTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("klantenTable");
            tr = table.getElementsByTagName("tr");

            // Loop door alle rijen en verberg degene die niet overeenkomen met de zoekopdracht
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1]; 
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
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
      
    <?php
         include 'db.php';
        
        // Maak een verbinding met de database
        $conn = getConnection();
        
        // Controleer of de verbinding is gelukt
        if (!$conn) {  
            die("Connection failed: " . mysqli_connect_error());
        }
        
        // Set the character set to utf8mb4
        mysqli_set_charset($conn,"utf8mb4");
        
        // Voer de SQL-query uit om alle gegevens uit de tabel op te halen
        $sql = "SELECT * FROM `klanten`";
        $result = mysqli_query($conn, $sql);
        
        // Maak een HTML-tabel en vul deze met de gegevens uit de database
        echo "<input type='text' id='searchInput' onkeyup='searchTable()' placeholder='Zoeken op bedrijfsnaam'>"; 
        echo "<div class='table-container'>"; 
        echo "<table id='klantenTable'>"; 
        echo "<tr><th>ID</th><th>Bedrijfsnaam</th><th>Functie</th><th>E-Mail</th><th>Adres</th><th>Telefoon nummer</th><th>Postcode</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["ID"] . "</td>";
            echo "<td>" . $row["Bedrijfsnaam"] . "</td>";
            echo "<td>" . $row["Functie"] . "</td>";
            echo "<td>" . $row["E-Mail"] . "</td>";
            echo "<td>" . $row["Adres"] . "</td>";
            echo "<td>" . $row["Telefoon nummer"] . "</td>";
            echo "<td>" . $row["Postcode"] . "</td>";

            echo "</tr>";
        }
        echo "</table>";
        echo "</div>"; 
        
        // Sluit de verbinding met de database
        $conn->close();
        
    ?>
    
</body>
</html>
