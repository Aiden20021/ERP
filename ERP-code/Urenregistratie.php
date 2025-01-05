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
    <title>Urenregistratie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url("manger.jpg");            background-size: cover;
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
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="#">Uren invullen</a></li>
                <li><a href="#">Werkzaamheden</a></li>
                <li><a href="#">Medewerkers</a></li>
                <li><a href="#">Opdrachten</a></li>
                <li><a href="#">Klanten</a></li>
            </ul>
        </nav>
        <span class="header-greeting">Hallo Medewerker</span>
    </header>
      
    <main>
        <h2>Registratie</h2>
    
        <form>
            <label for="datum">Datum:</label>
            <input type="date" id="datum">
    
            <label for="uren">Aantal uren:</label>
            <input type="number" id="uren" min="1">
    
            <label for="opdrachten">Opdrachten:</label>
            <select id="opdrachten">
                <option value="opdracht1">Opdracht 1</option>
                <option value="opdracht2">Opdracht 2</option>
                <option value="opdracht3">Opdracht 3</option>
            </select>
    
            <label for="beschrijving">Beschrijving:</label>
            <textarea id="beschrijving" rows="4" cols="50"></textarea>
    
            <input type="submit" value="Toevoegen">
        </form>
    </main>
</body>
</html>
