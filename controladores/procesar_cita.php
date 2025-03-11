<?php
require_once '../config/conexion.php';
require '../vendor/autoload.php'; // Asegúrate de que la ruta es correcta

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $cedula = $_POST['cedula'];
    $medico_id = $_POST['medico'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $observaciones = $_POST['observaciones'];

    // Validar que la hora sea mayor a las 6:00 am
    if (strtotime($hora) <= strtotime('06:00:00')) {
        header("Location: cita.php?error=La hora debe ser mayor a las 6:00 am.");
        exit();
    }

    // Verificar la disponibilidad del médico
    $stmt = $pdo->prepare("
        SELECT COUNT(*) 
        FROM Citas 
        WHERE id_medico = ? AND fecha = ? AND hora = ?
    ");
    $stmt->execute([$medico_id, $fecha, $hora]);
    $citas_count = $stmt->fetchColumn();

    if ($citas_count > 0) {
        echo "El médico ya tiene una cita programada a esa hora.";
        exit();
    }

    // Verificar si el paciente ya existe
    $stmt = $pdo->prepare("SELECT id FROM Pacientes WHERE email = ?");
    $stmt->execute([$email]);
    $paciente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($paciente) {
        // El paciente ya existe, obtener su ID
        $paciente_id = $paciente['id'];
    } else {
        // Insertar el paciente si no existe
        $stmt = $pdo->prepare("INSERT INTO Pacientes (nombre, apellido, email, telefono, cedula) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $apellido, $email, $telefono, $cedula]);
        $paciente_id = $pdo->lastInsertId();
    }

    // Insertar la cita
    $stmt = $pdo->prepare("INSERT INTO Citas (id_paciente, id_medico, fecha, hora, observaciones) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$paciente_id, $medico_id, $fecha, $hora, $observaciones]);

    // Obtener el nombre y la especialidad del médico
    $stmt = $pdo->prepare("
        SELECT u.nombre, u.apellido, e.nombre AS especialidad 
        FROM Medicos m
        JOIN Usuarios u ON m.id_usuario = u.id
        JOIN Especialidades e ON m.id_especialidad = e.id
        WHERE m.id = ?
    ");
    $stmt->execute([$medico_id]);
    $medico = $stmt->fetch(PDO::FETCH_ASSOC);
    $nombre_medico = $medico['nombre'] . ' ' . $medico['apellido'];
    $especialidad_medico = $medico['especialidad'];

    // Enviar correo de confirmacion usando PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io'; // Cambia esto por tu servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = '2867d6d690bc8f'; // Cambia esto por tu correo electrónico
        $mail->Password = '3636fd003290da'; // Cambia esto por tu contraseña
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Remitente y destinatario
        $mail->setFrom('no-reply@medicalweb.com', 'MedicalWeb');
        $mail->addAddress($email, "$nombre $apellido");

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Confirmación de Cita Médica';
        $mail->Body    = "
            <html>
            <head>
                <title>Confirmación de Cita Médica</title>
            </head>
            <body>
                <h2>Detalles de su Cita</h2>
                <p><strong>Nombre:</strong> $nombre $apellido</p>
                <p><strong>Fecha:</strong> $fecha</p>
                <p><strong>Hora:</strong> $hora</p>
                <p><strong>Médico:</strong> $nombre_medico ($especialidad_medico)</p>
                <p><strong>Observaciones:</strong> $observaciones</p>
                <p>Por favor, confirme su cita haciendo clic en el siguiente enlace:</p>
                <a href='http://localhost/MedicalWeb/confirmar_cita.php?id=$paciente_id&fecha=$fecha&hora=$hora'>Confirmar Cita</a>
            </body>
            </html>
        ";

        $mail->send();
        // Redirigir a la página de confirmación
        header("Location: confirmacion.php");
        exit();
    } catch (Exception $e) {
        header("Location: cita.php?error=No se pudo enviar el correo de confirmación. Error: {$mail->ErrorInfo}");
        exit();
    }
}
?>