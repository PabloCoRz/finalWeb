<?php
include_once 'funciones/DB.php'; // Incluir getDB()

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];

    $conn = getDB();
    $sql = "INSERT INTO cliente (nombre, telefono) VALUES (:nombre, :telefono)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Cliente insertado con éxito']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al insertar cliente']);
    }
    $conn = null;
    exit();
}
?>