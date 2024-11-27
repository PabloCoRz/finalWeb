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
?>