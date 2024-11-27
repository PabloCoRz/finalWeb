<?php
try {
    include_once 'funciones/DB.php';
    $conn = getDB();

    // Obtener los datos del formulario
    $usr = $_POST["usuario"];
    $contra = $_POST["contra"];
    

    // Preparar la consulta SQL usando parámetros
    $sql = "INSERT INTO usuario (usuario, passwd) 
            VALUES (:usr, :contra)";

    // Preparar la sentencia
    $stmt = $conn->prepare($sql);
    
    // Vincular los parámetros con los valores obtenidos
    $stmt->bindParam(':usr', $usr, PDO::PARAM_STR);
    $stmt->bindParam(':contra', $contra, PDO::PARAM_STR);
    
    // Ejecutar la consulta
    $stmt->execute();

    // Si la consulta se ejecuta correctamente
    echo "Nuevo registro creado con éxito";

    // Redirigir al usuario a la página principal
    header("Location: login.html");
} catch (PDOException $e) {
    $sqlstate = $e->getCode();
    if ($sqlstate == '23000') {
        header("Location: CrearCuenta.html?error=duplicado");
    } else {
        echo "Error: " . $e->getMessage();
    }
}

// Cerrar la conexión
$conn = null;
?>