<?php
session_start();
if (!isset($_SESSION['id_vendedor'])) {
    header('Location:../index.php');
} else {
    $id_vendedor = $_SESSION['id_vendedor'];
}

include '../includes/db.php';
// Obtém os produtos do banco de dados
$sql_produtos = "SELECT * FROM Produtos";
$result_produtos = $conn->query($sql_produtos);

// Obtém os clientes do banco de dados
$sql_clientes = "SELECT * FROM Clientes";
$result_clientes = $conn->query($sql_clientes);

// Obtém os vendedores do banco de dados
$sql_vendedores = "SELECT nome FROM Vendedores WHERE id_vendedor = $id_vendedor";
$result_vendedores = $conn->query($sql_vendedores);

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Venda</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<?php include '../includes/header.php'; ?>
<body>
   

    <?php
    if (isset($_SESSION['err'])) {
        echo '<div class="danger"><p>' . $_SESSION['err'] . '</p>  <span id="rm"></span></div>';
        unset($_SESSION['err']);
    }
    if (isset($_SESSION['id_msg'])) {
        $msgs = $_SESSION['id_msg'];
        $sql_msg = "SELECT msg, tipo FROM messages WHERE id_msg = $msgs";
        $stmt = $conn->query($sql_msg);
        $row = mysqli_fetch_assoc($stmt);
        if ($row) {
            if ($row['tipo'] == 'success') {
                echo '<div class="info"><p>' . $row['msg'] . '</p>  <span id="rm"></span></div>';
            } else {
            
            }    echo '<div class="danger"><p>' . $row['msg'] . '</p>  <span id="rm"></span></div>';
        }
        unset($_SESSION['id_msg']);
    }
    ?>
    <style>
        input {
            width: 50px;
        }

        .pr {
            display: flex;
            width: 100%;
            justify-content: space-between;
            gap: .5rem;
            border: 1px solid rgb(75, 75, 75);
            border-radius: 5px;
            box-shadow: 1px 2px 2px rgb(75, 75, 75);
            background: whitesmoke;
            width: 100%;
        }

        .product {
            width: 100%;
            justify-content: left;
            align-items: stretch;
        }
    </style>
    <section class="centro">
        <div>
            <h1>Registrar Venda</h1>
            <form action="process.php" method="post" style="width: 350px;">
                <label for="cliente">Cliente:</label>
                <select name="id_cliente" id="cliente" required>
                    <?php while ($row = $result_clientes->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id_cliente']; ?>"><?php echo $row['nome']; ?></option>
                    <?php } ?>
                </select>
                <label for="vendedor">Vendedor:</label>
                <select name="id_vendedor" id="vendedor" required >
                    <?php while ($row = $result_vendedores->fetch_assoc()) { ?>
                        <option value="<?php echo $id_vendedor; ?>"><?php echo $row['nome']; ?></option>
                    <?php } ?>
                </select>
                <h3>Produtos disponíveis</h3>
                <div class="pr" style="display: flex; flex-wrap:wrap;">
                    <?php
                    if (mysqli_num_rows($result_produtos) > 0) {
                        while ($row = $result_produtos->fetch_assoc()) { ?>
                            <div class="product">
                                <input type="checkbox" name="produtos[<?php echo $row['id_produto']; ?>]" value="<?php echo $row['id_produto']; ?>">
                                <label><?php echo $row['nome']; ?> - XOF<?php
                                                                        $id_produto = $row['id_produto'];
                                                                        $sql_preco_venda = "SELECT preco_venda FROM venda WHERE id_produto = $id_produto ";
                                                                        $result_venda = $conn->execute_query($sql_preco_venda);
                                                                        while ($result = mysqli_fetch_assoc($result_venda)) {
                                                                            echo $result['preco_venda'];
                                                                        }
                                                                        ?></label>
                                <label>Qtd <?php

                                            ?></label>
                                <input class="<?php if (intval($row['quantidade']) < 1) {
                                                    echo 'qtd';
                                                } else {
                                                    echo 'none';
                                                } ?>" style="margin:0 5px; float:right;" type="number" name="quantidades[<?php echo $row['id_produto']; ?>]" value="1" min="1" max="<?php echo $row['quantidade']; ?>">
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    let qtd = document.querySelectorAll('.qtd')
                                    qtd.forEach(el => {
                                        el.disabled = true;
                                        el.value = 0;
                                        el.style = 'background:red; color:white;'
                                        el.addEventListener('click', () => {
                                            let div = document.createElement('div')
                                            div.className = 'alert'
                                            document.querySelector('body').prepend(div)
                                            div.innerHTML = '<div class="danger"><p>Produto indisponível</p>  <span id="rm"></span></div>'
                                           setTimeout(() => {
                                            div.style.display = 'none'
                                           }, 1000);
                                        });
                                    })
                                })
                            </script>
                    <?php }
                    } else {
                        echo ' <div class="Error_info">
                            <p>Nenhum produto cadastrado!</p>
                           </div>';
                    }
                    ?>
                </div>
                <h3>Método de pagamento</h3>
                <div class="paymentmethod">
                    <div>
                        <input type="radio" id="caixa" name="paymentmethod" value="caixa" checked required>
                        <label for="caixa">Caixa</label>
                    </div>
                    <div>
                        <input type="radio" id="orm" name="paymentmethod" value="orm" required>
                        <label for="orm">Orange Money</label>
                    </div>
                    <div>
                        <input type="radio" id="mbm" name="paymentmethod" value="mbm" required>
                        <label for="mbm">Mobile Money</label>
                    </div>
                    <div>
                        <input type="radio" id="crc" name="paymentmethod" value="cc" required>
                        <label for="crc">Cartão de crédito</label>
                    </div>
                </div>
                <button type="submit">Registrar Venda</button>
            </form>
        </div>


        <div>
            <h1>Suas vendas</h1>
            <table>
                <thead>
                    <th>Produto</th>
                    <th>Quantia</th>
                    <th>Preço</th>
                </thead>
                <tbody>
                    <?php
                    // obtem os dados da tabela produto vendido
                    $sql_produto_vendido = "SELECT * FROM produto_vendido WHERE id_vendedor = $id_vendedor";
                    $res_produto_vendido = $conn->query($sql_produto_vendido);
                    $qtd = 0;
                    $tot_price = 0;

                    while ($res_vendido = mysqli_fetch_assoc($res_produto_vendido)) {
                        $id_vendido = $res_vendido['id_produto_pedido'];

                        // obtem os dados da tabela produto 
                        $sql_pr = "SELECT quantidade ,nome FROM produtos WHERE id_produto = $id_vendido";
                        $result_pr = $conn->query($sql_pr);
                        $res_pr = mysqli_fetch_assoc($result_pr);
                        if (!empty($res_pr['nome'])) {
                            # code...
                            echo '<td>' . $res_pr['nome'] . '</td>';
                        }
                        else
                        {
                            echo '<td>Sem dados</td>';
                        }
                        echo '<td>' . $res_vendido['quantidade'] . '</td>';
                        echo '<td>' . $res_vendido['preco_vendido'] . '</td>';

                        $qtd +=  intval($res_vendido['quantidade']);
                        $tot_price +=  intval($res_vendido['preco_vendido']) * intval($res_vendido['quantidade']);
                        echo '<tr></tr>';
                    }

                    ?>

                </tbody>
            </table>
            <div>
                <p>Foram vendidos <?php echo $qtd; ?> produtos, custando ao total <?php echo $tot_price; ?>XOF </p>
            </div>
        </div>
    </section>

    <script>
        setTimeout(() => {
            let inf = document.getElementById('rm').parentElement.remove();
        }, 2000);
    </script>
    <script src="../js/script.js"></script>
</body>

</html>