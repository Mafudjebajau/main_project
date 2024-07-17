<?php 
    session_start();
    unset($_SESSION['data_login']);
    unset($_SESSION['hora_login']); 
    session_destroy();
    var_dump($_SESSION);
    header('Location:/main_project/index.php');
?>