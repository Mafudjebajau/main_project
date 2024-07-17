<?php
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $id_categoria = $_POST['id_categoria'];
    $quantidade = $_POST['quantidade'];

    // Insere um novo produto na tabela `Produtos`
    $sql = "INSERT INTO Produtos (nome, descricao, preco, id_categoria, quantidade) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdii", $nome, $descricao, $preco, $id_categoria, $quantidade);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Produto adicionado com sucesso!";
    } else {
        echo "Erro ao adicionar produto.";
    }

    $stmt->close();
}

$conn->close();
header("Location: index.php");
?>