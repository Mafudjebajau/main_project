<?php
  session_start();
        
  if (!empty($_SESSION['data_login']) && !empty($_SESSION['hora_login'])) 
  {
      include_once("adminincludes/header.php");
  
      $data_login =  $_SESSION['data_login'];   

      $hora_login = $_SESSION['hora_login'];
 
  }
  else 
  {
      header('Location:login.php');
  }

?>
<?php
include '../includes/db.php';
if(isset($_POST['confirm']))
{
    $nome = $_POST['nome']; //produto 
    $descricao = $_POST['descricao']; //produto
    $preco_compra = $_POST['preco_compra']; //compra
    $preco_venda = $_POST['preco_venda'];//venda
    $quantidade = $_POST['quantidade']; //produto

    $id = $_SESSION['id_produto'];
    $sql_Update_produtos = "UPDATE `produtos` SET `nome` = '$nome', `descricao` = '$descricao', `quantidade` = '$quantidade' WHERE id_produto = $id";
    $res = $conn->query($sql_Update_produtos);

    $sql_Update_compra = "UPDATE compra SET preco_compra = $preco_compra WHERE id_produto = $id";
    $res_update_compra = $conn->query($sql_Update_compra);

    $sql_Update_venda = "UPDATE venda SET preco_venda = $preco_venda WHERE id_produto = $id";
    $res_update_venda = $conn->query($sql_Update_venda);

    if($res && $res_update_compra && $res_update_venda)
    {
        $msg = "Dados do produto editado com sucesso!";
        $tipo = "success";
        $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
        $stmt_msg = $conn->query($sql_msg);
        $id_msg = $conn->insert_id;
        $_SESSION['id_msg'] = $id_msg;
    }
    else 
    {
        $msg = "Erro ao editar dados do do produto! ";
        $tipo = "erro";
        $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
        $stmt_msg = $conn->query($sql_msg); 
        $id_msg = $conn->insert_id;
        $_SESSION['id_msg'] = $id_msg;
        $conn->rollback();
    }
    
    header('Location:products.php');
    unset($_SESSION['id_produto']);
}

if(isset($_GET['id']) && !empty($_GET['id']))
{
    $id = $_GET['id'];
    $_SESSION['id_produto'] = $id;
    // Obtém os Fornecedores do banco de dados
    $sql = "SELECT * FROM produtos WHERE id_produto = $id";
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);

    $sql_select_venda = "SELECT preco_venda FROM venda WHERE id_produto = $id";
    $res_select_venda = $conn->query($sql_select_venda);
    $res_venda = mysqli_fetch_assoc($res_select_venda);

    $sql_select_compra = "SELECT preco_compra FROM compra WHERE id_produto = $id";
    $res_select_compra = $conn->query($sql_select_compra);
    $res_compra = mysqli_fetch_assoc($res_select_compra);
 
}
else 
{
    echo 'Sem dados';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Fornecedores</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include_once("adminincludes/header.php"); ?>
    <section class="centro">
        <div>
            <h1 class="a-center">Editar Produto</h1>
            <form action="edit_products.php" method="post">
              
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required value="<?php echo $row['nome'] ?>">
            
                <label for="descricao">Descrição:</label>
                <input type="descricao" id="descricao" name="descricao" required value="<?php echo $row['descricao']; ?>">
            
                <label for="preco_compra">Preço compra:</label>
                <input type="text" id="preco_compra" name="preco_compra" value="<?php echo $res_compra['preco_compra'];?>">
                

                <label for="preco_venda">Preço venda:</label>
                <input type="text" id="preco_venda" name="preco_venda" value="<?php echo $res_venda['preco_venda']; ?>">

                <label for="quantidade">Quantidade:</label>
                <input type="text" id="quantidade" name="quantidade" value="<?php echo $row['quantidade']; ?>">
            
                <button type="submit" name="confirm">Confirmar</button>
            </form>
        </div>

</body>
</html>