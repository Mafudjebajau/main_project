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


  include '../includes/db.php';
  if(isset($_POST['confirm']))
  {
    $id = $_SESSION['get_id'];
      $nome = $_POST['nome'];
      $email = $_POST['email'];
      $telefone = $_POST['telefone']; 
      $salario = $_POST['salario'];
      $usuario = $_POST['usuario'];
      $senha = $_POST['senha'];
  
      $sql_Update = "UPDATE `vendedores` SET `nome` = '$nome', `email` = '$email', `telefone` = '$telefone', `salario` = '$salario', `usuario` = '$usuario', `senha` = '$senha'  WHERE id_vendedor = $id";
      $res = $conn->query($sql_Update);
      if($res)
      {
          $msg = "Dados do vendedor editado com sucesso!";
          $tipo = "success";
          $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
          $stmt_msg = $conn->query($sql_msg);
          $id_msg = $conn->insert_id;
          $_SESSION['id_msg'] = $id_msg;
          unset($_SESSION['get_id']);
      }
      else 
      {
          $msg = "Erro ao editar dados do vendedor! ";
          $tipo = "erro";
          $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
          $stmt_msg = $conn->query($sql_msg); 
          $id_msg = $conn->insert_id;
          $_SESSION['id_msg'] = $id_msg;
      }
      
      header('Location:vendedores.php');
  
  }
  
  if(isset($_GET['id']) && !empty($_GET['id']))
  {
      $id = $_GET['id'];
      $_SESSION['get_id'] = $id;
      // Obtém os vendedores do banco de dados
      $sql = "SELECT * FROM vendedores WHERE id_vendedor = $id";
      $result = $conn->query($sql);
      $row = mysqli_fetch_assoc($result);
  }
  else 
  {
      echo 'Sem dados';
  }
  ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Editar Vendedor</title>
</head>
<body>
<section class="centro" style="justify-content: space-around;">

<div>
    <h1>Editar vendedor</h1>
    <form action="edit_vendedor.php" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $row['nome'];?>" required>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="<?php echo $row['email'];?>" required>
        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" value="<?php echo $row['telefone'];?>" required>
        <label for="salario">Salario:</label>
        <input type="text" id="salario" name="salario" value="<?php echo $row['salario'];?>" required>
        <label for="usuario">Usuário:</label>
        <input type="text" id="usuario" name="usuario" value="<?php echo $row['usuario'];?>" required>
        <label for="senha">Salario:</label>
        <input type="text" id="senha" name="senha" value="<?php echo $row['senha'];?>" required style="border:2px solid red;">

        <button type="submit" name="confirm">Confirmar</button>
    </form>
</div>
</section>
</body>
</html>