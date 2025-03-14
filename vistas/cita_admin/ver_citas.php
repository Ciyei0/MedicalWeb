<?php
session_start();


// Verificar si el usuario está autenticado y tiene un rol asignado
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['rol'])) {
    echo "Solo personal autorizado.";
    exit();
}

// Variables para facilitar el manejo de los enlaces
$rol = $_SESSION['rol']; // Asegurarse de que el rol esté definido en la sesión

?>



<?php

// Incluir el header
include '../../templates/header_admin.php';

// Incluir la conexión desde la carpeta config
require_once '../../config/conexion.php';

// Variables de error
$error = "";

// Obtener las citas de la base de datos
try {
    // Verificar que la conexión a la BD existe
    if (!isset($pdo)) {
        throw new Exception("Error de conexión a la base de datos.");
    }

    // Consulta para obtener todas las citas, pacientes y médicos asociados
    $stmt = $pdo->prepare("
    SELECT 
        citas.id AS id_cita,
        citas.fecha,
        citas.hora,
        citas.observaciones,
        pacientes.nombre AS paciente_nombre,
        pacientes.apellido AS paciente_apellido,
        pacientes.email AS paciente_email,
        pacientes.telefono AS paciente_telefono,
        usuarios.nombre AS medico_nombre,  -- Cambia 'medicos.nombre_medico' a 'usuarios.nombre'
        usuarios.apellido AS medico_apellido  -- Agregamos también el apellido del médico
    FROM 
        citas
    JOIN 
        pacientes ON citas.id_paciente = pacientes.id
    JOIN 
        medicos ON citas.id_medico = medicos.id
    JOIN
        usuarios ON medicos.id_usuario = usuarios.id  -- Unimos la tabla 'usuarios' para obtener el nombre del médico
");
    $stmt->execute();
    $citas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // Mostrar el error en la página para depurar
    error_log("Error al obtener las citas: " . $e->getMessage());
    $error = "Error al obtener las citas: " . $e->getMessage();  // Mostrar el error específico
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEDICALWEB - Panel de Control</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center">MedicalWeb</h4>
        <!-- Enlaces visibles dependiendo del rol del usuario -->
        <?php if ($rol == 'admin' || $rol == 'recepcionista') : ?>
            <a href="controlpanel.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'controlpanel.php') ? 'active' : ''; ?>">Escritorio</a>
            <a href="ver_citas.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'ver_citas.php') ? 'active' : ''; ?>">Ver Citas</a>
        <?php endif; ?>
        <!-- Opción para cerrar sesión -->
        <a href="../logout.php" class="text-danger">Cerrar sesión</a>
    </div>

    <!-- Contenido Principal -->
    <div class="content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="controlpanel.php">Gestión de citas y agenda</a>
            </div>
        </nav>

        <!-- Sección de Citas -->
        <div class="container mt-4">
            <h2>Listado de Citas</h2>

            <?php if (!empty($error)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <!-- Tabla de Citas -->
            <table class="table table-bordered">

                <tbody>
                    <?php if (!empty($citas)) : ?>
                        <?php foreach ($citas as $cita) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($cita['fecha']); ?></td>
                                <td><?php echo htmlspecialchars($cita['hora']); ?></td>
                                <td><?php echo htmlspecialchars($cita['paciente_nombre'] . " " . $cita['paciente_apellido']); ?></td>
                                <td><?php echo htmlspecialchars($cita['medico_nombre']); ?></td>
                                <td><?php echo htmlspecialchars($cita['paciente_email']); ?></td>
                                <td><?php echo htmlspecialchars($cita['paciente_telefono']); ?></td>
                                <td><?php echo htmlspecialchars($cita['observaciones']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center">No hay citas disponibles.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
