<?php
// Incluir el header
include '../../templates/header.php';

require_once __DIR__ . '/../../config/conexion.php';

// Obtener el id_medico desde la URL
$id_medico = isset($_GET['id_medico']) ? intval($_GET['id_medico']) : 0;

if ($id_medico > 0) {
    // Consulta para obtener las citas del médico junto con los datos del paciente
    $query = "
        SELECT 
            citas.id AS id_cita,
            citas.fecha,
            citas.hora,
            citas.observaciones,
            pacientes.nombre,
            pacientes.apellido,
            pacientes.email,
            pacientes.telefono
        FROM 
            citas
        JOIN 
            pacientes ON citas.id_paciente = pacientes.id
        WHERE 
            citas.id_medico = ?
    ";
    $stmt = $pdo->prepare($query);
    if ($stmt) {
        $stmt->execute([$id_medico]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0) {
            echo "<h1 class='d-flex justify-content-center my-4'>Citas</h1>";
            echo "<div class='table-responsive'>";
            echo "<table class='table table-bordered table-striped'>";
            echo "<thead class='table-dark'>
                    <tr>
                        <th>Hora</th>
                        <th>Observaciones</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Acciones</th> <!-- Nueva columna para acciones -->
                    </tr>
                  </thead>";
            echo "<tbody>";

            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["hora"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["observaciones"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["nombre"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["apellido"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["telefono"]) . "</td>";
                // Botones de acciones (Editar y Eliminar)
                echo "<td>
                        <a href='editar_cita.php?id_cita=" . $row["id_cita"] . "&id_medico=" . $id_medico . "' class='btn btn-warning btn-sm'>Editar</a>
                        <a href='eliminar_cita.php?id_cita=" .  $row["id_cita"] . "&id_medico=" . $id_medico . "' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro de eliminar esta cita?\")'>Eliminar</a>
                      </td>";
                echo "</tr>";
            }

            echo "</tbody></table></div>";
        } else {
            echo "<div class='alert alert-warning'>No se encontraron citas para este médico.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Error al preparar la consulta.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>No se proporcionó un ID de médico válido.</div>";
}

// Incluir el footer
include '../../templates/footer.php';
?>