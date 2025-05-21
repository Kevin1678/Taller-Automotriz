<?php
// guardar_presupuesto.php

// Configuración de la conexión a la BD
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

// Recoger datos del formulario
$fecha = $_POST['fecha'];
$cliente_nombre = $_POST['cliente_nombre'];
// ... recoger todos los demás campos ...

// Insertar el presupuesto
try {
    $stmt = $db->prepare("INSERT INTO presupuestos 
        (fecha, cliente_nombre, telefono_cliente, marca_vehiculo, modelo_vehiculo, 
         anio_vehiculo, kilometraje, motor, observaciones, subtotal, total)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->execute([
        $fecha,
        $cliente_nombre,
        $_POST['telefono_cliente'],
        $_POST['marca_vehiculo'],
        $_POST['modelo_vehiculo'],
        $_POST['anio_vehiculo'],
        $_POST['kilometraje'],
        $_POST['motor'],
        $_POST['observaciones'],
        $_POST['subtotal'],
        $_POST['total']
    ]);
    
    $presupuesto_id = $db->lastInsertId();
    
    // Insertar items del presupuesto
    if (isset($_POST['descripcion'])) {
        $stmtItems = $db->prepare("INSERT INTO presupuesto_items 
            (presupuesto_id, descripcion, cantidad, precio, importe)
            VALUES (?, ?, ?, ?, ?)");
        
        foreach ($_POST['descripcion'] as $index => $descripcion) {
            $stmtItems->execute([
                $presupuesto_id,
                $descripcion,
                $_POST['cantidad'][$index],
                $_POST['precio'][$index],
                $_POST['importe'][$index]
            ]);
        }
    }
    
// Mostrar alerta de éxito y redirigir
        echo "<script>
                alert('✅ ¡Presupuesto ha sido guardado con éxito!');
                window.location.href = 'index.html'; // Cambia esto por la página a la que quieras redirigir
              </script>";
        exit();
    } catch (PDOException $e) {
        // Mostrar alerta de error
        echo "<script>
                alert('❌ Error al guardar el presupuesto: " . addslashes($e->getMessage()) . "');
                window.history.back();
              </script>";
        exit();
    }
    
