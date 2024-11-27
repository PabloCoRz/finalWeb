<?php

function getDB() {
  $usuario = getenv('DB_USER');     
  $password = getenv('DB_PASSWORD');         
  $servidor = getenv('DB_HOST'); 
  $basededatos = getenv('DB_NAME');
  $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return $conn;
}

function ingresarCotizacion($nombre, $apellidos, $telefono, $comentarios, $imagen) {
  try {
    $conn = getDB();
    $sql = "INSERT INTO cotizaciones (nombre, apellidos, telefono, comentarios, imagen, fecha) VALUES (:nombre, :apellidos, :telefono, :comentarios, :imagen, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmt->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
    $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
    $stmt->bindParam(':comentarios', $comentarios, PDO::PARAM_STR);
    $stmt->bindParam(':imagen', $imagen, PDO::PARAM_STR);
    $stmt->execute();
    $conn = null;
    return true;
  } catch (PDOException $e) {
    return "Error al ingresar la cotización: " . $e->getMessage();
  }
}

$nombre = $apellidos = $telefono = $comentarios = $error = $exito = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = $_POST["nombre"];
  $apellidos = $_POST["apellidos"];
  $telefono = $_POST["telefono"];
  $comentarios = $_POST["comentarios"];

  if (empty($nombre) || empty($apellidos) || empty($telefono) || empty($comentarios) || empty($_FILES["fileToUpload"]["tmp_name"])) {
    $error = "Por favor llena todos los campos.";
    header('Location: servicios.php');
    return;
  }

  try {
    $target_dir = "imagenes/cotizaciones/";
    $file = $_FILES["fileToUpload"];
    $caminoImagen = include 'funciones/subirImagen.php';
  } catch (Exception $e) {
    $error = $e->getMessage();
  }

  if (empty($error)) {
    $resultado = ingresarCotizacion($nombre, $apellidos, $telefono, $comentarios, $caminoImagen);
    if ($resultado == true) {
      $exito = "Cotización enviada exitosamente.";
    } else {
      $error = "Error al ingresar la cotización. " . $resultado;
    }
  }
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
    <script src="setupForms.js" defer></script>
    <style>
      .card-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
      }
      .card-servs {
        width: 18rem;
        margin-bottom: 20px;
      }
      .card-icon {
        width: 50px;
        height: 50px;
        margin-bottom: 10px;
      }
    </style>
  </head>
  <body>
  <?php $page = "servicios"; include 'header.php'; ?>

    
  <div class="container my-4">
        <h2 class="mb-3 text-center">SERVICIO DE LIMPIEZA</h2>
        <div class="card-container">
            <div class="card card-servs">
                <div class="card-body text-center">
                    <img src="imagenes/shoes.png" class="card-icon">
                    <h5 class="card-title">EXTERIOR</h5>
                    <p class="card-text">Limpieza zona exterior + Cintas + Media suela.</p>
                    <h5 class="card-title">$150</h5>
                </div>
            </div>
            <div class="card card-servs">
                <div class="card-body text-center">
                    <img src="imagenes/shoes.png" class="card-icon" alt="Icono Completa">
                    <h5 class="card-title">COMPLETA</h5>
                    <p class="card-text">Limpieza zona exterior + Interior + Cintas + Media suela + Desodorante + Desinfección + Resanado.</p>
                    <h5 class="card-title">$200</h5>
                </div>
            </div>
            <div class="card card-servs">
                <div class="card-body text-center">
                    <img src="imagenes/polish.png" class="card-icon" alt="Icono Premium">
                    <h5 class="card-title">PREMIUM</h5>
                    <p class="card-text">Limpieza Completa + Hidratación de piel + Retoque en detalles + Limpieza de duela simple + Resanado.</p>
                    <h5 class="card-title">$250 - $350</h5>
                </div>
            </div>
            <div class="card card-servs">
                <div class="card-body text-center">
                    <img src="imagenes/baby-shoes.png" class="card-icon" alt="Icono Infantil">
                    <h5 class="card-title">INFANTIL</h5>
                    <p class="card-text">Limpieza exterior + Interior + Cintas + Media suela + Desodorante + Desinfección con ósmosis.</p>
                    <h5 class="card-title">$60</h5>
                </div>
            </div>
            <div class="card card-servs">
                <div class="card-body text-center">
                    <img src="imagenes/shoe.png" class="card-icon" alt="Icono Boleado">
                    <h5 class="card-title">BOLEADO</h5>
                    <p class="card-text">Hidratación de piel + Boleado + Limpieza de suela simple.</p>
                    <h5 class="card-title">$60</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-4">
        <h2 class="mb-3 text-center">SERVICIOS EXTRAS</h2>
        <div class="card-container">
            <div class="card card-servs">
                <div class="card-body text-center">
                    <img src="imagenes/resanado.png" class="card-icon" alt="Icono Resanado">
                    <h5 class="card-title">RESANADO</h5>
                    <p class="card-text">Resanado en rasgaduras en piel + Retoque de pintura en detalles. (No incluye limpieza)</p>
                    <h5 class="card-title">$150</h5>
                </div>
            </div>
            <div class="card card-servs">
                <div class="card-body text-center">
                    <img src="imagenes/black-and-white.png" class="card-icon" alt="Icono Blanqueamiento">
                    <h5 class="card-title">BLANQUEAMIENTO</h5>
                    <p class="card-text">Desoxidación QUÍMICA en media suela.</p>
                    <h5 class="card-title">$120</h5>
                </div>
            </div>
            <div class="card card-servs">
                <div class="card-body text-center">
                    <img src="imagenes/resanado.png" class="card-icon" alt="Icono Retoque en Boost">
                    <h5 class="card-title">RETOQUE EN BOOST</h5>
                    <p class="card-text">Blanqueamiento en boost con retoque de color. (Duración aproximada 1 mes)</p>
                    <h5 class="card-title">$120</h5>
                </div>
            </div>
            <div class="card card-servs">
                <div class="card-body text-center">
                    <img src="imagenes/retoque.png" class="card-icon" alt="Icono Retoque en Color">
                    <h5 class="card-title">RETOQUE EN COLOR</h5>
                    <p class="card-text">Detallado en raspaduras, Retoque de color, Cambio total de color.</p>
                    <h5 class="card-title">Desde $80</h5>
                </div>
            </div>
            <div class="card card-servs">
                <div class="card-body text-center">
                    <img src="imagenes/band-aid.png" class="card-icon" alt="Icono Reparaciones">
                    <h5 class="card-title">REPARACIONES</h5>
                    <p class="card-text">Costuras, Pegado de suela, Costura de suela completa, Cambio de cierres, Velcro.</p>
                    <h5 class="card-title">Desde $80</h5>
                </div>
            </div>
        </div>
    </div>

