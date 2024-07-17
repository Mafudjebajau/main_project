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

?>
<?php
include '../includes/db.php';

// Obtém os Fornecedores do banco de dados
$sql = "SELECT * FROM fornecedores";
$result = $conn->query($sql);
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
    <script>
        setTimeout(() => {
            let inf = document.getElementById('rm').parentElement.remove();
        }, 2000);
    </script>
    <section class="centro">
        <div>
            <h1 class="a-center">Adicionar Fornecedor</h1>
            <form action="process_fornecedores.php" method="post">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone">

                <label for="endereco">Endereço:</label>
                <input type="text" id="endereco" name="endereco">

                <button type="submit">Adicionar Fornecedor</button>
            </form>
        </div>
        <div>

            

            <h2>Lista de Fornecedores</h2>
            <table>
                <thead>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Endereço</th>
                    <th>Opções</th>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <td><?php echo $row['id_fornecedor']; ?></td>
                        <td><?php echo $row['nome']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['telefone']; ?></td>
                        <td><?php echo $row['endereco']; ?></td>
                        <td> <a class="btn green" id="edit" onclick="editar(<?php echo $row['id_fornecedor']  ?>)">Editar</a> <a id="delete" class="btn red" onclick="deletar(<?php echo $row['id_fornecedor']  ?>)">Deletar</a></td>
                        <tr></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- href="editar_fornecedor.php?n=" -->
    </section>
    <script>
        function editar(x) {
            location.href = "edit_fornecedor.php?id=" + x;
        }

        function deletar(x) {
            let confirmation = confirm('Tens certeza?');
            if (confirmation == true) {
                location.href = "delete_something.php?L=DF&id=" + x;
            } else {
                location.href = "fornecedores.php";
            }

        }
    </script>
</body>

</html>