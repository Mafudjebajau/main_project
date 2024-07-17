<?php
include '../includes/db.php';

    // Obtém os clientes do banco de dados
    $sql = "SELECT * FROM Clientes";
    $result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Clientes</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<?php include '../includes/header.php'; ?>

<body>
    <section style="display: flex; flex-direction:row; justify-content:space-around; align-items:stretch;">
        <div style="display: flex; flex-direction:column;">

            <h1>Gerenciar Clientes</h1>
            <form action="process.php" method="post">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone">

                <label for="endereco">Endereço:</label>
                <input type="text" id="endereco" name="endereco">

                <button type="submit">Adicionar Cliente</button>
            </form>
        </div>
        <div style="display: flex; flex-direction:column;">
            <h2>Lista de Clientes</h2>
            <table>
                <thead>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Endereço</th>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <td><?php echo $row['id_cliente']; ?></td>
                        <td><?php echo $row['nome']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['telefone']; ?></td>
                        <td><?php echo $row['endereco']; ?></td>
                        <tr>
                        <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
    <?php include '../includes/footer.php'; ?>
</body>

</html>