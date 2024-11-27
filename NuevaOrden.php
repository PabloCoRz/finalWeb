<?php
include_once 'funciones/DB.php'; // Incluir getDB()
require 'ordenes.php'; // Incluir la clase Orden y las funciones para cargarlas de la db

if (isset($_GET['mensaje'])) {
    $mensaje = $_GET['mensaje'];
    echo "<script>";
    if ($mensaje === 'exito') {
        echo "alert('Se insertó orden con éxito!');";
    } elseif ($mensaje === 'noexito') {
        echo "alert('Error insertando orden');";
    }
    echo "</script>";
} else {
    echo "<script>console.log('No hay mensaje');</script>";
}

function obtenerClientes() {
    $conn = getDB();
    $sql = "SELECT cliente_id, nombre FROM cliente";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $conn = null;
    return $clientes;
}

function obtenerServicios() {
    $conn = getDB();
    $sql = "SELECT servicio_id, nombre FROM servicio";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $conn = null;
    return $servicios;
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php $page = "dashboard"; include 'header.php'; ?>
<div class="container text-center">
    <h2>Crear Nuevo Cliente</h2>
</div><br>
<div class="container text-center bg-secondary rounded p-1 mb-3">
    <form id="nuevoClienteForm" onsubmit="return handleFormSubmit(event)">        
        <div class="m-3">
            <label for="nombre" class="form-label">Nombre del Cliente</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="m-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" required>
        </div>
        <button type="submit" class="btn btn-primary">Crear Cliente</button>
    </form>
</div><hr>
<div class="container text-center">
    <h2>Crear nueva orden</h2>
</div><br>
<div class="container text-center bg-secondary rounded p-3 mb-3">
    <form action="insertarOrden.php" method="post" enctype="multipart/form-data"> 
        <div class="mb-3">
            <label for="cliente_id" class="form-label">Nombre del cliente</label>
            <select class="form-control" id="cliente_id" name="cliente_id" required >
                <option value="">Seleccione un cliente</option>
                <?php
                $clientes = obtenerClientes();
                foreach ($clientes as $cliente) {
                    echo "<option value='{$cliente['cliente_id']}'>{$cliente['nombre']}</option>";
                }
                ?>
            </select>
        </div>
        <template id="articulo-template">
            <div class="container bg-light rounded p-3 articulo mt-3 mb-3">
                <div class="mb-3">
                    <label for="servicio_id" class="form-label">Servicio</label>
                    <select class="form-control servicio_id" id="servicio_id" name="servicio_id[]" required>
                        <?php
                        $servicios = obtenerServicios();
                        foreach ($servicios as $servicio) {
                            echo "<option value='{$servicio['servicio_id']}'>{$servicio['nombre']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="articulo" class="form-label">Artículo</label>
                    <input type="text" class="form-control" id="articulo" name="articulo[]" required>
                </div>
                <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen</label>
                    <input type="file" class="form-control" id="imagen" name="imagen[]" accept="image/*" required>
                </div>
                <div class="mb-3">
                    <label for="comentario" class="form-label">Comentario</label>
                    <textarea class="form-control" id="comentario" name="comentario[]" rows="3"></textarea>
                </div>
            </div>
        </template>
        <div id="articulos-container">
            <div class="container bg-light rounded p-3 articulo mt-3 mb-3">
                <div class="mb-3">
                    <label for="servicio_id" class="form-label">Servicio</label>
                    <select class="form-control servicio_id" id="servicio_id" name="servicio_id[]" required> 
                        <?php
                        $servicios = obtenerServicios();
                        foreach ($servicios as $servicio) {
                            echo "<option value='{$servicio['servicio_id']}'>{$servicio['nombre']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="articulo" class="form-label">Artículo</label>
                    <input type="text" class="form-control" id="articulo" name="articulo[]" required> 
                </div>
                <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen</label>
                    <input type="file" class="form-control" id="imagen" name="imagen[]" accept="image/*" required> 
                </div>
                <div class="mb-3">
                    <label for="comentario" class="form-label">Comentario</label>
                    <textarea class="form-control" id="comentario" name="comentario[]" rows="3"></textarea> 
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-primary m-2" id="agregar_articulo">Agregar Artículo</button>
        <div class="mb-3">
            <label for="anticipo" class="form-label">Anticipo</label>
            <input type="number" class="form-control" id="anticipo" name="anticipo" required>
        </div> 
        <div class="mb-3">
            <label for="fecha_entrega" class="form-label">Fecha de Entrega</label>
            <input type="date" class="form-control" id="fecha_entrega" name="fecha_entrega" required>
        </div>
        <button type="submit" class="btn btn-primary">Crear Orden</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#cliente_id').select2({
            placeholder: "Seleccione un cliente",
            allowClear: true
        });

        $('.servicio_id').select2({
            placeholder: "Seleccione un servicio",
            allowClear: true
        });

        $('#agregar_articulo').click(function() {
            var articuloClone = $('.articulo:first').clone();
            var index = $('#articulos-container .articulo').length;

            articuloClone.find('input, textarea').val('');

            articuloClone.find('select').select2('destroy').removeAttr('data-select2-id').removeAttr('aria-hidden').removeClass('select2-hidden-accessible');

            articuloClone.find('select').attr('id', 'servicio_id_' + index).select2({
                placeholder: "Seleccione un servicio",
                allowClear: true
            });

            articuloClone.find('input[id^="articulo"]').attr('id', 'articulo_' + index);
            articuloClone.find('input[id^="imagen"]').attr('id', 'imagen_' + index);
            articuloClone.find('textarea[id^="comentario"]').attr('id', 'comentario_' + index);

            $('#articulos-container').append(articuloClone);
        });
        $('#agregar_articulo').click(function() {
            var template = document.getElementById('articulo-template');
            var clone = document.importNode(template.content, true);
            var index = $('#articulos-container .articulo').length;

            // Update the IDs of the cloned elements to ensure they are unique
            $(clone).find('select').attr('id', 'servicio_id_' + index).select2({
                placeholder: "Seleccione un servicio",
                allowClear: true
            });

            $(clone).find('input[id^="articulo"]').attr('id', 'articulo_' + index);
            $(clone).find('input[id^="imagen"]').attr('id', 'imagen_' + index);
            $(clone).find('textarea[id^="comentario"]').attr('id', 'comentario_' + index);

            // Append the cloned article to the container
            $('#articulos-container').append(clone);
        });
    });
    function handleFormSubmit(event) {
        event.preventDefault(); 

        var nombre = document.getElementById('nombre').value;
        var telefono = document.getElementById('telefono').value;

        $.ajax({
        url: 'insertarCliente.php',
        type: 'POST',
        data: { nombre: nombre, telefono: telefono },
        dataType: 'json',
        success: function(response) {
            console.log(response);
            if (response.status === 'success') {
                alert(response.message);
                document.getElementById('nuevoClienteForm').reset();
                location.reload();
            } else {
                alert(response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
        }
    });

    }

</script>
</body>
</html>

