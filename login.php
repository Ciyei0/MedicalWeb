<?php
session_start();

// Incluir la conexión desde la carpeta config
require_once 'config/conexion.php'; 

// Verificar que el formulario fue enviado correctamente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = isset($_POST["nombre_usuario"]) ? trim($_POST["nombre_usuario"]) : null;
    $contrasena = isset($_POST["clave"]) ? trim($_POST["clave"]) : null;

    // Verificar que los campos no estén vacíos
    if (empty($usuario) || empty($contrasena)) {
        $error = "Por favor, complete todos los campos.";
    } else {
        try {
            // Verificar que la conexión a la BD existe
            if (!isset($pdo)) {
                throw new Exception("Error de conexión a la base de datos.");
            }

            // Consulta segura con prepared statements
            $stmt = $pdo->prepare("SELECT id, clave FROM usuarios WHERE nombre_usuario = :usuario");
            $stmt->bindParam(":usuario", $usuario, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar si el usuario existe y la contraseña es correcta
            if ($user && password_verify($contrasena, $user["clave"])) {
                $_SESSION["usuario_id"] = $user["id"];
                $_SESSION["nombre_usuario"] = $usuario;
                header("Location: controlpanel.php"); // Redirige al panel de control
                exit();
            } else {
                $error = "Usuario o contraseña incorrectos.";
            }
        } catch (Exception $e) {
            $error = "Error: " . $e->getMessage();
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
    <link rel="stylesheet" href="css/styleslogin.css">

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
