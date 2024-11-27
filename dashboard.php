<?php
include_once 'funciones/DB.php'; // Incluir getDB()
require 'ordenes.php'; // Incluir la clase Orden y las funciones para cargarlas de la db

if (isset($_GET['mensaje'])) {
  $mensaje = $_GET['mensaje'];
  echo "<script>";
  if ($mensaje === 'exito') {
      echo "alert('Se actualizó orden con éxito!');";
  } else{
      echo "alert('Error ');";
  }
  echo "</script>";
} else {
  echo "<script>console.log('No hay mensaje');</script>";
}

function obtenerCotizaciones() {
  $conn = getDB();
  $sql = "SELECT * FROM cotizaciones ORDER BY fecha ASC";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $cotizaciones = $stmt->fetchAll();
  $conn = null;
  return $cotizaciones;
}

function mostrarCotizaciones($cotizaciones) {
  echo("<div class='container'>");
  echo("<h1 class='display-1 text-center'>Cotizaciones</h1>");
  echo("<div class='row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4'>");
  foreach ($cotizaciones as $cotizacion) {
    echo("<div class='col'>");
    echo("<div class='card'>");
    echo("<div class='card-header'>");
    echo("<h5 class='card-title'>Cotización #" . $cotizacion['cotizacion_id'] . "</h5>");
    echo("</div>");
    echo("<div class='card-body'>");
    echo("<p class='card-text'>Fecha: " . $cotizacion['fecha'] . "</p>");
    echo("<p class='card-text'>Cliente: " . $cotizacion['nombre'] . "</p>");
    echo("<p class='card-text'>Teléfono: " . $cotizacion['telefono'] . "</p>");
    echo("<p class='card-text'>" . $cotizacion['comentarios'] . "</p>");
    echo("<div class='text-center'><img src='$cotizacion[imagen]' class='img-fluid' style='height:200px' alt='Imagen de la cotización'></div><br>");
    echo("<button type='button' class='btn btn-primary' data-bs-target='#pasaAOrdenes'>Crear orden de cotizaci&oacute;n</button>");
    echo("</div>");
    echo("</div>");
    echo("</div>");
  }
  echo("</div>");
  echo("</div>");
}
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

    <?php $page = "dashboard"; include 'header.php'; ?>
    <div class="container text-center">
      <h2>Dashboard</h2>
      <a href="NuevaOrden.php"><button type="button" class="btn btn-primary m-3" data-bs-target="#nuevaOrden" >Nueva Orden</button></a>
    </div>
    <?php

    if(!isset($_SESSION["usuario"])) {
      header("Location: login.html");
    }

    $ordenes = obtenerOrdenes();
    if (count($ordenes) == 0) {
      echo("<div class='container text-center'>");
      echo("<h1 class='display-1'>No hay órdenes</h1>");
      echo("</div>");
    } else {
      mostrarOrdenes($ordenes);
    }

    $cotizaciones = obtenerCotizaciones();
    if (count($cotizaciones) == 0) {
      echo("<div class='container text-center'>");
      echo("<h1 class='display-1'>No hay cotizaciones</h1>");
      echo("</div>");
    } else {
      mostrarCotizaciones($cotizaciones);
    }
    ?>

  <?php include 'footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>