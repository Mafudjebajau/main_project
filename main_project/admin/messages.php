<?php
session_start();

if (!empty($_SESSION['data_login']) && !empty($_SESSION['hora_login'])) {
    include '../includes/db.php';
    include_once("adminincludes/header.php");

    $sql_msg_e = "SELECT msg, data_msg FROM messages WHERE tipo = 'erro'";
    $stmt_e = $conn->query($sql_msg_e);

    $sql_msg_s = "SELECT msg, data_msg FROM messages WHERE tipo = 'success'";
    $stmt_s = $conn->query($sql_msg_s);
} else {
    header('Location:login.php');
}

?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Mensagens</title>
</head>

<body>
    <section class="centro">

        <div style="overflow-y: scroll; height:500px">
            <table >
                <thead>
                    <th id="success">Mensagens</th>
                    <th>Data</th>
                </thead>
                <tbody>
                    <?php
                    while ($row_s = $stmt_s->fetch_assoc()) {
                        echo "<td>" . $row_s['msg'] ." </td>";
                        echo "<td>".$row_s['data_msg']." </td>";
                        echo '<tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div style="overflow-y: scroll; height:500px;">
            <table>
                <thead>
                    <th id="error">Mensagens</th>
                    <th>Data</th>
                </thead>
                <tbody>
                    <?php
                    while ($row_e = $stmt_e->fetch_assoc()) {
                        echo "<td>" . $row_e['msg'] . "</td>";
                        echo "<td>".$row_e['data_msg']." </td>";
                        echo '<tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>


    </section>
</body>

</html>