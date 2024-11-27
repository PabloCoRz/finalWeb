<?php
include_once 'funciones/DB.php'; // Incluir getDB()

function getTickets() {
  $conn = getDB();
  $sql = "SELECT * FROM ticket WHERE estado='En Proceso' ORDER BY fecha_entrega ASC";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $tickets = $stmt->fetchAll();
  $conn = null;
  return $tickets;
}

function getTicketsHistorial() {
  $conn = getDB();
  $sql = "SELECT * FROM ticket WHERE estado='completado' ORDER BY fecha_entrega ASC";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $tickets = $stmt->fetchAll();
  $conn = null;
  return $tickets;
}

function getCliente($cliente_id) {
  $conn = getDB();
  $sql = "SELECT * FROM cliente WHERE cliente_id=:cliente_id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
  $stmt->execute();
  $cliente = $stmt->fetch();
  $conn = null;
  return $cliente;
}

function getServicios_Ticket($ticket_id) {
  $conn = getDB();
  $sql = "SELECT * FROM servicio_ticket WHERE ticket_id=:ticket_id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
  $stmt->execute();
  $servicios = $stmt->fetchAll();
  $conn = null;
  return $servicios;
}

function getServicio($servicio_id) {
  $conn = getDB();
  $sql = "SELECT * FROM servicio WHERE servicio_id=:servicio_id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':servicio_id', $servicio_id, PDO::PARAM_INT);
  $stmt->execute();
  $servicio = $stmt->fetch();
  $conn = null;
  return $servicio;
}

class Orden {
  public $ticket_id;

  public $fecha_compra;
  public $fecha_entrega;

  public $anticipo;
  public $total;

  public $nombre_cliente;
  public $telefono;
  
  public $servicios = array();
}

class Servicio {
  public $nombre;
  public $articulo;
  public $imagen;
  public $comentario;
}


function obtenerOrdenes() {
  $ordenes = array();

  $tickets = getTickets();
  for ($i = 0; $i < count($tickets); $i++) {
    $ticket = $tickets[$i];
    
    $cliente = getCliente($ticket["cliente_id"]);

    $ordenes[$i] = new Orden();
    $ordenes[$i]->ticket_id = $ticket["ticket_id"];

    $ordenes[$i]->fecha_compra = $ticket["fecha_compra"];
    $ordenes[$i]->fecha_entrega = $ticket["fecha_entrega"];

    $ordenes[$i]->anticipo = $ticket["anticipo"];
    $ordenes[$i]->total = $ticket["precio_total"];


    $ordenes[$i]->nombre_cliente = $cliente["nombre"];
    $ordenes[$i]->telefono = $cliente["telefono"];


    $servicios_ticket = getServicios_Ticket($ticket["ticket_id"]);
    for ($j = 0; $j < count($servicios_ticket); $j++) {
      $servicio_ticket = $servicios_ticket[$j];
      $servicio = getServicio($servicio_ticket["servicio_id"]);

      $serv = new Servicio();
      $serv->nombre = $servicio["nombre"];
      $serv->articulo = $servicio_ticket["articulo"];
      $serv->imagen = $servicio_ticket["imagen"];

      $ordenes[$i]->servicios[$j] = $serv;
    }
  }

  return $ordenes;
}

function obtenerHistorialOrdenes() {
  $ordenes = array();

  $tickets = getTicketsHistorial();
  for ($i = 0; $i < count($tickets); $i++) {
    $ticket = $tickets[$i];
    
    $cliente = getCliente($ticket["cliente_id"]);

    $ordenes[$i] = new Orden();
    $ordenes[$i]->ticket_id = $ticket["ticket_id"];

    $ordenes[$i]->fecha_compra = $ticket["fecha_compra"];
    $ordenes[$i]->fecha_entrega = $ticket["fecha_entrega"];

    $ordenes[$i]->anticipo = $ticket["anticipo"];
    $ordenes[$i]->total = $ticket["precio_total"];


    $ordenes[$i]->nombre_cliente = $cliente["nombre"];
    $ordenes[$i]->telefono = $cliente["telefono"];


    $servicios_ticket = getServicios_Ticket($ticket["ticket_id"]);
    for ($j = 0; $j < count($servicios_ticket); $j++) {
      $servicio_ticket = $servicios_ticket[$j];
      $servicio = getServicio($servicio_ticket["servicio_id"]);

      $serv = new Servicio();
      $serv->nombre = $servicio["nombre"];
      $serv->articulo = $servicio_ticket["articulo"];
      $serv->imagen = $servicio_ticket["imagen"];

      $ordenes[$i]->servicios[$j] = $serv;
    }
  }

  return $ordenes;
}

function plantillaOrden($orden,$page) {
  echo("<div class='container mb-4'>");
  echo("<div class='card'>");
  echo("<div class='card-header'>");
  echo("<h5 class='card-title'>Orden #" . $orden->ticket_id . "</h5>");
  echo("</div>");
  echo("<div class='card-body d-flex justify-content-between'>");
  echo("<div class='me-4'>");
      echo("<p class='card-text'>Fecha de compra: " . $orden->fecha_compra . "</p>");
      echo("<p class='card-text'>Cliente: " . $orden->nombre_cliente . "</p>");
      echo("<p class='card-text'>Teléfono: " . $orden->telefono . "</p>");
      echo("<p class='card-text'>Anticipo: $" . $orden->anticipo . "</p>");
      echo("<p class='card-text'>Total: $" . $orden->total . "</p>");
      echo("<p class='card-text'>Fecha de entrega: " . $orden->fecha_entrega . "</p>");
  echo("</div>");
  echo("<div>");
      echo("<p class='card-text'>Servicios:</p>");
      echo("<ul class='list-group list-group-horizontal'>");
          for ($j = 0; $j < count($orden->servicios); $j++) {
              $servicio = $orden->servicios[$j];
              echo("
              <li class='list-group-item'>
              <h5 class='card-title'>" . $servicio->nombre . "</h5>
              <p class='card-text'>Artículo: " . $servicio->articulo . "</p>
              <img src='" . $servicio->imagen . "' class='img-fluid' style='max-height: 200px;'>
              </li>");
          }
      echo("</ul>");
  echo("</div>");
  echo("</div>");
  if($page == 'dashboard'){
  echo('<form action="cambiar_estado.php" method="post" style="display:inline;">');
  echo('<input type="hidden" name="order_id" value="' . $orden->ticket_id .  '">');
  echo('<button type="submit" class="btn btn-primary m-2">Completar orden</button>');
  echo('</form>');
  }
  echo("</div>");
  echo("</div>");
}

function mostrarOrdenes($ordenes,$page) {
  for ($i = 0; $i < count($ordenes); $i++) {
    $orden = $ordenes[$i];
    plantillaOrden($orden,$page);
  }
}

?>