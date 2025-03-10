<?php
require_once 'config/conexion.php';

if (isset($_GET['id']) && isset($_GET['fecha']) && isset($_GET['hora'])) {
    $paciente_id = $_GET['id'];
    $fecha = $_GET['fecha'];
    $hora = $_GET['hora'];

    // Actualizar el estado de la cita a confirmada
    $stmt = $pdo->prepare("UPDATE Citas SET estado = 'confirmada' WHERE id_paciente = ? AND fecha = ? AND hora = ?");
    $stmt->execute([$paciente_id, $fecha, $hora]);

    // Redirigir a la página de éxito
    header("Location: cita_confirmada.php");
    exit();
}
?>