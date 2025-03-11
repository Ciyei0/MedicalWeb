<?php
session_start();

// Activar errores de PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir la conexión desde la carpeta config
require_once '../config/conexion.php'; 

// Verificar que el formulario fue enviado correctamente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = isset($_POST["nombre_usuario"]) ? trim($_POST["nombre_usuario"]) : null;
    $contrasena = isset($_POST["clave"]) ? trim($_POST["clave"]) : null;

    if (empty($usuario) || empty($contrasena)) {
        $error = "Por favor, complete todos los campos.";
    } else {
        try {
            // Verificar que la conexión a la BD existe
            if (!isset($pdo)) {
                throw new Exception("Error de conexión a la base de datos.");
            }

            // Consulta segura con prepared statements
            $stmt = $pdo->prepare("SELECT id, password_hash FROM usuarios WHERE nombre_usuario = :usuario");
            $stmt->bindParam(":usuario", $usuario, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($contrasena, $user["password_hash"])) {
                // Guardar el ID de usuario en la sesión
                $_SESSION["usuario_id"] = $user["id"];
                $_SESSION["nombre_usuario"] = $usuario;

                // Obtener el id_medico asociado al usuario
                $stmt = $pdo->prepare("SELECT id FROM medicos WHERE id_usuario = :id_usuario");
                $stmt->bindParam(":id_usuario", $user["id"], PDO::PARAM_INT);
                $stmt->execute();
                $medico = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($medico) {
                    // cambie la direccion al control panel
                    header("Location: admin/controlpanel.php?id_medico=" . $medico["id"]);
                    exit();
                } else {
                    $error = "No se encontró un médico asociado a este usuario.";
                }
            } else {
                $error = "Credenciales inválidas.";
            }
        } catch (Exception $e) {
            $error = "Error interno: " . $e->getMessage(); // Mostrar el mensaje de la excepción
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="../css/styleslogin.css">
</head>
<body>
    <div class="login-container">
        <h2>Iniciar sesión</h2>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="POST" action="">
            <label for="nombre_usuario">Usuario:</label>
            <input type="text" name="nombre_usuario" required>
            <br>
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" required>
            <br>
            <button type="submit">Ingresar</button>
        </form>
    </div>
</body>
</html>