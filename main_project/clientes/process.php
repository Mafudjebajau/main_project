<?php
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];

    // Insere um novo cliente na tabela `Clientes`
    $sql = "INSERT INTO Clientes (nome, email, telefone, endereco) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nome, $email, $telefone, $endereco);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Cliente adicionado com sucesso!";
    } else {
        echo "Erro ao adicionar cliente.";
    }

    $stmt->close();
}

$conn->close();
header("Location: index.php");
?>