<?php

require_once ("recept_db.php");
include ("myRecipe.php");

//session_start();

if (isset($_SESSION['userid'])) {
    $sql = "SELECT username FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['userid']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $description = isset($_POST["description"]) ? $_POST["description"] : ''; // Ellenőrizd, hogy a description mező be lett-e töltve
            $category = isset($_POST["category"]) ? $_POST["category"] : '';
            $img = isset($_POST["img"]) ? $_POST["img"] : '';

            $sql = "INSERT INTO recipe (title, description, category, user_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $title, $description, $category, $_SESSION['userid']);

            if ($stmt->execute()) {
                $recipeId = $stmt->insert_id;

                // Kép beszúrása az `images` táblába
                $img = $_POST["img"];
                $sql_images = "INSERT INTO images (recipe_id, filename) VALUES (?, ?)";
                $stmt_images = $conn->prepare($sql_images);
                $stmt_images->bind_param("is", $recipeId, $img);

                if ($stmt_images->execute()) {
                    echo "Recept sikeresen hozzáadva!";
                } else {
                    echo "Hiba történt a kép beszúrása során: " . $stmt_images->error;
                }

                $stmt_images->close();
            } else {
                echo "Hiba történt: " . $stmt->error;
            }

            $stmt->close();
        }
    }    
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Új recept</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <h2>Új recept felvétele</h2>
        <form method="post" action="">
            <label for="title">Cím:</label>
            <input type="text" id="title" name="title" required><br>

            <label for="description">Leírás:</label>
            <input type="text" id="author" name="author" required><br>

            <label for="category">Kategória:</label>
            <input type="text" id="category" name="category"><br>

            <label for="img">Kép url:</label>
            <input type="text" id="img" name="img"><br>

            <input type="submit" value="Recept hozzaadasa">
        </form>
    </body>
    </html>
    <?php

} else {
    header("Location: index.php");
}
?>
