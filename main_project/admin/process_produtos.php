<?php
session_start();
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $price = $_POST['price']; //preço da compra
    $sell_price = $_POST['sell_price']; #preço de venda
    $quantidade = intval($_POST['quantidade']);
    $fornecedor = $_POST['fornecedor'];
    $categoria = $_POST['categoria'];
    

    // SELECIONAR ID NA TABELA COMPRA PEGANDO O ID DO FORNECEDOR
    $sql_select_compra = "SELECT id_compra FROM compra WHERE id_fornecedor = $fornecedor";
    $stmt_select_compra = $conn->query($sql_select_compra);
    $id_select_compra = mysqli_fetch_assoc($stmt_select_compra);
    $id_compra = $id_select_compra['id_compra'];
    // var_dump($id_select_compra);

    $conn->begin_transaction();
    // Insere um novo produto na tabela `produtos`
    $sql_produtos = "INSERT INTO produtos (nome, descricao, quantidade, id_compra, id_categoria) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_produtos);
    $stmt->bind_param("ssiii", $nome, $descricao, $quantidade, $id_compra, $categoria);
    $stmt->execute();
    $last_insert_id = $conn->insert_id;

    $sql_compra = "INSERT INTO compra (preco_compra, id_fornecedor, id_produto,quantidade) VALUES (?,?,?,?)";
    $stmt_compra = $conn->prepare($sql_compra);
    $stmt_compra->bind_param("iiii",$price,$fornecedor, $last_insert_id, $quantidade);
    $stmt_compra->execute();
    $stmt_compra->close();

    $sql_venda = "INSERT INTO venda (preco_venda, id_produto) VALUES (?,?)";
    $stmt_venda = $conn->prepare($sql_venda);
    $stmt_venda->bind_param('ii',$sell_price,$last_insert_id);
    $stmt_venda->execute();
    $stmt_venda->close();

    if ($stmt->affected_rows > 0) 
    {
        $conn->commit();
        $msg = "Produto adicionado com sucesso!";
        $tipo = "success";
        $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
        $stmt_msg = $conn->query($sql_msg);
        $id_msg = $conn->insert_id;
        $_SESSION['id_msg'] = $id_msg;   
    }
    else 
    {
        $msg = "Erro ao adicionar produto! ";
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
header("Location:products.php");
?>