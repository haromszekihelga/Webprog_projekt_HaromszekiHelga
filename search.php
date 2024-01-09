<?php
session_start();
include ("recept_db.php");

require_once("recept_db.php");
global  $conn;

$limit = isset($_GET['limit']) && is_numeric($_GET['limit']) ? $_GET['limit'] : 10;
if ($limit > 25) $limit = 25;

$_GET['limit'] = $limit;

// GET paraméterek ellenőrzése és értékük kinyerése
$title = isset($_GET['title']) ? $_GET['title'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Az aktuális oldal kinyerése
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
// Az OFFSET számítása az aktuális oldal alapján
$offset = ($page - 1) * $limit;

$userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;

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
    <title>Receptek kereses</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
<?php include 'header_nav.php';?>

<!-- Kereső űrlap -->
<form action="" method="get">
    
    <label for="title">Cím:</label>
    <input type="text" id="title" name="title" value="<?php echo isset($_GET['title']) ? htmlspecialchars($_GET['title']) : ''; ?>">

    <label for="limit">Limit / oldal:</label>
    <input type="number" id="limit" min=1 name="limit" value="<?php echo isset($_GET['limit']) ? htmlspecialchars($_GET['limit']) : ''; ?>">

    <input type="submit" value="Szűrés">
</form>
    <h2>Receptek listaja</h2>
    <?php include('recipes_list.php');?>
    <?php if ($result->num_rows > 0) { ?>
        <table>
            <!--<thead>
                <tr>
                    <th colspan=2>Cím</th>
                    <th>Leírás</th>
                    <th>Kategória</th>
                    
                </tr>
            </thead>-->
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
    <?php /*} else { ?>
        <p>Nincs recept az adatbazisban.</p>*/
    } ?>

    <a href="index.php">Vissza</a>
</body>
</html>
