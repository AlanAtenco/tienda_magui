<?php 
    require_once "./app/config/dependencias.php";
    session_start();
    require_once "./app/config/rutas.php";
?>
 
<!DOCTYPE html>
<html lang="es">
    <?php require_once './views/nav.php';?>  
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=CSS.'b5.css'?>">
    <link rel="stylesheet" href="<?=CSS.'main.css'?>">
    <link rel="stylesheet" href="<?=CSS.'font_awesome/all.css'?>">
    <link rel="stylesheet" href="<?=CSS.'dt.css'?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=CSS.'otro.css'?>">
    <link rel="stylesheet" href="<?=CSS.'home.css'?>">
    <script src="<?=JS."font_awesome/all.js"?>"></script>
    <script src="<?=JS."jquery.js"?>"></script>
    <script src="<?=JS."popper.js"?>"></script>
    <script src="<?=JS."b5.js"?>"></script>
    <script src="<?=JS."dt.js"?>"></script>
    <title>SUITS</title>
</head>
<body>
    <?php require_once './app/config/router.php';?>  
    <?php 
        // Ocultar el footer solo en las páginas login e inventario
        $pagina_actual = basename($_SERVER['REQUEST_URI']);
        if ($pagina_actual !== 'login' && $pagina_actual !== 'inventario') : 
    ?>
        <?php require_once("./views/footer.php") ?>
    <?php endif; ?>
    
    <script src="./public/js/cerrar_sesion.js"></script>
    <script src="./public/js/sweetAlert.js"></script>
    <script src="./public/js/main.js"></script>
</body>

</html>


