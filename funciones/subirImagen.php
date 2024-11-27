<?php

if (!isset($target_dir)) {
    $target_dir = "imagenes/cotizaciones/";
}
if (!isset($file)) { 
    $file = $_FILES["fileToUpload"];
}


$imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
$target_file = $target_dir . basename($file["name"]);

// Check if image file is a actual image or fake image
$check = getimagesize($file["tmp_name"]);
if($check == false) {
    throw new Exception("El archivo no es una imagen.");
} /*else {
    echo "File is an image - " . $check["mime"] . ".\n";
}*/


// Check if file already exists
while (file_exists($target_file)) {
  $target_file = $target_dir . uniqid('', true) . basename($file["name"]);
}

// Check file size
if ($file["size"] > 500000) {
  throw new Exception("El archivo es demasiado grande.");
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
  throw new Exception("Solo se aceptan archivos tipo JPG, JPEG y PNG.");
}

if (move_uploaded_file($file["tmp_name"], $target_file)) {
  return htmlspecialchars($target_file);
} else {
    throw new Exception("Hubo un error al subir el archivo.");
}
?>