<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <!-- Header -->
    <header class="d-flex justify-content-between align-items-center p-3 bg-light">
        <div class="logo">MedicalWeb</div>
        <nav>
            <ul class="list-unstyled d-flex gap-3">
                <li><a href="#sobre">Sobre Nosotros</a></li>
                <li><a href="#contacto">Contacto</a></li>
                <li><a href="#servicios">Servicios</a></li>
            </ul>
        </nav>
        <div>
            <button class="btn btn-primary "  onclick="window.location.href='vistas/citas/cita.php'">Agendar Cita</button>
            <button class="btn btn-secondary"  onclick="window.location.href='vistas/login.php'" >Iniciar Sesión</button>
            
        </div>
    </header>

    <!-- Carrusel -->
    <section id="carouselBanner" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/banner1.jpg" class="d-block w-100" alt="Imagen 1">
                <div class="carousel-caption">
                    <h1>VEN A CONOCER NUESTRO CENTRO DE CONTACTO</h1>
                    <a href="vistas/citas/cita.php" class="btn btn-primary">Agenda tu cita</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/banner1.jpg" class="d-block w-100" alt="Imagen 2">
                <div class="carousel-caption">
                    <h1>ATENCIÓN PERSONALIZADA</h1>
                    <a href="vistas/citas/cita.php" class="btn btn-primary">Agenda tu cita</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/banner1.jpg" class="d-block w-100" alt="Imagen 3">
                <div class="carousel-caption">
                    <h1>SERVICIO RÁPIDO Y EFECTIVO</h1>
                    <a href="vistas/citas/cita.php" class="btn btn-primary">Agenda tu cita</a>
                </div>
            </div>
        </div>

        <!-- Controles del carrusel -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselBanner" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselBanner" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
