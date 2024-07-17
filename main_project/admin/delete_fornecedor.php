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

if(isset($_GET['id']) && !empty($_GET['id']))
{
    $id = $_GET['id'];
    // Obtém os Fornecedores do banco de dados
    $sql = "DELETE FROM fornecedores WHERE `fornecedores`.`id_fornecedor` = $id";
    $result = $conn->query($sql); 
    if($result)
    {
        $msg = "Dados do fornecedor deletado com sucesso!";
        $tipo = "success";
        $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
        $stmt_msg = $conn->query($sql_msg);
        $id_msg = $conn->insert_id;
        $_SESSION['id_msg'] = $id_msg;
        header('Location:fornecedores.php');
    }
    else 
    {
        $msg = "Erro ao deletar dados do fornecedor!";
        $tipo = "erro";
        $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
        $stmt_msg = $conn->query($sql_msg);
        $id_msg = $conn->insert_id;
        $_SESSION['id_msg'] = $id_msg;
        header('Location:fornecedores.php');
    }
}
else 
{
    echo 'Sem dados';
}
?>