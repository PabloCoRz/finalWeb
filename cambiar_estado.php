
<?php
include_once 'funciones/DB.php'; // Incluir getDB()
require 'ordenes.php'; // Incluir la clase Orden y las funciones para cargarlas de la db


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];

    cambiarEstado($order_id);

    header('Location: dashboard.php?mensaje=exito');
    exit();
}

function cambiarEstado($order_id) {
    $conn = getDB();
    $sql = "UPDATE ticket SET estado = 'completado' WHERE ticket_id = :order_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $stmt->execute();
    $conn = null;
}
?>