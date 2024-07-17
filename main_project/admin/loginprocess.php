<?php
session_start();
include_once '../includes/db.php';
date_default_timezone_set('Africa/Bissau');

$_SESSION['data_login'] = date("d/m/Y");
$_SESSION['hora_login'] = date("H:i");

$data_login = $_SESSION['data_login'];
$hora_login = $_SESSION['hora_login'];

// $sql_msg = "INSERT INTO messages (msg, tipo) VALUES (?,?)";

if (isset($_POST['nome']) && !empty($_POST['nome']) && isset($_POST['senha']) && !empty($_POST['senha'])) {
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    if ($nome == "Johnson49" && $senha == "1234") {
        
        $msg = "Admistrador logado com sucesso às " . $hora_login . ' data: ' . $data_login;
        $tipo = 'success';
        $_SESSION['success_message'] = "Administrador Logado com sucesso!";
        
        header('Location:Dashboard.php');
    } else {
        echo '<div style="display: flex; justify-content:center;flex-direction:column; align-items:center; height:5%; width: 70%;margin:0 5rem; background: rgb(238, 137, 137); border-radius: 10px; border:none; padding:2rem 3rem;">
        <span style="color: white; font-size: 1rem; font-weight:bold; font-family:helvetica;">Nome de usuário ou senha inválidos!</span>    
        <span id="counter" style="color:white; font-weight:bolder; font-size: 2rem; background:dodgerblue;"></span>  
        </div>';
        $msg = "Nome do usuário ou Senha inválidos " . $hora_login . ' data: ' . $data_login;
        $tipo = 'erro';
        $_SESSION['error_message'] = "Erro ao logar administrador!";
    }
    $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
    $stmt_msg = $conn->query($sql_msg);
    

} else {
    echo '<div style="display: flex; justify-content:center;flex-direction:column; align-items:center; height:5%; width: 70%;margin:0 5rem; background: rgb(238, 137, 137); border-radius: 10px; border:none; padding:2rem 3rem;"> 
    <span style="color: white; font-size: 1rem; font-weight:bold; font-family:helvetica;">Erro ao logar!</span>       
    <span id="counter" style="color:white; font-weight:bolder; font-size: 2rem; background:dodgerblue;"></span>   
    </div>';
    $msg = "Erro ao Logar admistrador às " . $hora_login . ' data: ' . $data_login;
    $tipo = "erro";
    $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
    $stmt_msg = $conn->query($sql_msg);
}

$conn->close();
?>
<html>
<style>
    body {
        display: flex;
        justify-content: center;
        width: 100vw;
        background-color: white;
    }
</style>

</html>
<script>
    setTimeout(() => {
        window.location.href = "login.php"
    }, 1000);
</script>