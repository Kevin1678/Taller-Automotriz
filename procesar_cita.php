<?php
// Configuración de la base de datos
$host = 'localhost';
$dbname = 'servicio_automotriz';
$username = 'root';
$password = '';

// Conexión a la base de datos
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit();
}

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $servicio = $_POST['servicio'];

    // Preparar la consulta SQL
    $sql = "INSERT INTO citas (nombre, telefono, email, fecha, hora, servicio) 
            VALUES (:nombre, :telefono, :email, :fecha, :hora, :servicio)";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':hora', $hora);
        $stmt->bindParam(':servicio', $servicio);
        $stmt->execute();

        // Mostrar alerta de éxito y redirigir
        echo "<script>
                alert('✅ ¡Tu cita ha sido registrada con éxito!');
                window.location.href = 'index.html'; // Cambia esto por la página a la que quieras redirigir
              </script>";
        exit();
    } catch (PDOException $e) {
        // Mostrar alerta de error
        echo "<script>
                alert('❌ Error al guardar la cita: " . addslashes($e->getMessage()) . "');
                window.history.back();
              </script>";
        exit();
    }
}
?>