<?php session_start();

if (isset($_SESSION['UserName'])){
    unset($_SESSION['UserName']); // xóa session login
}
session_destroy();

header('Location: login.php?Something=false');
?>
