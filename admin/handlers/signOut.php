<?php
// Выход из сессии
if (isset($_GET['signOut']) && $_GET['signOut'] == 'yes') { // Выход
    if (isset($_SESSION['isAuth'])) {
        unset($_SESSION['isAuth']);
     }

     if (isset($_SESSION['accessProducts'])) {
        unset($_SESSION['accessProducts']);
     }

     session_destroy();
}

?>
