<?php
session_start();

include_once('../includes/db.php');
include_once("adminincludes/header.php");
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Gerencia de vendedores</title>
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
    <section class="centro" style="justify-content: space-around;">

        <div>
            <h1>Gerenciar vendedores</h1>
            <form action="process_vendedores.php" method="post">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" maxlength="50" required>

                <label for="email">Email:</label>
                <input type="text" id="email" name="email" maxlength="50" required>
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" maxlength="15" required>
                <label for="salario">Salario:</label>
                <input type="text" id="salario" name="salario" required>
                <label for="usuario">Usuário:</label>
                <input type="text" id="usuario" name="usuario" required>
                <label for="senha">Senha:</label>
                <input type="text" id="senha" name="senha" required>

                <button type="submit">Adicionar vendedor</button>
            </form>
        </div>
        <div class="table-div">
            <form action="" method="get" class="form-pesquisar">
                <input type="search" placeholder="Pesquisar" class="input-pesquisar" name="content_pesquisar">
                <button type="submit" name="pesquisar" class="btn-pesquisar">Pesquisar</button>
            </form>
            <h2>Lista de vendedores</h2>
            <table>
                <thead>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Salario</th>
                    <th>Funções</th>
                </thead>
                <tbody>
                    <?php
                    if (!empty($_SESSION['data_login']) && !empty($_SESSION['hora_login'])) {
                        $conn->begin_transaction();
                        if (!empty($_GET['content_pesquisar'])) {
                            $content = $_GET['content_pesquisar'];
                            $sql = "SELECT id_vendedor, nome, email, telefone, salario FROM vendedores WHERE id_vendedor LIKE '%$content%' OR nome LIKE '%$content%' OR email LIKE '%$content%' OR telefone LIKE '%$content%' OR salario LIKE '%$content%' ";
                            unset($_GET['content_pesquisar']);
                        } else {
                            $sql = "SELECT id_vendedor, nome, email, telefone, salario FROM vendedores";
                        }
                        $stmt_products = $conn->execute_query($sql);
                        if (mysqli_num_rows($stmt_products) > 0) {
                            while ($res = mysqli_fetch_assoc($stmt_products)) {
                                echo '<td>' . $res['id_vendedor'] . '</td>';
                                echo '<td>' . $res['nome'] . '</td>';
                                echo '<td>' . $res['email'] . '</td>';
                                echo '<td>' . $res['telefone'] . '</td>';
                                echo '<td>' . $res['salario'] . '</td>';
                    ?>
                                <td> <a class="btn green" id="edit" onclick="editar(<?php echo $res['id_vendedor']  ?>)">Edit</a> <a id="delete" class="btn red" onclick="deletar(<?php echo $res['id_vendedor']; ?>)">Del</a></td>
                                <tr>
                        <?php     }
                        } else {
                            echo '<td>Sem dados!</td>';
                        }
                    } else {
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
            location.href = "edit_vendedor.php?&id=" + x;
        }

        function deletar(x) {
            let confirmation = confirm('Tens certeza?');
            if (confirmation == true) {
                location.href = "delete_something.php?L=DV&id=" + x;
            } else {
                location.href = "vendedores.php";
            }
        }
        setTimeout(() => {
            let inf = document.getElementById('rm').parentElement.remove();
        }, 2000);
    </script>
</body>

</html>