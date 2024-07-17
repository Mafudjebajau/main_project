<?php
session_start();

if (!empty($_SESSION['data_login']) && !empty($_SESSION['hora_login'])) {
    include_once("adminincludes/header.php");

    $data_login =  $_SESSION['data_login'];

    $hora_login = $_SESSION['hora_login'];

    //   echo("Último login às ".$hora_login.", do dia ".$data_login);
} else {
    header('Location:login.php');
}

include '../includes/db.php';

// Obtém os categorias do banco de dados
$sql = "SELECT * FROM categorias";
$result = $conn->query($sql);

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
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Categorias</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <?php include_once("adminincludes/header.php"); ?>
    <section class="centro">
        <div>
            <h1 class="a-center">Gerenciar Categorias</h1>
            <form action="process_Categorias.php" method="post">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" maxlength="50" required>

                <label for="descricao">Descrição:</label>
                <input type="text" id="descricao" name="descricao" maxlength="50" required>

                <button type="submit">Adicionar Categoria</button>
            </form>
        </div>
        <div style="overflow-y: scroll; height:500px; padding-right:1rem">
            <h2>Lista de Categorias</h2>
            <table>
                <thead>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <td><?php echo $row['id_categoria']; ?></td>
                        <td><?php echo $row['nome']; ?></td>
                        <td><?php echo $row['descricao']; ?></td>
                        <tr></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
    <?php include '../includes/footer.php';

    ?>
</body>
<script>
    function editar(x) {
        location.href = "edit_products.php?id=" + x;
    }
    function deletar(x) {
        let confirmation = confirm('Tens certeza?');
        if (confirmation == true) {
            location.href = "delete_products.php?id=" + x;
        } else {
            location.href = "fornecedores.php";
        }
    }
    setTimeout(() => {
        let inf = document.getElementById('rm').parentElement.remove();
    }, 2000);
</script>

</html>