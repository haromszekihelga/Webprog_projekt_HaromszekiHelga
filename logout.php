<?php
require_once("recept_db.php");

session_start();

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (isset($_SESSION['userid'])) {
    // Töröljük a felhasználó munkamenetét
    session_unset();
    session_destroy(); 

    // Átirányítás a bejelentkezési oldalra
    header("Location: index.php");
    exit();
} else {
    // Ha a felhasználó már kijelentkezett vagy nincs bejelentkezve, akkor átirányítjuk a bejelentkezési oldalra
    header("Location: index.php");
    exit();
}
?>
