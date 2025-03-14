
<?php
// Verificar si existe el id_medico en sesión o en la URL
if (isset($_SESSION["id_medico"])) {
    $id_medico = $_SESSION["id_medico"];
} elseif (isset($_GET['id_medico'])) {
    $id_medico = intval($_GET['id_medico']);
} else {
    echo "No se proporcionó un ID de médico.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEDICALWEB - PANEL DE CONTROL</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #2c3e50; 
            height: 100vh;
            position: fixed;
            padding-top: 20px;
            color: white;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 30px;
        }
        .sidebar a:hover {
            background-color: #1a252f;
        }
        .sidebar a.active {
            background-color: #3498db; /* Color para el enlace activo */
            font-weight: bold;
        }
        .content {
            margin-left: 250px;
            width: calc(100% - 250px);
            flex: 1;
        }
        .navbar {
            background-color: #3498db; 
        }
        .navbar-brand {
            color: white !important;
        }
        .footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 10px;
            width: 100%;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center">MedicalWeb</h4>
        <a href="controlpanel.php?id_medico=<?php echo $id_medico; ?>" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'controlpanel.php') ? 'active' : ''; ?>">Escritorio</a>
        <a href="/medicalweb/vistas/cita_medicos/ver_citas.php?id_medico=<?php echo $id_medico; ?>" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'ver_citas.php') ? 'active' : ''; ?>">Citas</a>
    </div>

    <!-- Contenido Principal -->
    <div class="content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="controlpanel.php?id_medico=<?php echo $id_medico; ?>">Gestión de citas y agenda</a>
            </div>
        </nav>

        <!-- El contenido dinámico se incluirá aquí -->