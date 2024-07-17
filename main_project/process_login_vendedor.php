<?php
session_start();
include 'includes/footer.php';
include_once('includes/db.php');
date_default_timezone_set('Africa/Bissau');

if (isset($_POST['logarvendedor'])) {
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];
    $sql_select = "SELECT id_vendedor, usuario, senha FROM vendedores WHERE usuario = '$nome' AND  senha = '$senha'";
    $stmt = $conn->query($sql_select);

    if ($stmt->num_rows > 0) {
        $stmt_res = mysqli_fetch_assoc($stmt);
        $_SESSION['id_vendedor'] = $stmt_res['id_vendedor'];
        $msg = "Vendedor logado com sucesso às ".date("h:m-;-d,m,Y");
        $tipo = "success";
        $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
        $stmt_msg = $conn->query($sql_msg);
        $id_msg = $conn->insert_id;
        $_SESSION['id_msg'] = $id_msg;
        header('Location:vendas/index.php');
    } else {
        $msg = "Erro ao Logar vendedor! ".date("h:m-;-d,m,Y");
        $tipo = "erro";
        $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
        $stmt_msg = $conn->query($sql_msg);
        $id_msg = $conn->insert_id;
        $_SESSION['id_msg'] = $id_msg;
        $conn->rollback();
        header('Location:index.php');
    }
}
