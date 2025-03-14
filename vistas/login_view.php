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
        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="POST" action="../controladores/login.php">
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