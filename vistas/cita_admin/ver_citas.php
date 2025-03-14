<?php
// Incluir el header
include '../../templates/header.php';
// Verificar si el usuario está autenticado y tiene un rol asignado
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['rol'])) {
    echo "Solo personal autorizado.";
    exit();
}

// Variables para facilitar el manejo de los enlaces
$rol = $_SESSION['rol']; // Asegurarse de que el rol esté definido en la sesión



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
    $query = "
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
    ";

    // Si el usuario no es administrador, filtrar por su ID de médico
    if ($rol != 'admin') {
        $query .= " WHERE medicos.id_usuario = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$_SESSION['usuario_id']]);
    } else {
        // Si es administrador, obtener todas las citas sin filtrar
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    }

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
    


        <!-- Sección de Citas -->
        <div class="container mt-4 mb-2">
            <h2>Listado de Citas</h2>

            <?php if (!empty($error)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <!-- Tabla de Citas -->
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Paciente</th>
                        <th>Médico</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Observaciones</th>
                        <th>Acciones</th> <!-- Nueva columna para acciones -->
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($citas)) : ?>
                        <?php foreach ($citas as $cita) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($cita['fecha']); ?></td>
                                <td><?php echo htmlspecialchars($cita['hora']); ?></td>
                                <td><?php echo htmlspecialchars($cita['paciente_nombre'] . " " . $cita['paciente_apellido']); ?></td>
                                <td><?php echo htmlspecialchars($cita['medico_nombre'] . " " . $cita['medico_apellido']); ?></td>
                                <td><?php echo htmlspecialchars($cita['paciente_email']); ?></td>
                                <td><?php echo htmlspecialchars($cita['paciente_telefono']); ?></td>
                                <td><?php echo htmlspecialchars($cita['observaciones']); ?></td>
                                <td>
                                    <a href='editar_cita.php?id_cita=<?php echo $cita['id_cita']; ?>' class='btn btn-warning btn-sm'>Editar</a>
                                    <a href='eliminar_cita.php?id_cita=<?php echo $cita['id_cita']; ?>' class='btn btn-danger btn-sm' onclick='return confirm("¿Estás seguro de eliminar esta cita?")'>Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="8" class="text-center">No hay citas disponibles.</td>
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