<?php
session_start();

if (!empty($_SESSION['data_login']) && !empty($_SESSION['hora_login'])) {
    include_once("adminincludes/header.php");

    $data_login =  $_SESSION['data_login'];

    $hora_login = $_SESSION['hora_login'];
} else {
    header('Location:login.php');
}

// DEL produtos
if (!empty($_GET['L']) && $_GET['L'] == 'DP') {

    if (isset($_GET['id']) && !empty($_GET['id'])) {
        include '../includes/db.php';
        $id = $_GET['id'];
        // Obtém os dados de venda do banco de dados
        $sql_venda = "DELETE FROM venda WHERE `venda`.`id_produto` = $id";
        $resultado = $conn->query($sql_venda);
        $sql = "DELETE FROM produtos WHERE `produtos`.`id_produto` = $id";
        $result = $conn->query($sql);
        if ($result) {
            $msg = "Produto deletado com sucesso!";
            $tipo = "success";
            $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
            $stmt_msg = $conn->query($sql_msg);
            $id_msg = $conn->insert_id;
            $_SESSION['id_msg'] = $id_msg;
            header('Location:products.php');
        } else {
            $msg = "Erro ao deletar produto!";
            $tipo = "erro";
            $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
            $stmt_msg = $conn->query($sql_msg);
            $id_msg = $conn->insert_id;
            $_SESSION['id_msg'] = $id_msg;
            header('Location:products.php');
        }
    } else {
        echo 'Sem dados';
    }
}

// DEL vendedores
if (!empty($_GET['L']) && $_GET['L'] == 'DV') {
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        include '../includes/db.php';
        $id = $_GET['id'];
        // Obtém os dados e deleta-os
        $sql = "DELETE FROM vendedores WHERE `vendedores`.`id_vendedor` = $id";
        $result = $conn->query($sql);
        if ($result) {
            $msg = "Vendedor deletado com sucesso!";
            $tipo = "success";
            $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
            $stmt_msg = $conn->query($sql_msg);
            $id_msg = $conn->insert_id;
            $_SESSION['id_msg'] = $id_msg;
            header('Location:/main_project/admin/vendedores.php');
        } else {
            $msg = "Erro ao deletar vendedores!";
            $tipo = "erro";
            $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
            $stmt_msg = $conn->query($sql_msg);
            $id_msg = $conn->insert_id;
            $_SESSION['id_msg'] = $id_msg;
            header('Location:/main_project/admin/vendedores.php');
        }
    } else {
        echo 'Sem dados';
    }
}

if (!empty($_GET['L']) && $_GET['L'] == 'DF') {
    include '../includes/db.php';
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        // Obtém os Fornecedores do banco de dados
        $sql = "DELETE FROM fornecedores WHERE `fornecedores`.`id_fornecedor` = $id";
        $result = $conn->query($sql);
        if ($result) {
            $msg = "Dados do fornecedor deletado com sucesso!";
            $tipo = "success";
            $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
            $stmt_msg = $conn->query($sql_msg);
            $id_msg = $conn->insert_id;
            $_SESSION['id_msg'] = $id_msg;
            header('Location:fornecedores.php');
        } else {
            $msg = "Erro ao deletar dados do fornecedor!";
            $tipo = "erro";
            $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
            $stmt_msg = $conn->query($sql_msg);
            $id_msg = $conn->insert_id;
            $_SESSION['id_msg'] = $id_msg;
            header('Location:fornecedores.php');
        }
    } else {
        echo 'Sem dados';
    }
}
