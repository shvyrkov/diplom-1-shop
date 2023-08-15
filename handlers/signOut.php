<?php
// Выход из сессии
if (isset($_GET['signOut']) && $_GET['signOut'] == 'yes') { // Выход
    unset($_SESSION['isAuth']);
    unset($_SESSION['accessProducts']);
    session_destroy();
}
?>
