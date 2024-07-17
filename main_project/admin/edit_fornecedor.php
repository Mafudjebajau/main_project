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
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];

    $sql_Update = "UPDATE `fornecedores` SET `nome` = '$nome', `email` = '$email', `telefone` = '$telefone', `endereco` = '$endereco' WHERE id_fornecedor = 2";
    $res = $conn->query($sql_Update);
    if($res)
    {
        $msg = "Dados do fornecedor editado com sucesso!";
        $tipo = "success";
        $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
        $stmt_msg = $conn->query($sql_msg);
        $id_msg = $conn->insert_id;
        $_SESSION['id_msg'] = $id_msg;
    }
    else 
    {
        $msg = "Erro ao editar dados do fornecedor! ";
        $tipo = "erro";
        $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
        $stmt_msg = $conn->query($sql_msg); 
        $id_msg = $conn->insert_id;
        $_SESSION['id_msg'] = $id_msg;
    }
    
    header('Location:fornecedores.php');

}

if(isset($_GET['id']) && !empty($_GET['id']))
{
    $id = $_GET['id'];
    // Obtém os Fornecedores do banco de dados
    $sql = "SELECT * FROM fornecedores WHERE id_fornecedor = $id";
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
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
            <h1 class="a-center">Editar Fornecedor</h1>
            <form action="edit_fornecedor.php" method="post">
              
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required value="<?php echo $row['nome'] ?>">
            
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required value="<?php echo $row['email']; ?>">
            
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" value="<?php echo $row['telefone'];?>">
            
                <label for="endereco">Endereço:</label>
                <input type="text" id="endereco" name="endereco" value="<?php echo $row['endereco']; ?>">
            
                <button type="submit" name="confirm">Confirmar</button>
            </form>
        </div>

</body>
</html>