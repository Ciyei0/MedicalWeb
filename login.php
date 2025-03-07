<?php
session_start();

// Conexión a la base de datos
$host = "localhost";
$dbname = "mi_base_de_datos";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST["usuario"]);
    $contrasena = trim($_POST["contrasena"]);

    // Consulta segura con prepared statements
    $stmt = $pdo->prepare("SELECT contrasena FROM usuarios WHERE usuario = :usuario");
    $stmt->bindParam(":usuario", $usuario, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(mode: PDO::FETCH_ASSOC);

    if ($user && password_verify($contrasena, $user["contrasena"])) {
        $_SESSION["usuario"] = $usuario;
        header("Location: dashboard.php"); // Redirige a un panel de control
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Iniciar sesión</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST" action="">
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" required>
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required>
        <br>
        <button type="submit">Ingresar</button>
    </form>
</body>
</html>
