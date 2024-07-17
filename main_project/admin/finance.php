<?php
session_start();
include_once('../includes/db.php');
include_once("adminincludes/header.php");

include_once('../includes/db.php');
if (empty($_SESSION['data_login']) && empty($_SESSION['hora_login'])) {

    header('Location:login.php');
}
if (isset($_POST['confirmar_gasto']) && !empty($_POST['renda']) && !empty($_POST['energy']) && !empty($_POST['salario'])  && !empty($_POST['impostos'])) {
    $renda = $_POST['renda'];
    $energia = $_POST['energy'];
    $salarios = $_POST['salario'];
    $impostos = $_POST['impostos'];

    $sql_insert = "INSERT INTO despesas (renda, energia, salarios, impostos) VALUES (?,?,?,?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param('ssss', $renda, $energia, $salarios, $impostos);
    $stmt_insert->execute();
    if ($conn->affected_rows > 0) {
        $msg = "despesa adicionado com sucesso!";
        $tipo = "success";
        $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
        $stmt_msg = $conn->query($sql_msg);
        $id_msg = $conn->insert_id;
        $_SESSION['id_msg'] = $id_msg;
        header('Location:finance.php');
    } else {
        $msg = "Erro ao adicionar despesa!";
        $tipo = "error";
        $sql_msg = "INSERT INTO messages (msg, tipo) VALUES ('$msg','$tipo')";
        $stmt_msg = $conn->query($sql_msg);
        $id_msg = $conn->insert_id;
        $_SESSION['id_msg'] = $id_msg;
        header('Location:finance.php');
    }
}
// seleciona tudo na tabela produto_vendido e so utiliza os valores: preco_vendido e quantidade
$sql_venda = "SELECT * FROM `produto_vendido`";
$stmt_venda = $conn->query($sql_venda);
$total_venda = 0;
$quantidade_venda = 0;
$total_preco_venda = 0;
while ($stmt_res_venda = mysqli_fetch_assoc($stmt_venda)) {
    $price = intval($stmt_res_venda['preco_vendido']);
    $qtd = intval($stmt_res_venda['quantidade']);
    $total_preco_venda += $price * $qtd;
    $quantidade_venda += intval($stmt_res_venda['quantidade']);
}
$rows_vp = $stmt_venda->num_rows;

// seleciona os valores preco_compra e quantidade na tabela compra
$sql_compra = "SELECT preco_compra ,quantidade FROM compra";
$stmt_compra = $conn->query($sql_compra);
$total_compra = 0;
$quantidade_compra = 0;
$total_preco_compra = 0;
while ($stmt_res = mysqli_fetch_assoc($stmt_compra)) {
    $price = intval($stmt_res['preco_compra']);
    $total_compra += $price;
    $total_preco_compra += $price * intval($stmt_res['quantidade']);
    $quantidade_compra += intval($stmt_res['quantidade']);
}
$rows_cp = $stmt_compra->num_rows;

$saldo = $total_preco_venda - $total_preco_compra;
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <!-- <link rel="stylesheet" href="css/styles.css"> -->
    <title>Finanças</title>
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
            <h2>Adicionar despesas</h2>
            <form action="finance.php" method="post">
                <label for="renda">Renda</label>
                <input type="number" id="renda" step="25" name="renda" required autofocus min="25">
                <label for="energy">Energia</label>
                <input type="number" id="energy" step="25" name="energy" required min="25">
                <label for="salarios">Salarios</label>
                <input type="number" id="salario" step="25" name="salario" step="25" required min="25">
                <label for="impostos">Impostos</label>
                <input type="number" id="impostos" name="impostos">
                <button type="submit" name="confirmar_gasto">Confirmar</button>
            </form>
        </div>
        <div class="main">
        <div id="finance"><i class="fas fa-dollar-sign"></i> Finanças <span class="<?php if ($saldo < 0) {
                                                                                        echo 'text-red';
                                                                                    } else {
                                                                                        echo 'text-green';
                                                                                    } ?>"><?php echo $saldo; ?> </span></div>
            <div id="compras"><i class="fas fa-shopping-cart"></i> Compras
                <p>Cash
                    <span class="text-dodgerblue"><?php echo ($total_preco_compra); ?></span>
                </p>
                <p>Quantidade
                    <span class="text-dodgerblue"><?php echo $quantidade_compra; ?></span>
                </p>
            </div>
            <div id="vendas"><i class="fas fa-chart-line"></i> Vendas
                <p>Cash
                    <span class="text-dodgerblue"><?php echo $total_preco_venda; ?></span>
                </p>
                <p>Quantidade
                    <span class="text-dodgerblue"><?php echo $rows_vp; ?></span>
                </p>
            </div>
        </div>
        <div style="margin-right:2rem;">
            <h2>Lista de despesas</h2>
            <table>
                <thead>
                    <th>Renda</th>
                    <th>Energia</th>
                    <th>Salarios</th>
                    <th>Impostos</th>
                    <th>Data</th>
                </thead>
                <tbody>
                    <?php $sql_select = "SELECT * FROM despesas";
                    $stmt_select = $conn->query($sql_select);
                    $renda = 0;
                    $salary = 0;
                    $energy = 0;
                    $imps = 0;
                    $soma = 0;
                    while ($res_select = mysqli_fetch_assoc($stmt_select)) { ?>
                        <td> <?php echo $res_select['renda']; ?></td>
                        <td> <?php echo $res_select['energia']; ?></td>
                        <td> <?php echo $res_select['salarios']; ?></td>
                        <td> <?php echo $res_select['impostos']; ?></td>
                        <td> <?php echo $res_select['data_despesa']; ?></td>
                        <?php 
                            $renda += intval($res_select['renda']);
                            $energy += intval($res_select['energia']);
                            $salary += intval($res_select['salarios']);
                            $imps += intval($res_select['impostos']);
                            $soma =  $renda + $energy + $salary + $imps; ?>
                        <tr></tr>
                        <?php } ?>
                    </tbody>
                </table>
                <h1 class="text-dodgerblue">Total</h1>
                <?php echo '<h1 style="text-align:center;background:black;color:white;border-radius:10px; padding:1rem;">.............'.$soma.'............</h1>';?>
        </div>

    </section>
     <div style="text-align:center; margin-top:0; background: black; width: 100%;display:flex;justify-content:center;align-items:center;flex-direction:column; ">
        <h1 class="text-dodgerblue">Saldo atual</h1>
         <h1 class="<?php if(($saldo* -1+$soma)*(-1) < 0 ){echo 'text-red';}else{echo 'text-green';}?> ">.............<?php echo($saldo* -1+$soma)*(-1);?>............</h1>
     </div>
    <script src="../js/msg.js"></script>
</body>

</html>