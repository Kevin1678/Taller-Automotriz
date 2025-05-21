<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

// Habilitar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuración de la conexión a la BD (usa tus credenciales)
$host = 'localhost';
$dbname = 'servicio_automotriz';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Recibir datos del formulario (POST en lugar de GET)
$data = $_POST;

// Generar el HTML
ob_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 100%; }
        .header { text-align: center; }
        .header img { width: 100px; }
        .info, .totales, .tabla { margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background-color: #eee; }
        .observaciones { margin-top: 30px; font-size: 12px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>SERVICIO AUTOMOTRIZ HERNÁNDEZ</h2>
        <p>correo: ramon.mv1678@gmail.com | Tel: 524 91 46 y 525 79 27</p>
        <p>Bíld. Flores Magón Col. Cumbres C. Circuito Aconcagua #3008</p>
    </div>

    <h3 style="text-align:center;">PRESUPUESTO</h3>

    <div class="info">
        <p><strong>Fecha:</strong> <?= htmlspecialchars($data['fecha'] ?? date('d/m/Y')) ?><br>
           <strong>Cliente:</strong> <?= htmlspecialchars($data['cliente_nombre'] ?? '') ?><br>
           <strong>Teléfono:</strong> <?= htmlspecialchars($data['telefono_cliente'] ?? '') ?><br>
           <strong>Vehículo:</strong> <?= htmlspecialchars(($data['marca_vehiculo'] ?? '') . ' ' . ($data['modelo_vehiculo'] ?? '') . ' (' . ($data['anio_vehiculo'] ?? '') . ')') ?></p>
        <p><strong>Motor:</strong> <?= htmlspecialchars($data['motor'] ?? '') ?></p>
        <p><strong>Kilometraje:</strong> <?= htmlspecialchars($data['kilometraje'] ?? '') ?></p>
    </div>

    <div class="tabla">
        <table>
            <thead>
                <tr>
                    <th>Ref.</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Importe</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $subtotal = 0;
                if (isset($data['descripcion'])) {
                    foreach ($data['descripcion'] as $index => $descripcion) {
                        if (!empty($descripcion)) {
                            $cantidad = $data['cantidad'][$index] ?? 1;
                            $precio = $data['precio'][$index] ?? 0;
                            $importe = $data['importe'][$index] ?? ($cantidad * $precio);
                            $subtotal += $importe;
                            ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($descripcion) ?></td>
                                <td><?= htmlspecialchars($cantidad) ?></td>
                                <td>$<?= number_format($precio, 2) ?></td>
                                <td>$<?= number_format($importe, 2) ?></td>
                            </tr>
                            <?php
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="totales">
        <p><strong>Subtotal:</strong> $<?= number_format($subtotal, 2) ?></p>
        <p><strong>Total:</strong> $<?= number_format($data['total'] ?? $subtotal, 2) ?></p>
    </div>

    <div class="observaciones">
        <strong>Observaciones:</strong>
        <p><?= htmlspecialchars($data['observaciones'] ?? '') ?></p>
    </div>
</div>
</body>
</html>
<?php
$html = ob_get_clean();

// Configuración de Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Limpiar buffer de salida
ob_clean();

// Forzar descarga del PDF
$dompdf->stream("presupuesto_".date('Ymd_His').".pdf", [
    "Attachment" => true,
    "isRemoteEnabled" => true
]);

exit();