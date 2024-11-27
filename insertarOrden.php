<?php
include_once 'funciones/DB.php'; // Incluir getDB()
require 'ordenes.php'; // Incluir la clase Orden y las funciones para cargarlas de la db

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente_id = $_POST['cliente_id'];
    $anticipo = $_POST['anticipo'];
    $fecha_entrega = $_POST['fecha_entrega'];
    $articulos = [];
    $total_precio = 0;
    // Procesar los artículos
    foreach ($_POST['servicio_id'] as $index => $servicio_id) {
        $articulo = [
            'servicio_id' => $servicio_id,
            'articulo' => $_POST['articulo'][$index],
            'imagen' => [
                'name' => $_FILES['imagen']['name'][$index],
                'type' => $_FILES['imagen']['type'][$index],
                'tmp_name' => $_FILES['imagen']['tmp_name'][$index],
                'error' => $_FILES['imagen']['error'][$index],
                'size' => $_FILES['imagen']['size'][$index]
            ],
            'comentario' => $_POST['comentario'][$index]
        ];
        $articulos[] = $articulo;

        $conn = getDB();
        $sql = "SELECT precio FROM servicio WHERE servicio_id = :servicio_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':servicio_id', $servicio_id, PDO::PARAM_INT);
        $stmt->execute();
        $servicio = $stmt->fetch(PDO::FETCH_ASSOC);
        $conn = null;

        if ($servicio) {
            $total_precio += $servicio['precio'];
        }
    }
    $total_precio -= $anticipo;
    // Llamar a la función insertarOrden
    insertarOrden($cliente_id, $total_precio, $anticipo, $fecha_entrega, $articulos);

    // Redirigir a una página de éxito o mostrar un mensaje
    header('Location: NuevaOrden.php?mensaje=exito');
    exit();
}
function insertarOrden($cliente_id, $precio, $anticipo, $fecha_entrega, $articulos) {
    
    $conn = getDB();
    $sql = "INSERT INTO ticket (cliente_id, precio_total, anticipo, fecha_entrega, fecha_compra) VALUES (:cliente_id, :precio, :anticipo, :fecha_entrega, CURDATE())";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
    $stmt->bindParam(':precio', $precio, PDO::PARAM_INT);
    $stmt->bindParam(':anticipo', $anticipo, PDO::PARAM_INT);
    $stmt->bindParam(':fecha_entrega', $fecha_entrega, PDO::PARAM_STR);
    $stmt->execute();
    $ultimo_id = $conn->lastInsertId();
    foreach ($articulos as $articulo) {
        $imagen = $articulo['imagen'];
        $ruta_destino = '';

        if ($imagen['error'] === UPLOAD_ERR_OK) {
            // Definir la ruta de destino para la imagen
            $ruta_destino = 'Imagenes/Ticket' . basename($imagen['name']);

            // Mover la imagen subida a la ruta de destino
            if (!move_uploaded_file($imagen['tmp_name'], $ruta_destino)) {
                $ruta_destino = ''; // Si hay un error al mover la imagen, dejar la ruta vacía
            }
        }

        $sql = "INSERT INTO servicio_ticket (ticket_id, servicio_id, articulo, imagen, comentario) VALUES (:ticket_id, :servicio_id, :articulo, :imagen, :comentario)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':ticket_id', $ultimo_id, PDO::PARAM_INT);
        $stmt->bindParam(':servicio_id', $articulo['servicio_id'], PDO::PARAM_INT);
        $stmt->bindParam(':articulo', $articulo['articulo'], PDO::PARAM_STR);
        $stmt->bindParam(':imagen', $ruta_destino, PDO::PARAM_STR);
        $stmt->bindParam(':comentario', $articulo['comentario'], PDO::PARAM_STR);
        $stmt->execute();
    }

    $conn = null;
}
?>