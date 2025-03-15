<?php
require_once '../../config/conexion.php';

// Obtener la lista de especialidades
$stmt = $pdo->query("SELECT id, nombre FROM Especialidades");
$especialidades = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Cita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }

        .appointment-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin: 2rem auto;
            max-width: 900px; /* Aumentado para las dos columnas */
        }

        .form-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 2rem;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            padding: 0.75rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }

        .btn-primary {
            background: #3498db;
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }

        .form-group label {
            color: #2c3e50;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .alert {
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="appointment-card">
        <h2 class="form-title text-center">Agendar Cita</h2>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>
        <form action="../../controladores/procesar_cita.php" method="POST">
            <div class="row">
                <!-- Columna Izquierda -->
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="apellido">Apellido</label>
                        <input type="text" id="apellido" name="apellido" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="telefono">Teléfono</label>
                        <input type="text" id="telefono" name="telefono" class="form-control" required>
                    </div>
                  
                    <div class="form-group mb-3">
                        <label for="tipo_identificacion">Tipo de Identificación</label>
                        <select id="tipo_identificacion" name="tipo_identificacion" class="form-control" required>
                            <option value="">Seleccione el tipo de identificación</option>
                            <option value="cedula">Cédula</option>
                            <option value="pasaporte">Pasaporte</option>
                        </select>
                    </div>
                    <div class="form-group mb-3" id="cedula-group" style="display: none;">
                        <label for="cedula">Cédula</label>
                        <input type="text" id="cedula" name="cedula" class="form-control" maxlength="13">
                    </div>
                    <div class="form-group mb-3" id="pasaporte-group" style="display: none;">
                        <label for="pasaporte">Pasaporte</label>
                        <input type="text" id="pasaporte" name="pasaporte" class="form-control">
                    </div>
    
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            $('#tipo_identificacion').on('change', function() {
                                var tipo = $(this).val();
                                if (tipo === 'cedula') {
                                    $('#cedula-group').show();
                                    $('#pasaporte-group').hide();
                                } else if (tipo === 'pasaporte') {
                                    $('#cedula-group').hide();
                                    $('#pasaporte-group').show();
                                } else {
                                    $('#cedula-group').hide();
                                    $('#pasaporte-group').hide();
                                }
                            });

                            $('#cedula').on('input', function() {
                                var value = $(this).val().replace(/\D/g, '');
                                if (value.length > 3 && value.length <= 10) {
                                    value = value.replace(/(\d{3})(\d{3})(\d{3})/, '$1-$2-$3');
                                } else if (value.length > 10) {
                                    value = value.replace(/(\d{3})(\d{7})(\d{1})/, '$1-$2-$3');
                                }
                                $(this).val(value);
                            });
                        });
                    </script>
    
                </div>

                <!-- Columna Derecha -->
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="especialidad">Especialidad</label>
                        <select id="especialidad" name="especialidad" class="form-control" required>
                            <option value="">Seleccione una especialidad</option>
                            <?php foreach ($especialidades as $especialidad): ?>
                                <option value="<?php echo $especialidad['id']; ?>">
                                    <?php echo $especialidad['nombre']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="medico">Médico</label>
                        <select id="medico" name="medico" class="form-control" required>
                            <option value="">Seleccione un médico</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="fecha">Fecha</label>
                        <input type="date" id="fecha" name="fecha" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="hora">Hora</label>
                        <select id="hora" name="hora" class="form-control" required>
                            <option value="">Seleccione una hora</option>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="observaciones">Observaciones</label>
                        <textarea id="observaciones" name="observaciones" class="form-control" rows="3"></textarea>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Agendar Cita</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#especialidad').on('change', function() {
                var especialidadId = $(this).val();
                if (especialidadId) {
                    $.ajax({
                        url: '../../controladores/obtener_medicos.php',
                        type: 'GET',
                        data: { especialidad_id: especialidadId },
                        success: function(response) {
                            $('#medico').html(response);
                        }
                    });
                } else {
                    $('#medico').html('<option value="">Seleccione un médico</option>');
                }
            });

            $('#medico, #fecha').on('change', function() {
                var medicoId = $('#medico').val();
                var fecha = $('#fecha').val();
                if (medicoId && fecha) {
                    $.ajax({
                        url: '../../controladores/obtener_horarios.php',
                        type: 'GET',
                        data: { medico_id: medicoId, fecha: fecha },
                        success: function(response) {
                            $('#hora').html(response);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>