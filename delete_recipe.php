<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "receptek_app";

// Adatbázis kapcsolódás létrehozása
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

// Handle recipe deletion
if (isset($_GET['delete_recipe'])) {
    $recipeId = $_GET['delete_recipe'];

    // Delete the recipe from the 'recipe' table
    $deleteRecipeSql = "DELETE FROM recipe WHERE id = ?";
    $stmt = $conn->prepare($deleteRecipeSql);
    $stmt->bind_param("i", $recipeId);
    $stmt->execute();
    $stmt->close();

    // Delete related images from the 'images' table
    $deleteImagesSql = "DELETE FROM images WHERE recipe_id = ?";
    $stmt = $conn->prepare($deleteImagesSql);
    $stmt->bind_param("i", $recipeId);
    $stmt->execute();
    $stmt->close();

    // Redirect back to the recipes list
    header("Location: recipes_list.php");
    exit();
}

// Fetch and display recipes
$stmt = $conn->query("SELECT * FROM recipe");

if ($stmt === false) {
    die("Query failed: " . $conn->error);
}

$recipes = [];

if ($stmt->num_rows > 0) {
    $recipes = $stmt->fetch_all(MYSQLI_ASSOC);
}

// Display recipes
foreach ($recipes as $recipe) {
    echo "<div>";
    echo "<h2>" . $recipe['title'] . "</h2>";
    echo "<p>" . $recipe['description'] . "</p>";

    // Delete recipe button
    echo "<form method='post'>";
    echo "<input type='hidden' name='delete_recipe' value='" . $recipe['id'] . "'>";
    echo "<input type='submit' value='Törlés'>";
    echo "</form>";

    echo "</div>";
}

// Close the database connection
$conn->close();
?>
