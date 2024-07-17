<?php
session_start();
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cliente = $_POST['id_cliente'];
    $id_vendedor = $_POST['id_vendedor'];
    $produtos = $_POST['produtos'];
    $quantidades = $_POST['quantidades'];
    $paymentmethod = $_POST['paymentmethod'];


    // $_SESSION['w'] = $quantidades;
  
    if(empty($produtos))
    {
        $_SESSION['err'] = "Erro ao registrar venda! Nenhum produto foi selecionado";
        $conn->rollback();
        header('Location:index.php');  
    }
    

    // produtos = id produto
    date_default_timezone_set('Africa/Bissau');
    $data_atual = date("Y-m-d");

    // Inicia a transação
    $conn->begin_transaction();

    try {

        $sql_pay = "INSERT INTO pagamentos (id_pedido, metodo, valor) VALUES (?,?,?)";
        $stm_pay = $conn->prepare($sql_pay);
        
        $sql_vendido = "INSERT INTO produto_vendido (id_produto_pedido, preco_vendido, id_vendedor, quantidade) VALUES (?,?,?,?)";
        $stmt_vendido = $conn->prepare($sql_vendido);
        
        // Insere uma nova venda na tabela `Pedidos`
        $sql_pedido = "INSERT INTO pedidos (data_pedido, id_cliente, id_vendedor) VALUES ( '$data_atual','$id_cliente','$id_vendedor')";
        $stmt_pedido = $conn->execute_query($sql_pedido);
        
        $id_pedido = $conn->insert_id; // Obtém o ID do pedido recém-inserido
        
        // Insere cada produto vendido na tabela `Produto_Pedido`
        $sql_produto_pedido = "INSERT INTO produto_pedido (id_pedido, quantidade, preco_unitario) VALUES (?, ?, ?)";
        $stmt_produto_pedido = $conn->prepare($sql_produto_pedido);

        foreach ($produtos as $id_produto) {
            $quantidade = $quantidades[$id_produto];
            // Obter o preço do produto
            $sql_preco_produto = "SELECT preco_venda FROM venda WHERE id_produto = ?";
            $stmt_preco_produto = $conn->prepare($sql_preco_produto);
            $stmt_preco_produto->bind_param("i", $id_produto);
            $stmt_preco_produto->execute();
            $stmt_preco_produto->bind_result($preco);
            $stmt_preco_produto->fetch();
            $stmt_preco_produto->close();

            // Insere o produto vendido na tabela `Produto_Pedido`
            $stmt_produto_pedido->bind_param("iii", $id_pedido, $quantidade, $preco);
            $stmt_produto_pedido->execute();

            // Atualiza a quantidade no estoque
            $sql_atualiza_estoque = "UPDATE Produtos SET quantidade = quantidade - ? WHERE id_produto = ?";
            $stmt_atualiza_estoque = $conn->prepare($sql_atualiza_estoque);
            $stmt_atualiza_estoque->bind_param("ii", $quantidade, $id_produto);
            $stmt_atualiza_estoque->execute();

            $stmt_vendido->bind_param('iiii', $id_produto, $preco, $id_vendedor, $quantidade);
            $stmt_vendido->execute();

            if($paymentmethod == 'caixa')
            {
                $method = 'caixa';
                $stm_pay->bind_param('isd',$id_pedido,$method,$preco);
                $stm_pay->execute();
            }
            elseif($paymentmethod == 'orm')
            {
                $method = 'orm';
                $stm_pay->bind_param('isd',$id_pedido,$method,$preco);
                $stm_pay->execute();
            }
            elseif($paymentmethod == 'mbm')
            {
                $method = 'mbm';
                $stm_pay->bind_param('isd',$id_pedido,$method,$preco);
                $stm_pay->execute();
            }
            elseif($paymentmethod == 'cc')
            {
                $method = 'caixa';
                $stm_pay->bind_param('isd',$id_pedido,$method,$preco);
                $stm_pay->execute();
            }
            else
            {
                header('Location:index.php');
            }
        }

        if ($stmt_vendido->affected_rows > 0) {
            $conn->commit();
            $msg = "Venda realizada com sucesso!".date("h:m,d/m/Y");
            $tipo = "success";
            $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
            $stmt_msg = $conn->query($sql_msg);
            $id_msg = $conn->insert_id;
            $_SESSION['id_msg'] = $id_msg;
        } else {
            $msg = "Erro ao registrar venda! ".date("h:m,d/m/Y");
            $tipo = "erro";
            $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
            $stmt_msg = $conn->query($sql_msg);
            $id_msg = $conn->insert_id;
            $_SESSION['id_msg'] = $id_msg;
            $conn->rollback();
        }

        $stmt_produto_pedido->close();
        header('Location:index.php');
    } catch (Exception $e) {
        // Reverte a transação em caso de erro
        $msg = "Erro ao registrar a venda: ";
        $tipo = "erro";
        $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
        $stmt_msg = $conn->query($sql_msg);
        $id_msg = $conn->insert_id;
        $_SESSION['id_msg'] = $id_msg;
        $conn->rollback();
        header('Location:index.php');
    }
}

$conn->close();
?>