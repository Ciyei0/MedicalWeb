<?php
require_once '../config/conexion.php';
//convertir contraseñas a hash
try {
   
    $stmt = $pdo->query("SELECT id, password_hash FROM usuarios");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($usuarios as $usuario) {
        $id = $usuario['id'];
        $contrasena = $usuario['password_hash']; 

        
        if (strlen($contrasena) < 60) {
            // Generar el hash
            $hash = password_hash($contrasena, PASSWORD_BCRYPT);

            // Actualizar la base de datos
            $update = $pdo->prepare("UPDATE usuarios SET password_hash = :hash WHERE id = :id");
            $update->bindParam(":hash", $hash, PDO::PARAM_STR);
            $update->bindParam(":id", $id, PDO::PARAM_INT);
            $update->execute();

            echo "Contraseña de usuario ID $id actualizada correctamente.<br>";
        } else {
            echo "El usuario ID $id ya tiene una contraseña segura.<br>";
        }
    }

    echo "Proceso completado.";
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
