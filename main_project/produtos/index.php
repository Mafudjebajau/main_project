<?php
include '../includes/db.php';

// Obtém os produtos do banco de dados
$sql = "SELECT * FROM Produtos";
$result = $conn->query($sql);

// Obtém as categorias do banco de dados
$sql_categorias = "SELECT * FROM Categorias";
$result_categorias = $conn->query($sql_categorias);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Produtos</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <h1>Gerenciar Produtos</h1>
    
    <h2>Lista de Produtos</h2>
    <table>
        <thead>
            <th>Id</th>
            <th>Nome</th>
            <th>Preço Venda</th>
            <th>Quantidade</th>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { 
                    echo '<td>'.$row['id_produto'].'</td>';
                    echo '<td>'.$row['nome'].'</td>' ; 
                    $id_produto = $row['id_produto'];
                    $sql_venda = "SELECT preco_venda FROM venda WHERE id_produto = $id_produto";
                    $stmt_venda = $conn->query($sql_venda);
                    while($linha = $stmt_venda->fetch_assoc())
                    {
                        echo '<td>'.$linha['preco_venda'].'</td>';
                    }
                    echo'<td>'. $row['quantidade'].'</td>';
                    echo '<tr>';
             } ?>
        </tbody>
    </table>
    <?php include '../includes/footer.php'; ?>
</body>
</html>