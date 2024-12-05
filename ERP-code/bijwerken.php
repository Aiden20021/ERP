<?php
// Inclusief het bestand voor de databaseverbinding
include 'db.php';

// Haal de bijwerkgegevens op uit het formulier
$bijwerkID = $_POST['bijwerkID'];
$bijwerkKlant = $_POST['bijwerkKlant'];
$bijwerkFactuur = $_POST['bijwerkFactuur'];
$bijwerkDatum = $_POST['bijwerkDatum'];
$bijwerkKennis = $_POST['bijwerkKennis'];

// Maak een verbinding met de database
$conn = getConnection();

// Bereid de SQL-query voor om de gegevens bij te werken
$sql = "UPDATE `opdrachten` SET `Klant` = ?, `factuur` = ?, `Aanvraagdatum` = ?, `Benodigde kennis` = ? WHERE `ID` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssis", $bijwerkKlant, $bijwerkFactuur, $bijwerkDatum, $bijwerkKennis, $bijwerkID);

// Voer de query uit
if ($stmt->execute()) {
    echo "Gegevens zijn succesvol bijgewerkt.";
} else {
    echo "Fout bij het bijwerken van de gegevens: " . $stmt->error;
}

// Sluit de statement en de verbinding
$stmt->close();
$conn->close();