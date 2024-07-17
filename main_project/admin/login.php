<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Admin login</title>

</head>
<body>
    <section class="centro">
        <div>
            <h1 class="text-dodgerblue">Login</h1>
            <form action="loginprocess.php" method="post">
                <label for="nome">Usuário</label>
                <input type="text" name="nome" id="nome" placeholder="Nome do usuário" required>
                <label for="pass">Senha</label>
                <input type="password" name="senha" id="pass" placeholder="Palavra passe" required>
                <button type="submit" name="submit">Logar</button>
            </form>
        </div>
    </section>
</body>
</html>