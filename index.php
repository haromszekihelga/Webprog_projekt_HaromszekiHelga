<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Receptgyűjtemény</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

<?php include 'header_nav.php'; ?>

<main>
    <div class="recipes-container" id="recipes-container">
    <?php
    include 'recept_db.php';
    include 'recipes_list.php';

    ?>
    </div>
</main>

<footer>

    <h2>Biztosan ki szeretne jelentkezni?</h2>

    <form action="logout.php" method="post">
        <input type="submit" value="Kijelentkezés">
    </form>

</footer>
</body>
</html>


