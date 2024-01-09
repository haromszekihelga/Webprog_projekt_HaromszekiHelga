<?php
session_start();
$error="";

require_once("recept_db.php");
//require_once("header_nav.php");
global $conn;

//include 'recept_db.php';

if (isset($_SESSION['userid'])){
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['username']) && isset($_POST['password'])) {
        $_SESSION['userid'] = $userid; 
        header("Location: index.php"); // Átirányítás az index oldalra
        exit();
    }

    // Ellenőrizze a felhasználónevet és a jelszót
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    // Kérdezzük le az adatbázisból a user-t az email alapján
    $sql = "SELECT id, username, email, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user && password_verify($password, $user['password'])) {
        // Sikeres bejelentkezés, beállítjuk a session változót
        $_SESSION['userid'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php"); // Átirányítás a főoldalra
        exit();
    }
    else {
        $error = "Hibás email vagy jelszó";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <main>
    <?php include 'header_nav.php';?>

    <h2>Bejelentkezés</h2>

    <?php if (!empty($error)) { ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php } ?>

    <form method="post" action="">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Jelszó:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Bejelentkezés">
    </form>
    <p> Még nem regisztráltál? <a href="registration.php">Regisztrálj! </a></p>
    <script src="scripts.js"></script>
    </main>
</body>
</html>