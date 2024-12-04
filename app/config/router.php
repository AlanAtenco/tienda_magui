<?php
    if(isset($_REQUEST['view'])){
        $vista = $_REQUEST['view'];
    }else{
        $vista = "inicio";
    }
    switch($vista){
        case "inicio":{
            require_once './views/home.php';
            break;
        }
        case "login":{
            require_once './views/login.php';
            break;
        }
        case "registro":{
            require_once './views/registro.php';
            break;
        }
        case "inventario":{
            require_once './views/inventario.php';
            break;
        } 
        case "otros":{
            require_once './views/otro.php';
            break;
        }
        case "caballero":{
            require_once './views/caballero.php';
            break;
        }
        case "dama":{
            require_once './views/dama.php';
            break;
        }
        case "nino":{
            require_once './views/nino.php';
            break;
        }
        case "editar_productos":{
            require_once './views/editar.php';
            break;
        }
        default:{
            require_once './views/error404.php';
            break;
        }
    }
?> 