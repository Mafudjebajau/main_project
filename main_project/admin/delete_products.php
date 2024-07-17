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

if(isset($_GET['id']) && !empty($_GET['id']))
{
    include '../includes/db.php';
    $id = $_GET['id'];
    // Obtém os dados de venda do banco de dados
    $sql_venda = "DELETE FROM venda WHERE `venda`.`id_produto` = $id";
    $resultado = $conn->query($sql_venda); 
    $sql = "DELETE FROM produtos WHERE `produtos`.`id_produto` = $id";
    $result = $conn->query($sql); 
    if($result)
    {
        $msg = "Produto deletado com sucesso!";
        $tipo = "success";
        $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
        $stmt_msg = $conn->query($sql_msg);
        $id_msg = $conn->insert_id;
        $_SESSION['id_msg'] = $id_msg;
        header('Location:products.php');
    }
    else 
    {
        $msg = "Erro ao deletar produto!";
        $tipo = "erro";
        $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
        $stmt_msg = $conn->query($sql_msg);
        $id_msg = $conn->insert_id;
        $_SESSION['id_msg'] = $id_msg;
        header('Location:products.php');
    }
}
else 
{
    echo 'Sem dados';
}
?>