<hr>
<div class="container text-center" style="border: 2px solid #ccc; border-radius: 15px; padding: 20px; width:70%">
    <div class="container text-center">
      <div class="row">        
        <div class="col sub">
          COTIZA TU REPARACIÓN
        </div>
      </div>
    </div>

    <?php
    if (!empty($error)) {
      echo("<div class='alert alert-danger' role='alert'>");
        echo($error);
      echo("</div>");
    } else if (!empty($exito)) {
      echo("<div class='alert alert-success' role='alert'>");
        echo($exito);
      echo("</div>");
    }
    ?>

    <div class="container text-center">
      <div class="col-md-6 mx-auto">

      <form class="row g-3 needs-validation" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
        <div class="col-md-4 position-relative">
          <label for="validationTooltip01" class="form-label">Nombre</label>
          <input type="text" class="form-control" name="nombre" id="validationTooltip01" value="<?php echo $nombre ?>" required>
          <div class="invalid-tooltip">
            Ingresa tu nombre.
          </div>
        </div>
        <div class="col-md-4 position-relative">
          <label for="validationTooltip02" class="form-label">Apellidos</label>
          <input type="text" class="form-control" name="apellidos" id="validationTooltip02" value="<?php echo $apellidos ?>" required>
          <div class="invalid-tooltip">
            Ingresa tus apellidos.
          </div>
        </div>
        <div class="col-md-4 position-relative">
          <label for="validationTooltipPhone" class="form-label">Teléfono</label>
          <div class="input-group has-validation">
            <span class="input-group-text" id="validationTooltipPhonePrepend">#</span>
            <input type="text" class="form-control" id="validationTooltipPhone" name="telefono" aria-describedby="validationTooltipPhonePrepend" pattern="\d{10}" maxlength="10" value="<?php echo $telefono ?>" required>
            <div class="invalid-tooltip">
              Ingresa un número de teléfono válido de 10 dígitos.
            </div>
          </div>
        </div>
        <div class="col-md-12 position-relative">
          <label for="validationTooltip02" class="form-label">Comentarios</label>
          <input type="text" class="form-control" id="validationTooltip02" name="comentarios" value="<?php echo $comentarios ?>"  required>
          <div class="invalid-tooltip">
            Ingresa un comentario.
          </div>
        </div>

        <div class="mb-3 position-relative">
          <label for="formFileMultiple" class="form-label">Sube una imagen del artículo</label>
          <input class="form-control" type="file" name="fileToUpload" id="fileToUpload" multiple required> 
          <div class="invalid-tooltip">
            Ingresa al menos 1 imagen.
          </div>
        </div>
        
        <div class="col-12">
          <button class="btn btn-primary" type="submit">Enviar</button>
        </div>
      </form>
    </div>
    </div>

  </div><br><br><br>

  <?php include 'footer.php'; ?>

  <script defer>
    // llevar la pantalla a alertas si existen
    const alerts = document.querySelectorAll('.alert');
    if (alerts.length > 0) {
      alerts[alerts.length - 1].scrollIntoView({ behavior: 'smooth' });
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>