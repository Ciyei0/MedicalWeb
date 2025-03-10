<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cita Confirmada</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .confirmation-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 2rem;
            max-width: 500px;
            margin: auto;
        }
        .success-icon {
            font-size: 3rem;
            color: #28a745;
            margin-bottom: 1rem;
        }
        .btn-home {
            background-color: #28a745;
            border: none;
            padding: 0.5rem 2rem;
            border-radius: 25px;
            transition: transform 0.2s;
        }
        .btn-home:hover {
            transform: translateY(-2px);
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="confirmation-card text-center">
            <div class="success-icon">✓</div>
            <h4 class="mb-3 text-success">Cita Confirmada con Éxito</h4>
            <p class="text-muted mb-4">Su cita ha sido confirmada. Gracias por utilizar nuestro servicio.</p>
            <a href="index.php" class="btn btn-home text-white">Volver al Inicio</a>
        </div>
    </div>
</body>
</html>