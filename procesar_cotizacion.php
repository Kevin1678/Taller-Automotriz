<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $servicio = $_POST['servicio'];
    $mensaje = $_POST['mensaje'];

    $sql = "INSERT INTO cotizaciones (nombre, telefono, email, servicio, mensaje)
            VALUES ('$nombre', '$telefono', '$email', '$servicio', '$mensaje')";

    if ($conexion->query($sql) === TRUE) {
        echo "Cotización enviada correctamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }

    $conexion->close();
}
?>