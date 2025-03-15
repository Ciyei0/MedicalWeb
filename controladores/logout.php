<?php
session_start(); // Asegura que la sesión está iniciada

// Verificar si la sesión está activa
if (isset($_SESSION["usuario_id"])) {
    // Eliminar todas las variables de sesión
    $_SESSION = array();

    // Si se usa una cookie de sesión, se elimina
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Destruir la sesión completamente
    session_destroy();
}

 //redirigir a login
echo '<script>
        window.location.href = "../vistas/login_view.php";
      </script>';
exit();
?>
