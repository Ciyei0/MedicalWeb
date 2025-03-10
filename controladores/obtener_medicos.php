<?php
require_once '../config/conexion.php';

if (isset($_GET['especialidad_id'])) {
    $especialidad_id = $_GET['especialidad_id'];

    $stmt = $pdo->prepare("
        SELECT Medicos.id, Usuarios.nombre, Usuarios.apellido
        FROM Medicos
        JOIN Usuarios ON Medicos.id_usuario = Usuarios.id
        WHERE Medicos.id_especialidad = ?
    ");
    $stmt->execute([$especialidad_id]);
    $medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<option value="">Seleccione un médico</option>';
    foreach ($medicos as $medico) {
        echo '<option value="' . $medico['id'] . '">' . $medico['nombre'] . ' ' . $medico['apellido'] . '</option>';
    }
}
?>