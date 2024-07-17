<?php 
session_start();

if(!empty($_SESSION['data_login']))
{
    include_once('../includes/db.php');
    include_once("adminincludes/header.php");
    echo $_SESSION['data_login'];
    $sql_compra = "SELECT id_compra,preco_compra, id_fornecedor, id_produto FROM compra";
    $stmt_compra = $conn->query($sql_compra);
} 
else 
{
    header('Location:login.php');
}
?>


<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>compras</title>
</head>
<body>
    <table>
        <thead>
            <th>ID</th>
            <th>Preço Compra</th>
            <th>Produto</th>
            <th>Fornecedor</th>
        </thead>
        <tbody>
            <?php 
            if(!empty($_SESSION['data_login']))
            {   
                while($row = mysqli_fetch_assoc($stmt_compra))
                {

                    echo '<td>'.$row['id_compra'].'</td>';
                    echo '<td>'.$row['preco_compra'].'</td>';
                    $id = $row['id_produto'];
                    $sql = "SELECT nome FROM produtos WHERE id_produto = $id";
                    $pr = $conn->query($sql);
                    
                    while ($rows = mysqli_fetch_assoc($pr)) {
                        # code...
                        echo '<td>'.$rows['nome'].'</td>';
                    }
                    $id_fornecedor = $row['id_fornecedor'];
                    $sql_fornecedor = "SELECT nome FROM fornecedores where id_fornecedor = $id_fornecedor";
                    $stmt_fornecedor = $conn->query($sql_fornecedor);
                    if(mysqli_num_rows($stmt_fornecedor) > 0)
                    {
                        while ($row_fornecedor = mysqli_fetch_assoc($stmt_fornecedor)) 
                        {
                        # code...
                    
                            echo '<td>'.$row_fornecedor['nome'].'</td>';
                        }
                    }
                    else 
                    {
                        echo "<td>Sem dados</td>";
                    }
                
                    echo '<tr>';
                
                }
            }
            else 
            {
                header('Location:login.php');
            }
            ?>
        </tbody>
    </table>
</body>
</html>


