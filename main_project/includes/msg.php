<?php
session_start();
include 'db.php';
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
