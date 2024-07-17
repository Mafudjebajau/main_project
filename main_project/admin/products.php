<?php
session_start();

include_once('../includes/db.php');
include_once("adminincludes/header.php");

if (isset($_GET['content_pesquisar'])) {
    $content = $_GET['content_pesquisar'];
    $sql_fornecedores = "SELECT id_fornecedor, nome FROM fornecedores WHERE id_fornecedor LIKE '%$content%' OR nome  LIKE '%$content%'";
    $sql_categorias = "SELECT id_categoria, nome FROM categorias WHERE id_categoria LIKE '%$content%' OR nome LIKE '%$content%'";
} else {
    $sql_fornecedores = "SELECT id_fornecedor, nome FROM fornecedores";
    // da tabela categoria
    $sql_categorias = "SELECT id_categoria, nome FROM categorias";
}
$stmt_categorias = $conn->query($sql_categorias);
$stmt_fornecedores = $conn->query($sql_fornecedores);

?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Gerencia de produtos</title>
</head>

<body>
    <?php
    if (isset($_SESSION['id_msg'])) {
        $msgs = $_SESSION['id_msg'];
        $sql_msg = "SELECT msg, tipo FROM messages WHERE id_msg = $msgs";
        $stmt = $conn->query($sql_msg);
        $row = mysqli_fetch_assoc($stmt);
        if ($row) {
            if ($row['tipo'] == 'success') {
                echo '<div class="info"><p>' . $row['msg'] . '</p>  <span id="rm"></span></div>';
            } else {
                echo '<div class="danger"><p>' . $row['msg'] . '</p>  <span id="rm"></span></div>';
            }
        }
        unset($_SESSION['id_msg']);
    }

    ?>
    <section class="centro">
        <div>
            <h1 id="a-center">Adicionar Produtos</h1>
            <form action="process_produtos.php" method="post">

                <label for="fornecedor">Fornecedor</label>
                <select name="fornecedor" id="fornecedor">
                    <?php while ($row = $stmt_fornecedores->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id_fornecedor']; ?>"><?php echo $row['nome']; ?></option>
                    <?php } ?>
                </select>
                <label for="categoria">Categorias</label>
                <select name="categoria" id="categoria">
                    <?php while ($row = $stmt_categorias->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id_categoria']; ?>"><?php echo $row['nome']; ?></option>
                    <?php } ?>
                </select>
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" maxlength="50" required>

                <label for="descricao">Descrição:</label>
                <input type="text" id="descricao" name="descricao" maxlength="50" required>

                <label for="price">Preço compra:</label>
                <input type="number" id="price" name="price" maxlength="10" required>

                <label for="preco">Preço venda:</label>
                <input type="number" id="preco" name="sell_price" maxlength="10" required>

                <label for="quantidade">Quantidade:</label>
                <input type="number" id="quantidade" name="quantidade" required>

                <button type="submit">Adicionar Produto</button>
            </form>
        </div>
        <div class="table-div">
            <form action="" method="get" class="form-pesquisar">
                <input type="search" placeholder="Pesquisar" class="input-pesquisar" name="content_pesquisar">
                <button type="submit" name="pesquisar" class="btn-pesquisar">Pesquisar</button>
            </form>
            <h2>Lista de Produtos</h2>
            <table>
                <thead>
                    <th>ID</th>
                    <th>Nome produto</th>
                    <th>Descrição</th>
                    <th>Preço Compra</th>
                    <th>Preço Venda</th>
                    <th>Quantidade</th>
                    <th>Opções</th>
                </thead>
                <tbody>
                    <?php
                    if (!empty($_SESSION['data_login']) && !empty($_SESSION['hora_login'])) {
                        $conn->begin_transaction();
                        #this
                        if (isset($_GET['content_pesquisar'])) {
                            $content = $_GET['content_pesquisar'];
                            $sql = "SELECT id_produto, nome, descricao, quantidade FROM produtos WHERE id_produto LIKE '%$content%' OR nome LIKE '%$content%' OR quantidade LIKE '%$content%'";
                        } else {
                            $sql = "SELECT id_produto, nome, descricao, quantidade FROM produtos";
                        }

                        $stmt_products = $conn->execute_query($sql);
                        while ($res = mysqli_fetch_assoc($stmt_products)) {
                            echo '<td>' . $res['id_produto'] . '</td>';
                            echo '<td>' . $res['nome'] . '</td>';
                            echo '<td id="desc">' . $res['descricao'] . '</td>';
                            $id_produto = $res['id_produto'];
                            $sql_preco_compra = "SELECT preco_compra FROM compra WHERE id_produto = $id_produto ";
                            $result_compra = $conn->execute_query($sql_preco_compra);
                            while ($result = mysqli_fetch_assoc($result_compra)) {
                                echo '<td>' . $result['preco_compra'] . '</td>';
                            }
                            $sql_preco_venda = "SELECT preco_venda FROM venda WHERE id_produto = $id_produto ";
                            $result_venda = $conn->execute_query($sql_preco_venda);
                            while ($resultado = mysqli_fetch_assoc($result_venda)) {
                                echo '<td>' . $resultado['preco_venda'] . '</td>';
                            }

                            if ($res['quantidade'] > 5) {
                                echo '<td>' . $res['quantidade'] . '</td>';
                            } else {
                                echo "<td class='red text-white'>" . $res['quantidade'] . '</td>';
                            }
                    ?>
                            <td> <a class="btn green" id="edit" onclick="editar(<?php echo $res['id_produto']  ?>)">Edit</a> <a id="delete" class="btn red" onclick="deletar(<?php echo $res['id_produto'] ?>)">Del</a></td>
                        <?php echo '<tr>';
                        } ?>
                    <?php  } else {
                        echo "Não existem dados!";
                        header('Location:login.php');
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
    <script>
        function editar(x) {
            location.href = "edit_products.php?id=" + x;
        }

        function deletar(x) {
            let confirmation = confirm('Tens certeza?');
            if (confirmation == true) {
                location.href = "delete_something.php?L=DP&id=" + x;
            } else {
                location.href = "products.php";
            }
        }
        setTimeout(() => {
            let inf = document.getElementById('rm').parentElement.remove();
        }, 2000);
    </script>
</body>

</html>