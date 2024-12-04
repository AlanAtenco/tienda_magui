<?php 
$sesionIniciada = isset($_SESSION['usuario']);
$esAdmin = isset($_SESSION['rol']) && $_SESSION['rol'] === 'administrador';  // Asegúrate de que la variable de sesión 'rol' está definida y tiene el valor 'admin' para los administradores
?>
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand">
            <h1 style="color: #FF1493;">
                Boutigalos Magui <i class="bi bi-bag-heart"></i>
            </h1>
        </a>

        <!-- Botón para colapsar -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenido del Navbar -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <?php if (!$sesionIniciada): ?>
                <!-- Barra de búsqueda -->
                <div class="d-flex align-items-center ms-auto">
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Buscar por Producto" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Buscar</button>
                    </form>
                </div>
            <?php endif; ?>

            <?php if ($sesionIniciada): ?>
                <!-- Menú desplegable de categorías -->
                <div class="nav-item dropdown ms-3">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categorías
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="dama">Dama</a></li>
                        <li><a class="dropdown-item" href="caballero">Caballero</a></li>
                        <li><a class="dropdown-item" href="nino">Niños</a></li>
                        <li><a class="dropdown-item" href="otros">Otros</a></li>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Botones de inicio de sesión y navegación -->
            <ul class="navbar-nav ms-auto">
                <?php if (!$sesionIniciada): ?>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-primary me-2" href="inicio">
                            <i class="bi bi-house"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-primary me-2" href="login">
                            <i class="bi bi-person"></i> Iniciar sesión
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Mostrar el botón de inventario solo si es admin -->
                <?php if ($sesionIniciada && $esAdmin): ?>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-primary me-2" href="inventario">
                            <i class="bi bi-box"></i> Inventario
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($sesionIniciada): ?>
                    <li class="nav-item">
                        <button type="button" class="btn btn-danger" id="btn_cerrar">Cerrar sesión</button>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
