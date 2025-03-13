<?php 
include '../templates/header.php';

// Verificar si el usuario ha iniciado sesión
// if (!isset($_SESSION['usuario'])) {
//     header("Location: login_view.php");
//     exit();
// }

// Obtener el rol del usuario
// $rol = $_SESSION['rol'] ?? 'invitado';

?>

<h1>Bienvenido a MedicalWeb</h1>
<p>Usuario: <?php echo $_SESSION['usuario'] ?? 'Invitado'; ?></p>

<!-- Aquí puedes habilitar la vista según el rol -->

<?php if ($rol === 'medico'): ?>
    <h2>Agenda de Citas</h2>
    <p>Aquí se mostrarán las citas del médico.</p>
<?php elseif ($rol === 'recepcionista'): ?>
    <h2>Gestión de Citas</h2>
    <p>Resumen de citas programadas y opciones para gestionarlas.</p>
<?php elseif ($rol === 'administrador'): ?>
    <h2>Estadísticas del Sistema</h2>
    <p>Gráficos y reportes generales del sistema.</p>
<?php endif; ?>


<a href="logout.php">Cerrar Sesión</a>

<?php 
include '../templates/footer.php'; 
?>