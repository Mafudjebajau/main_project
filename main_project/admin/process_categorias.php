<?php
session_start();
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];

    // inicia a transação
    $conn->begin_transaction();
    // Insere um novo Categoria na tabela `Categorias`
    $sql = "INSERT INTO categorias (nome, descricao) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nome, $descricao);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $conn->commit();
        $msg = "Categoria adicionado com sucesso!".date("h:m-;-d/m/Y");
        $tipo = "success";
        $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
        $stmt_msg = $conn->query($sql_msg);
        $id_msg = $conn->insert_id;
        $_SESSION['id_msg'] = $id_msg;
    } else {
        $msg = "Erro ao adicionar Categoria! ".date("h:m-;-d/m/Y");
        $tipo = "erro";
        $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
        $stmt_msg = $conn->query($sql_msg);
        $id_msg = $conn->insert_id;
        $_SESSION['id_msg'] = $id_msg;
        $conn->rollback();
    }
    $stmt->close();
}

$conn->close();
header("Location:Categorias.php");
