<?php
include_once 'funciones/DB.php'; // Incluir getDB()
require 'ordenes.php'; // Incluir la clase Orden y las funciones para cargarlas de la db
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CAF</title>
    <link rel="icon" href="imagenes/favicon.ico" type="image/ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>

    <?php $page = "historialOrdenes"; include 'header.php'; ?>
    <div class="container text-center">
      <h2>Historial Ordenes</h2>
      <a href="NuevaOrden.php"><button type="button" class="btn btn-primary m-3" data-bs-target="#nuevaOrden" >Nueva Orden</button></a>
    </div>
    <?php
    if(!isset($_SESSION["usuario"])) {
        header("Location: login.html");
    }

    $ordenes = obtenerHistorialOrdenes();
    if (count($ordenes) == 0) {
      echo("<div class='container text-center'>");
      echo("<h1 class='display-1'>No hay órdenes</h1>");
      echo("</div>");
    } else {
      mostrarOrdenes($ordenes);
    }
 include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>


