<?php
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $salario = $_POST['salario'];
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $conn->begin_transaction();
    // Insere um novo vendedores na tabela `vendedoreses`
    $sql = "INSERT INTO vendedores (nome, email, telefone, salario, usuario, senha) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiisi", $nome, $email, $telefone, $salario, $usuario, $senha);
    $stmt->execute();
    $conn->commit();

    if ($stmt->affected_rows > 0) {
        $msg = "Vendedor criado com sucesso!";
          $tipo = "success";
          $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
          $stmt_msg = $conn->query($sql_msg);
          $id_msg = $conn->insert_id;
          $_SESSION['id_msg'] = $id_msg;
    } else {
        $msg = "Erro ao criar vendedor! ";
          $tipo = "erro";
          $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
          $stmt_msg = $conn->query($sql_msg); 
          $id_msg = $conn->insert_id;
          $_SESSION['id_msg'] = $id_msg;
    }

    $stmt->close();
}

$conn->close();
header("Location:vendedores.php");
?>