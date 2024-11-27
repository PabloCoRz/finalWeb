<?php 

session_start();

// Eliminar todas las variables de sesión
session_unset();

// regresar a la página anterior
header('Location: ' . $_SERVER["HTTP_REFERER"] );
?>