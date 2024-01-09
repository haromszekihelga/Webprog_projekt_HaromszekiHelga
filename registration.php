<?php
session_start();
require_once ('recept_db.php');

if (isset($_SESSION['userid'])) {
    header("Location: index.php"); // Átirányítás a főoldalra, ha már be van jelentkezve
    exit();
}

// Ellenőrizzük, hogy a POST kérés beküldték-e (az űrlap elküldése)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST["username"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT); // Jelszó hashelése

    // Új felhasználó hozzáadása az adatbázishoz
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        // Sikeres regisztráció, átirányítás a bejelentkezési oldalra
        header("Location: login.php");
        exit();
    } else {
        $error = "Hiba a regisztráció során.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
<?php include 'header_nav.php'; ?>

<h2>Regisztráció</h2>

<?php if (isset($error)) { ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php } ?>

<form method="post" action="">
    <label for="name">Teljes név:</label>
    <input type="text" id="name" name="name" required><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="password">Jelszó:</label>
    <input type="password" id="password" name="password" required><br>

    <input type="submit" value="Regisztráció">
</form>

<p>Már van fiókja? <a href="login.php">Jelentkezzen be</a></p>
<script src="scripts.js"></script>
</body>
</html>