<div class="barra">
    <div class="container-fluid px-3">
        <div class="d-flex align-items-center">
            <img src="imagenes/logo.jpg" alt="Logo de la tienda" class="img-fluid" style="max-height: 80px; margin-bottom: 10px;">
            <h1 class="display-4 ms-3">Clean And Fast</h1>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
        <div class="container-fluid">
        <a class="navbar-brand <?php if ($page == "index") {echo("active");} ?>" href="index.php">Inicio</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <a class="nav-link <?php echo ($page == 'servicios' ? 'active' : ''); ?>" aria-current="page" href="servicios.php">Servicios</a>
            </li>
            </ul>

            <!-- INICIAR SESION -->
            <ul class="navbar-nav">
            <?php
            session_start();
            if (isset($_SESSION["usuario"])) { 
            echo("<a href='dashboard.php' class='nav-link " . ($page == "dashboard" ? "active" : "") . "' aria-current='page'>Dashboard</a>");
            echo("<a href='historialOrdenes.php' class='nav-link " . ($page == "historialOrdenes" ? "active" : "") . "' aria-current='page'>Historial Órdenes</a>");
            echo("<a href='funciones/cerrar_sesion.php' class='nav-link'>Cerrar Sesión</a>");
            } else {
            echo("<a href='login.html' class='nav-link'>Iniciar Sesión</a>");
            }
            ?>
            </ul>
        </div>
        </div>
    </nav>
</div>
<br><br>