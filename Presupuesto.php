<?php
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

// Conexión a la base de datos
$db = new PDO('mysql:host=localhost;dbname=servicio_automotriz', '', '');

// Obtener datos del presupuesto
$presupuestoId = $_GET['id'] ?? 1; // ID del presupuesto a generar

$stmt = $db->prepare("SELECT * FROM presupuestos WHERE id = ?");
$stmt->execute([$presupuestoId]);
$presupuesto = $stmt->fetch(PDO::FETCH_ASSOC);

// Obtener items del presupuesto
$stmt = $db->prepare("SELECT * FROM presupuesto_items WHERE presupuesto_id = ?");
$stmt->execute([$presupuestoId]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// HTML para el PDF (similar al diseño de tu imagen)
$html = '
<!DOCTYPE html>
<html>
<head>
    <title>Presupuesto Taller Mecánico</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 10px; }
        .title { font-size: 16px; font-weight: bold; margin-bottom: 5px; }
        .info { margin-bottom: 10px; }
        .info-line { margin-bottom: 3px; }
        .info-columns { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .info-column { width: 48%; }
        .items-table { width: 100%; border-collapse: collapse; margin-top: 5px; margin-bottom: 10px; }
        .items-table th, .items-table td { border: 1px solid #000; padding: 5px; }
        .items-table th { background-color: #f2f2f2; text-align: center; }
        .items-table td { vertical-align: top; }
        .totals { text-align: right; margin-top: 10px; }
        .footer { margin-top: 20px; font-size: 10px; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">PRESUPUESTO</div>
        <div class="info-line"><strong>Fecha:</strong> '.$presupuesto['fecha'].'</div>
        <div class="info-line"><strong>Validez:</strong> '.$presupuesto['validez'].'</div>
        <div class="info-line"><strong>Motor:</strong> '.$presupuesto['motor'].'</div>
    </div>

    <hr style="border-top: 1px solid #000; margin: 5px 0;">

    <div class="info">
        <img src="imagenes/logo.jpg" width="100px" alt="Logo del negocio">
        <div style="text-align: center; font-weight: bold;">SERVICIO AUTOMOTRIZ HERNÁNDEZ</div>
        <div style="text-align: center;">correo: ramon.mv1678@gmail.com</div>
        <div style="text-align: center;">Bíld. Flores Magón Col. Cumbres C. Circuito Aconcagua #3008</div>
        <div style="text-align: center;">Tel: (664) 525-7927</div>
    </div>

    <hr style="border-top: 1px solid #000; margin: 5px 0;">

    <div class="info-columns">
        <div class="info-column">
            <div><strong>Telefono:</strong> '.$presupuesto['telefono_cliente'].'</div>
            <div><strong>Cliente:</strong> '.$presupuesto['cliente_nombre'].'</div>
        </div>
        <div class="info-column">
            <div><strong>Marca:</strong> '.$presupuesto['marca_vehiculo'].'</div>
            <div><strong>Modelo:</strong> '.$presupuesto['modelo_vehiculo'].'</div>
            <div><strong>Año:</strong> '.$presupuesto['anio_vehiculo'].'</div>
            <div><strong>Kmh/Mph:</strong> '.$presupuesto['kilometraje'].'</div>
        </div>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th width="5%">Ref.</th>
                <th width="55%">Descripción</th>
                <th width="10%">Cantidad</th>
                <th width="15%">Precio</th>
                <th width="15%">Importe</th>
            </tr>
        </thead>
        <tbody>';

foreach ($items as $item) {
    $html .= '
            <tr>
                <td></td>
                <td>'.$item['descripcion'].'</td>
                <td style="text-align: center;">'.$item['cantidad'].'</td>
                <td style="text-align: right;">$'.number_format($item['precio'], 2, '.', ',').'</td>
                <td style="text-align: right;">$'.number_format($item['importe'], 2, '.', ',').'</td>
            </tr>';
}

// Rellenar con filas vacías hasta completar 12 filas (como en tu ejemplo)
$emptyRows = 12 - count($items);
for ($i = 0; $i < $emptyRows; $i++) {
    $html .= '
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>';
}

$html .= '
        </tbody>
    </table>

    <div class="info">
        <div><strong>Observaciones</strong></div>
        <div>'.$presupuesto['observaciones'].'</div>
    </div>

    <div class="totals">
        <div><strong>Subtotal:</strong> $'.number_format($presupuesto['subtotal'], 2, '.', ',').'</div>
        <div><strong>Total:</strong> $'.number_format($presupuesto['total'], 2, '.', ',').'</div>
    </div>

    <div class="footer">
        Gracias por su preferencia. Este presupuesto es válido por 15 días a partir de la fecha de emisión.
    </div>
</body>
</html>';

// Generar PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Salida del PDF
$dompdf->stream("presupuesto_".$presupuesto['numero_presupuesto'].".pdf", array("Attachment" => true));
?>