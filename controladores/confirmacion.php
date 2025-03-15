<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Cita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .confirmation-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            max-width: 500px;
            width: 100%;
            margin: 1rem;
        }

        .alert-success {
            background: #e6ffe6;
            border: none;
            border-radius: 15px;
            padding: 2rem;
            color: #2c3e50;
        }

        .alert-heading {
            color: #28a745;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .confirmation-icon {
            font-size: 3rem;
            color: #28a745;
            margin-bottom: 1.5rem;
        }

        .btn-home {
            background: #3498db;
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2rem;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-block;
            margin-top: 1.5rem;
        }

        .btn-home:hover {
            background: #2980b9;
            transform: translateY(-2px);
            text-decoration: none;
            color: white;
        }
    </style>
</head>
<body>
    <div class="confirmation-card">
        <div class="alert alert-success text-center">
            <div class="confirmation-icon">✓</div>
            <h4 class="alert-heading">Cita Agendada con Éxito</h4>
            <p>Por favor, confirme su cita a través del enlace enviado a su correo electrónico.</p>
            <a href="../index.php" class="btn-home">Volver al Inicio</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>