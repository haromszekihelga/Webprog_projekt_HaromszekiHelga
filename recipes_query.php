<?php
require_once('recept_db.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Receptek lekérdezése
$stmt = $conn->prepare("SELECT * FROM recipe");
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $recipes = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $recipes = [];
    echo "Nincs eredmény a lekérdezésben.";
}

?>
