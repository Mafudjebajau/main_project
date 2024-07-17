<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Vendas</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<header>
    <nav>
        <div id="logo">
            <h1>Sistema de Vendas</h1>
        </div>
        <ul style="display:flex;align-items:stretch;">
            <li><a href="/main_project/admin/dashboard.php">Administrar</a></li>
            <li><a href="help/help.html">Ajuda</a></li>
        </ul>
    </nav>
</header>
<?php
include 'includes/msg.php';
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

<body style="display: flex; flex-direction:column; justify-content:center; width:100vw;">

    <section style="display: flex; flex-direction:column; justify-content:center; align-items:center; width:100%; gap:1rem;">
        <h1 class="a-center" style="font-size: 2rem;">Seja bem-vindo ao 49Legacy Sells Sistem <br> <strong class="text-dodgerblue">#49LSS</strong></h1>

        <form action="process_login_vendedor.php" method="post">
            <label for="nome">Usuário</label>
            <input type="text" placeholder="Nome do usuário" name="nome" required autofocus>
            <label for="senha">Password</label>
            <input type="password" name="senha" placeholder="Seu password" required>
            <button type="submit" name="logarvendedor">Entrar</button>
        </form>
    </section>

    <?php include 'includes/footer.php'; ?>
    <script src="js/msg.js"></script>
    <script>
        let helper = document.getElementById("helper");

    </script>

</body>

</html>