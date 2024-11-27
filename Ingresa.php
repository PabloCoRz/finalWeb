<?php
try {
    include_once 'funciones/DB.php';
    $conn = getDB();
    
    // Obtener los datos enviados por el formulario mediante el método GET
    $usr = $_POST["usuario"];
    $contra = $_POST["contra"];

    // Preparar la consulta SQL para actualizar los datos de la serie
    $sql = "SELECT COUNT(*) FROM usuario WHERE usuario=:usr and passwd=:contra";
    
    // Preparar la declaración para su ejecución
    $stmt = $conn->prepare($sql);
    
    // Asignar los parámetros a la consulta
    $stmt->bindParam(':usr', $usr, PDO::PARAM_STR); // Vincular el nombre
    $stmt->bindParam(':contra', $contra, PDO::PARAM_STR); // Vincular la contra

    // Ejecutar la consulta
    $stmt->execute();
    $user_exists = $stmt->fetchColumn();



    // Verificar si se actualizó alguna fila
    if ($user_exists > 0) {
        // Iniciar una nueva sesión
        session_start();
        // Almacenar el nombre de usuario en la variable de sesión
        $_SESSION["usuario"] = $usr;
        // Redirigir al usuario a la página principal
        header("Location: index.php");
    } else {
        header("Location: login.html?mensaje=noexito");
    }


} catch (PDOException $e) {
    // Mostrar un mensaje de error si ocurre algún problema en la consulta
    echo("Error: " . $e->getMessage());
    //header("Location: index.php?mensaje=error");  
}

// Cerrar la conexión PDO
$conn = null;


?>