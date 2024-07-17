<?php
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];

    $conn->begin_transaction();
    // Insere um novo Fornecedore na tabela `Fornecedores`
    $sql = "INSERT INTO Fornecedores (nome, email, telefone, endereco) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nome, $email, $telefone, $endereco);
    $stmt->execute();
    $conn->commit();

    if ($stmt->affected_rows > 0) {
        echo '<script> alert("Fornecedor adicionado com sucesso!")</script>';
    } else {
        echo "Erro ao adicionar fornecedor.";
    }

    $stmt->close();
}

$conn->close();
header("Location:fornecedores.php");
?>