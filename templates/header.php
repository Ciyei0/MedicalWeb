<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEDICALWEB - PANEL DE CONTROL</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> 
    <style>
        body {
            display: flex;
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
        .content {
            margin-left: 250px;
            width: calc(100% - 250px);
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
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h4 class="text-center">MedicalWeb</h4>
        <a href="controlpanel.php">Escritorio</a>
      

    </div>

    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="vistas/controlpanel.php">Gestion de cita y agenda</a>
            </div>
        </nav>

        <div class="container mt-4">
