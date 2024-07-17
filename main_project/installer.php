<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coletar dados do formulário
    $servername = $_POST['servername'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $dbname = $_POST['dbname'];

    // Caminho para o arquivo SQL
    $sqlFile = 'database.sql';

    // Conectar ao banco de dados
    $conn = new mysqli($servername, $username, $password);

    // Verificar conexão
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Criar o banco de dados
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    if ($conn->query($sql) === TRUE) {
        echo "Banco de dados criado com sucesso.<br>";
    } else {
        echo "Erro ao criar o banco de dados: " . $conn->error . "<br>";
    }

    // Selecionar o banco de dados
    $conn->select_db($dbname);

    // Ler o arquivo SQL
    $sql = file_get_contents($sqlFile);
    if ($sql === FALSE) {
        die("Erro ao ler o arquivo SQL.<br>");
    }

    // Executar as multiplas consultas do arquivo SQL
    if ($conn->multi_query($sql)) {
        do {
            // Processar múltiplos resultados
            if ($result = $conn->store_result()) {
                $result->free();
            }
        } while ($conn->more_results() && $conn->next_result());
        echo "Arquivo SQL importado com sucesso.<br>";
    } else {
        echo "Erro ao importar o arquivo SQL: " . $conn->error . "<br>";
    }


    $conn->close();

    // Criar o arquivo de configuração
    $configContent = "<?php\n";
    $configContent .= "\$servername = '$servername';\n";
    $configContent .= "\$username = '$username';\n";
    $configContent .= "\$password = '$password';\n";
    $configContent .= "\$dbname = '$dbname';\n";
    $configContent .= "\$conn = new mysqli('$servername', '$username', '$password', '$dbname');\n";

    if(file_exists("includes/db.php"))
    {
        echo "Arquivo db.php já existe!";
    }
    else 
    {
     file_put_contents('includes/db.php', $configContent);
     echo "Arquivo de configuração criado com sucesso.<br>";
    }
    header("Location:index.php");
} else {
  
?>
<link rel="stylesheet" href="css/styles.css">
    <section class="centro">
        <div>
            <h1 class="text-dodgerblue" style="font-size:2rem;">Pré-configurações <br>do sistema</h1>
            <form method="post" action="">
                <label for="servername">Servidor:</label>
                <input type="text" id="servername" name="servername" required placeholder="Nome do servidor">
                <label for="username">Usuário:</label>
                <input type="text" id="username" name="username" required placeholder="Nome do usuário">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" placeholder="Password" >
                <label for="dbname">Nome do Banco de Dados:</label>
                <input type="text" id="dbname" name="dbname" required placeholder="database name">
                <button type="submit">Instalar</button>
            </form>
        </div>
    </section>
<?php
}
?>