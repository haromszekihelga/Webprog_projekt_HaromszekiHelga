<?php

//include ('myRecipe.php');
require_once('recipes_query.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receptek</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
<?php include 'header_nav.php'; ?>

    <h1>Receptek</h1>

    <?php if (!empty($recipes)) : ?>
        <?php foreach ($recipes as $recipe) : ?>
            <div>
                <h2><?= $recipe['title']; ?></h2>
                <p><?= $recipe['description']; ?></p>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Nincs elérhető recept.</p>
    <?php endif; ?>  

    <a href="index.php">Vissza</a>
    
<script src="scripts.js"></script>
</body>
</html>
