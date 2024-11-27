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
  <?php $page = "index"; include 'header.php'; ?>
<!-- Slides de fotos -->
  <div class="container text-center">
    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active text-center">
          <img src="imagenes/car2.jpg" class="d-block mx-auto car" alt="...">
        </div>
        <div class="carousel-item">
          <img src="imagenes/car3.jpg" class="d-block mx-auto car" alt="...">
        </div>
        <div class="carousel-item">
          <img src="imagenes/car4.jpg" class="d-block mx-auto car" alt="...">
        </div>
      </div>
    </div>
  </div>

  <div class="container text-center">
    <div class="row">        
        <div class="col sub">
          LO MÁS VENDIDO
        </div>
      </div>
    </div>
      <div class="container my-4">
        <div class="row">
            <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="imagenes/exterior2.jpg" class="ima-slide card-img-top" alt="...">
                        <div class="card-body text-center">
                            <h5 class="card-title">Exterior</h5>
                            <p class="card-text" style="font-family: Arial, Helvetica, sans-serif;">Nuestro servicio de lavado exterior abarca la limpieza detallada de la zona exterior de tus tenis, incluyendo las cintas y la media suela. Empleamos productos y técnicas especializadas que eliminan suciedad y manchas, devolviendo a tus tenis su aspecto fresco y cuidado, mientras preservamos la calidad de los materiales. ¡Déjanos renovarlos por ti!</p>
                        </div>
                    </div>
            </div>
            <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="imagenes/completo.jpg" class="ima-slide card-img-top" alt="...">
                        <div class="card-body text-center">
                            <h5 class="card-title">Completo</h5>
                            <p class="card-text" style="font-family: Arial, Helvetica, sans-serif;">Nuestro servicio de lavado completo garantiza una limpieza integral de tus tenis. Incluye el lavado interior y exterior, cuidado detallado de las cintas y media suela, aplicación de desodorante para un frescor duradero y desinfección profunda con tecnología de ósmosis. Es la solución perfecta para revitalizar tus tenis y mantenerlos higiénicos y como nuevos.</p>
                        </div>
                    </div>
            </div>
            <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="imagenes/infantil.jpg" class="ima-slide card-img-top" alt="...">
                        <div class="card-body text-center">
                            <h5 class="card-title">Infantil</h5>
                            <p class="card-text" style="font-family: Arial, Helvetica, sans-serif;">Nuestro servicio de lavado infantil está diseñado para cuidar los tenis de los más pequeños. Incluye limpieza interior y exterior, cintas, media suela, aplicación de desodorante y desinfección con tecnología de ósmosis. Garantizamos una limpieza profunda y delicada, preservando la calidad y comodidad del calzado infantil. ¡Perfecto para mantener sus tenis como nuevos!</p>
                        </div>
                    </div>
            </div>
            <div class="col-md-4 mb-4 mx-auto">
                    <div class="card">
                        <img src="imagenes/retoque.jpg" class="ima-slide card-img-top" alt="...">
                        <div class="card-body text-center">
                            <h5 class="card-title">Retoque</h5>
                            <p class="card-text" style="font-family: Arial, Helvetica, sans-serif;">Nuestro servicio de retoque está pensado para transformar tus tenis según tus necesidades. Podemos reparar raspones, renovar el color original para devolverles vida, o realizar un cambio total de color para un estilo completamente nuevo. Utilizamos productos de alta calidad para garantizar un acabado impecable y duradero. ¡Haz que tus tenis reflejen tu personalidad!</p>
                        </div>
                    </div>
            </div>

            <div class="col-md-4 mb-4 mx-auto">
                    <div class="card">
                        <img src="imagenes/blanqueamiento.jpg" class="ima-slide card-img-top" alt="...">
                        <div class="card-body text-center">
                            <h5 class="card-title">Blanqueamiento</h5>
                            <p class="card-text" style="font-family: Arial, Helvetica, sans-serif;">Nuestro servicio de blanqueamiento está diseñado para restaurar el color original de tus tenis. Incluye una desoxidación química especializada en la media suela, eliminando el amarillamiento y las manchas difíciles. Con este proceso, tus tenis recuperarán su apariencia fresca y renovada. ¡Dale una segunda vida a tus zapatillas favoritas!</p>
                        </div>
                    </div> 
            </div>
        </div>
  </div>
   
  <?php include 'footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>