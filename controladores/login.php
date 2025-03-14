<?php
session_start();

// Incluir la conexión desde la carpeta config
require_once '../config/conexion.php'; 

// Variables de error
$error = "";

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

            // Consulta para obtener datos del usuario y su rol
            $stmt = $pdo->prepare("
                SELECT u.id, u.password_hash, COALESCE(p.permiso, '') as permiso 
                FROM usuarios u
                LEFT JOIN usuario_permiso up ON u.id = up.id_usuario
                LEFT JOIN permiso p ON up.id_permiso = p.id
                WHERE u.nombre_usuario = :usuario
            ");
            $stmt->bindParam(":usuario", $usuario, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($contrasena, $user["password_hash"])) {
                $_SESSION["usuario_id"] = $user["id"];
                $_SESSION["nombre_usuario"] = $usuario;

                // Verificar si tiene un rol asignado
                if (empty($user["permiso"])) {
                    $error = "No tiene un rol asignado. Contacte al administrador.";
                } else {
                    $_SESSION["rol"] = $user["permiso"]; // Guardamos el rol en sesión

                    // Redirección según el rol
                    switch ($user["permiso"]) {
                        case "medico":
                            // Obtener el ID del médico
                            $stmtMedico = $pdo->prepare("SELECT id FROM medicos WHERE id_usuario = :id_usuario");
                            $stmtMedico->bindParam(":id_usuario", $user["id"], PDO::PARAM_INT);
                            $stmtMedico->execute();
                            $medico = $stmtMedico->fetch(PDO::FETCH_ASSOC);

                            if ($medico) {
                                $_SESSION["id_medico"] = $medico["id"];
                                header("Location: ../vistas/cita_medicos/controlpanel.php?id_medico=" . $medico["id"]);
                                exit();
                            } else {
                                $error = "No se encontró un médico asociado a este usuario.";
                            }
                            break;
                        
                        case "admin":
                            header("Location: ../vistas/cita_admin/controlpanel.php");
                            exit();

                        case "recepcionista":
                            header("Location: ../vistas/cita_admin/controlpanel.php");
                            exit();

                        default:
                            $error = "Rol no reconocido.";
                            break;
                    }
                }
            } else {
                $error = "Credenciales inválidas.";
            }
        } catch (Exception $e) {
            error_log("Error de login: " . $e->getMessage()); // Guardar el error en logs
            $error = "Error interno. Intente nuevamente.";
        }
    }
}

// Incluir la vista del login
include '../vistas/login_view.php';

?>
