<?php
require_once '../config/conexion.php';

if (isset($_GET['medico_id']) && isset($_GET['fecha'])) {
    $medico_id = $_GET['medico_id'];
    $fecha = $_GET['fecha'];

    // Convertir la fecha al día de la semana en español
    $dias_semana = [
        'Monday' => 'Lunes',
        'Tuesday' => 'Martes',
        'Wednesday' => 'Miércoles',
        'Thursday' => 'Jueves',
        'Friday' => 'Viernes',
        'Saturday' => 'Sábado',
        'Sunday' => 'Domingo'
    ];
    $dia_semana = $dias_semana[date('l', strtotime($fecha))];

    $stmt = $pdo->prepare("
        SELECT hora_inicio, hora_fin
        FROM Horarios
        WHERE id_medico = ? AND dia_semana = ?
    ");
    $stmt->execute([$medico_id, $dia_semana]);
    $horarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<option value="">Seleccione una hora</option>';
    foreach ($horarios as $horario) {
        $hora_inicio = strtotime($horario['hora_inicio']);
        $hora_fin = strtotime($horario['hora_fin']);
        while ($hora_inicio < $hora_fin) {
            $hora = date('H:i', $hora_inicio);
            echo '<option value="' . $hora . '">' . $hora . '</option>';
            $hora_inicio = strtotime('+30 minutes', $hora_inicio);
        }
    }
}
?>