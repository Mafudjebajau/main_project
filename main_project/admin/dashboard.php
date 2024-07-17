<!DOCTYPE html>
<html lang="pt-br" >

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../icons/cdn_font_awesome.miny.css">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Admin Dashboard</title>
</head>

<header>
    <nav>
        <div id="logo">
            <h1 class="text-dodgerblue"><i class="fas fa-chart-line"></i> Sistema de Vendas</h1>
        </div>
        <div>
            <?php
            session_start();
            include_once('../includes/db.php');
            if (!empty($_SESSION['data_login']) && !empty($_SESSION['hora_login'])) {
                $data_login =  $_SESSION['data_login'];
                $hora_login = $_SESSION['hora_login'];
                echo ("<p id='login_hour'>Último login foi às " . $hora_login . ", do dia " . $data_login . "</p>");
            } else {
                header('Location:login.php');
            }
            ?>
        </div>
    </nav>
</header>

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

    $sql_category = "SELECT id_categoria FROM categorias";
    $stmt_category = $conn->query($sql_category);
    $rows_c = $stmt_category->num_rows;

    $sql_fornecedor = "SELECT id_fornecedor FROM fornecedores";
    $stmt_fornecedor = $conn->query($sql_fornecedor);
    $rows_f = $stmt_fornecedor->num_rows;

    $sql_products = "SELECT quantidade FROM produtos";
    $stmt_products = $conn->query($sql_products);
    $total_quantidade = 0;
    while ($res_pr = mysqli_fetch_assoc($stmt_products)) {
        $total_quantidade += intval($res_pr['quantidade']);
    }

    $sql_vendors = "SELECT id_vendedor FROM vendedores";
    $stmt_vendors = $conn->query($sql_vendors);
    $rows_v = $stmt_vendors->num_rows;

    $sql_msg = "SELECT id_msg FROM messages";
    $stmt_msg = $conn->query($sql_msg);
    $rows_m = $stmt_msg->num_rows;

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
// 133
    $sql_venda = "SELECT * FROM `produto_vendido`";
    $stmt_venda = $conn->query($sql_venda);
    $total_venda = 0;
    $quantidade_venda = 0;
    $total_preco_venda = 0;
    while($stmt_res_venda = mysqli_fetch_assoc($stmt_venda)) {
        $price = intval($stmt_res_venda['preco_vendido']);
        $qtd = intval($stmt_res_venda['quantidade']);
        $total_preco_venda += $price * $qtd;
        $quantidade_venda += intval($stmt_res_venda['quantidade']);
    }
    $rows_vp = $stmt_venda->num_rows;

    $saldo = $total_preco_venda - $total_preco_compra;
    $vp = intval($rows_vp);
    $qcp = intval($quantidade_compra);
  if(!empty($quantidade_venda) && !empty($qcp))
    {
        $porcentagem = intval(( $quantidade_venda*100)/$qcp).'%';
    }
    else 
    {
        $porcentagem = "0";
    }
    ?>
<style>

.inside 
{
    width: <?php if($porcentagem)
    {echo $porcentagem;}
    else{echo "0%";}
    ?>;
    height: 10px;
    /* background-color: rgb(246, 246, 247); */
    background-color: rgb(8, 97, 121);
    background-color: black;
    border-radius: 15px;
}
.outside 
{
    display: flex;
    justify-content: start;
    align-items: center;
    border-radius: 5px;
    width: 60px;
    height: 5px;
    /* background-color: rgb(13, 13, 13); */
    background-color: white;
    overflow: hidden;
    border: 2px solid black;
}
.gr-area 
{
    display: flex;
}
.center 
{
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    transform: translateY(50px);
}
.center span 
{
    transform: translateY(-5px);
}
#percentagem 
{
    transform: translateY(-25px);
    margin-left: .5rem;
    font-size: 2rem;
}
    </style>
  <section class="main">
    <div id="category"><i class="fas fa-list"></i> Categorias <span><?php echo $rows_c; ?></span></div>
    <div id="fornece"><i class="fas fa-truck"></i> Fornecedores <span><?php echo $rows_f; ?></span></div>
    <div id="products"><i class="fas fa-box"></i> Produtos <span><?php echo $total_quantidade; ?></span></div>
    <div id="finance"><i class="fas fa-dollar-sign"></i> Finanças <span class="<?php if ($saldo < 0) {
                                                echo 'text-red';
                                            } else {echo 'text-green';} ?>"><?php echo $saldo; ?></span></div>
    <div id="vendors"><i class="fas fa-users"></i> Vendedores <span><?php echo $rows_v; ?></span></div>
    <div id="messages"><i class="fas fa-envelope"></i> Mensagens <span><?php echo $rows_m; ?></span></div>

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
        <p>
        <section class="center">
            <div class="gr-area">
            <div class="outside">
                <div class="inside"></div>
            </div>
            <span class="text-dodgerblue"><?php echo $porcentagem; ?></span>
        </div>
        </section>
        </p>
       
    </div>
    <div id="btn-logout-div">
        <button onclick="confirm_out()" id="logout"><i class="fas fa-power-off"></i></button>
    </div>
</section>

    <script src="../js/msg.js"></script>
    <script>
        let divs = document.querySelectorAll('div')
        divs.forEach(div => {
            div.addEventListener('click', () => {
                if (div.id == "category") {
                    location.href = "categorias.php"
                }
                if (div.id == "fornece") {
                    location.href = "fornecedores.php"
                }
                if (div.id == "finance") {
                    location.href = "finance.php"
                }
                if (div.id == "products") {
                    location.href = "products.php"
                }
                if (div.id == "vendors") {
                    location.href = "vendedores.php"
                }
                if (div.id == "messages") {
                    location.href = "messages.php"
                }
            })
        });

        function confirm_out() {
            let confirmation = confirm("Realmente queres sair?");
            if (confirmation == true) {
                location.href = 'logout.php'
            } else {
                location.href = 'dashboard.php'
            }
        }
    </script>
</body>

</html>
