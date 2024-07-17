<header>

    <nav>
        <div id="logo">
            <h1 class="text-dodgerblue">Sistema de Vendas</h1>
        </div>
        <ul>

            <li><a href="logout.php">Página Inicial</a></li>
            <li><a id="<?php
                        if ($_SERVER['REQUEST_URI'] == "/main_project/admin/dashboard.php") {
                            echo 'di';
                        }
                        ?>" href="dashboard.php">Dashboard</a></li>
            <li><a id="<?php
                        if ($_SERVER['REQUEST_URI'] == "/main_project/admin/categorias.php") {
                            echo 'di';
                        }
                        ?>" href="categorias.php">Categorias</a></li>
            <li><a id="<?php
                        if ($_SERVER['REQUEST_URI'] == "/main_project/admin/fornecedores.php") {
                            echo 'di';
                        }
                        ?>" href="fornecedores.php">Fornecedores</a></li>
            <li><a id="<?php
                        if ($_SERVER['REQUEST_URI'] == "/main_project/admin/products.php") {
                            echo 'di';
                        }
                        ?>" href="products.php">Produtos</a></li>
            <li><a id="<?php
                        if ($_SERVER['REQUEST_URI'] == "/main_project/admin/finance.php") {
                            echo 'di';
                        }
                        ?>" href="finance.php">Finanças</a></li>
            <li><a id="<?php
                        if ($_SERVER['REQUEST_URI'] == "/main_project/admin/Vendedores.php") {
                            echo 'di';
                        }
                        ?>" href="Vendedores.php">Vendedores</a></li>
            <li><a id="<?php
                        if ($_SERVER['REQUEST_URI'] == "/main_project/admin/messages.php") {
                            echo 'di';
                        }
                        ?>" href="messages.php">Mensagens</a></li>
        </ul>
    </nav>
</header>