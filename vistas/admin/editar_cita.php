<?php
// Incluir la conexión a la base de datos
require_once __DIR__ . '/../../config/conexion.php';

// Obtener el ID de la cita desde la URL
$id_cita = isset($_GET['id_cita']) ? intval($_GET['id_cita']) : 0;
$id_medico = isset($_GET['id_medico']) ? intval($_GET['id_medico']) : 0;

if ($id_cita > 0) {
    // Obtener los datos de la cita
    $query = "SELECT * FROM citas WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id_cita]);
    $cita = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$cita) {
        // Redirigir si la cita no existe
        header("Location: ver_citas.php?id_medico=" . $_GET['id_medico'] . "&error=Cita no encontrada");
        exit();
    }
} else {
    // Redirigir si no se proporciona un ID de cita válido
    header("Location: ver_citas.php?id_medico=" . $_GET['id_medico'] . "&error=ID de cita no válido");
    exit();
}

// Procesar el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $observaciones = $_POST['observaciones'];

    // Actualizar la cita en la base de datos
    $query = "UPDATE citas SET fecha = ?, hora = ?, observaciones = ? WHERE id = ?";
    $stmt = $pdo->prepare($query);

    if ($stmt->execute([$fecha, $hora, $observaciones, $id_cita])) {
        // Redirigir con un mensaje de éxito
        header("Location: ver_citas.php?id_medico=" . $_GET['id_medico']  );
        echo "Cita actualizada correctamente";
        exit();
    } else {
        // Redirigir con un mensaje de error
        header("Location: ver_citas.php?id_medico=" . $_GET['id_medico'] );
        echo "Error al actualizar la cita";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cita</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Editar Cita</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo htmlspecialchars($cita['fecha']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="hora" class="form-label">Hora</label>
                <input type="time" class="form-control" id="hora" name="hora" value="<?php echo htmlspecialchars($cita['hora']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="observaciones" class="form-label">Observaciones</label>
                <textarea class="form-control" id="observaciones" name="observaciones" rows="3"><?php echo htmlspecialchars($cita['observaciones']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="ver_citas.php?id_medico=<?php echo htmlspecialchars($_GET['id_medico']); ?>" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>