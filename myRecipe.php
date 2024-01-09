<?php
session_start();
include ("recept_db.php");

require_once("recept_db.php");
global  $conn;


// Ellenőrizze, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['userid'];
$sql = "SELECT recipe.id, recipe.title, recipe.description, recipe.category, images.filename AS img
        FROM recipe 
        LEFT JOIN images ON recipe.id = images.recipe_id
        WHERE recipe.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saját receptjeim</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
<?php include 'header_nav.php';?>
    <h2>Saját receptjeim</h2>

    <?php if ($result->num_rows > 0) { ?>
        <table>
            <thead>
                <tr>
                    <th colspan=2>Cím</th>
                    <th>Leírás</th>
                    <th>Kategória</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td> <img src=' <?php echo $row["img"] ?>' width='100px'></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>Nincs saját recept jelenleg.</p>
    <?php } ?>

    <form action="add_recipe.php" method="post">
        <label for="title">Cím:</label>
        <input type="text" id="title" name="title" required><br><br>

        <label for="description">Leírás:</label><br>
        <textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>

        <input type="submit" value="Recept hozzáadása">
    </form>

    <a href="index.php">Vissza</a>
</body>
</html>
