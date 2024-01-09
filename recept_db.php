<?php
// Kapcsolódás az adatbázishoz
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "receptek_app";

// Adatbázis kapcsolódás létrehozása
$conn = new mysqli($servername, $username, $password);

// Kapcsolódás ellenőrzése
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

// Ellenőrizzük, hogy az adatbázis létezik-e
$result = $conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
if (!$result) {
    echo "Hiba az adatbázis létrehozása során: " . $conn->error;
}

// Adatbázis kiválasztása
$conn->select_db($dbname);

// Táblak létrehozása

$sql_create_table="CREATE TABLE IF NOT EXISTS users(
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
)";
/*
if ($conn->query($sql_create_table) === TRUE) {
    echo "Table 'users' created successfully\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}*/

$sql_create_table = "CREATE TABLE IF NOT EXISTS recipe (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    category VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES users(id)
)";
/*
if ($conn->query($sql_create_table) === TRUE) {
    echo "Table 'recipe' created successfully\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}*/

$sql_create_table= "CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
)";
/*
if ($conn->query($sql_create_table) === TRUE) {
    echo "Table 'categories' created successfully\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}*/

$sql_create_table="CREATE TABLE IF NOT EXISTS images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipe_id INT NOT NULL,
    filename VARCHAR(100) NOT NULL,
    FOREIGN KEY (recipe_id) REFERENCES recipe(id)
)";
/*
if ($conn->query($sql_create_table) === TRUE) {
    echo "Table 'images' created successfully\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}*/

// Példa adatok beszúrására a recept táblába
//$sql_insert_recipe = "INSERT INTO recipe (user_id, title, description, category) VALUES (?, ?, ?, ?)";
/*$stmt = $conn->prepare($sql_insert_recipe);
if ($stmt) {
    $user_id = 1;
    $title = "Recept címe";
    $description = "Recept leírása...";
    $category = "Kategória";
    $stmt->bind_param("isss", $user_id, $title, $description, $category);
    $stmt->execute();
} else {
    echo "Hiba a lekérdezés előkészítésekor: " . $conn->error;
}*/

$sql_inser_categories="INSERT INTO categories (name) VALUES (?)";
/*$stmt = $conn->prepare($sql_insert_categories);
if ($stmt) {
    $category_name = "Kategória neve";
    $stmt->bind_param("s", $category_name);
    $stmt->execute();
} else {
    echo "Hiba a lekérdezés előkészítésekor: " . $conn->error;
}*/

$sql_insert_users="INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql_insert_users);
if ($stmt) {
    $username = "Felhasználónév";
    $email = "email@example.com";
    $password = "jelszo";
    $stmt->bind_param("sss", $username, $email, $password);
    $stmt->execute();
} else {
    echo "Hiba a lekérdezés előkészítésekor: " . $conn->error;
}

$sql_insert_images="INSERT INTO images (recipe_id, filename) VALUES (?,?)";
/*$stmt = $conn->prepare($sql_insert_images);
if ($stmt) {
    $recipe_id = 1; 
    $filename = "kep.jpg";
    $stmt->bind_param("is", $recipe_id, $filename);
    $stmt->execute();
} else {
    echo "Hiba a lekérdezés előkészítésekor: " . $conn->error;
}*/

?>
