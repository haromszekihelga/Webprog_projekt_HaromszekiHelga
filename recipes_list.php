<?php

$stmt = $conn->query("SELECT * FROM recipe");

if ($stmt === false) {
    die("Query failed: " . $conn->error);
}

// Check if the query returned any rows
if ($stmt->num_rows > 0) {
    // Fetch the results into an associative array
    $recipes = $stmt->fetch_all(MYSQLI_ASSOC);
} else {
    // If there are no recipes, initialize an empty array
    $recipes = [];
}

// Display recipes
foreach ($recipes as $recipe) {
    echo "<div>";
    echo "<h2>" . htmlspecialchars($recipe['title']) . "</h2>";
    echo "<p>" . htmlspecialchars($recipe['description']) . "</p>";

    // Retrieve images for the current recipe
    $stmt_images = $conn->prepare("SELECT filename FROM images WHERE recipe_id = ?");
    $stmt_images->bind_param("i", $recipe['id']);
    $stmt_images->execute();
    $result_images = $stmt_images->get_result();
    $images = $result_images->fetch_all(MYSQLI_ASSOC);

    if ($images) {
        echo "<div>Recept képek:</div>";
        echo "<div>";
        foreach ($images as $image) {
            // Escape image filename when outputting to HTML
            echo "<img src='images'" . htmlspecialchars($image['filename']) . "' alt='Kép'>";
        }
        echo "</div>";
    }

    echo "</div>";
}

// Close the prepared statement
$stmt_images->close();
?>
