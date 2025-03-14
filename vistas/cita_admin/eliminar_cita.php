<?php
// Incluir la conexión a la base de datos
require_once __DIR__ . '/../../config/conexion.php';

// Obtener el ID de la cita desde la URL
$id_cita = isset($_GET['id_cita']) ? intval($_GET['id_cita']) : 0;

if ($id_cita > 0) {
    // Preparar la consulta para eliminar la cita
    $query = "DELETE FROM citas WHERE id = ?";
    $stmt = $pdo->prepare($query);

    if ($stmt && $stmt->execute([$id_cita])) {
        // Redirigir a la página de citas con un mensaje de éxito
        header("Location: ver_citas.php?id_medico=" . $_GET['id_medico']  . "&mensaje=Cita eliminada correctamente");
        exit();
    } else {
        // Redirigir con un mensaje de error
        header("Location: ver_citas.php?id_medico=" . $_GET['id_medico'] . "&error=Error al eliminar la cita");
        exit();
    }
} else {
    // Redirigir si no se proporciona un ID de cita válido
    header("Location: ver_citas.php?id_medico=" . $_GET['id_medico'] . "&error=ID de cita no válido");
    exit();
}
?>