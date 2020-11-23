<?php 

require_once 'util/sesion.php';
require_once 'util/validar.php';
require_once 'models/global.php';
require_once 'models/conexion/conexion.php';

require_once 'controllers/view/ViewCtrl.php';
require_once 'models/view/ViewMdl.php';


if (!sesionCreada() || (isset($_GET["action"]) && $_GET["action"]=="sesionclose")) {

    // remove all session variables
    session_unset();

    // destroy the session
    session_destroy();

    header("location: ../");

}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>SISOFT POS</title>
        <?php include_once 'views/fragmentos/vendor.php'; ?>

        <style type="text/css">
            /*.dropdown:hover>.dropdown-menu {
                display: block;
            }*/
        </style>
        <link rel="stylesheet" type="text/css" href="views/vendor/DataTables-1.10.22/css/jquery.dataTables.min.css">
        <script type="text/javascript" src="views/vendor/DataTables-1.10.22/js/jquery.dataTables.min.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-md bg-dark navbar-dark">
            <a class="navbar-brand" href="#">SISOFT POS</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav  mr-auto">

                    <?php if(esAdmin()) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"  data-toggle="tooltip" data-placement="top" title="Sucursales">
                            <img src="views/img/icons/sucursal-blanca.png" alt="Sucursales" class="img-fluid" width="20" height="20"> <!-- Sucursales -->
                        </a>
                        <div class="dropdown-menu">
                            <h4 class="dropdown-header">Sucursales</h4>
                            <a class="dropdown-item" href="sucursales">Lista</a>
                            <a class="dropdown-item" href="sucursal">Agregar</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" data-toggle="tooltip" title="Usuarios">
                            <img src="views/img/icons/usuario-blanco.png" alt="Usuarios" class="img-fluid" width="20" height="20">
                        </a>
                        <div class="dropdown-menu">
                            <h4 class="dropdown-header">Usuarios</h4>
                            <a class="dropdown-item" href="usuarios">Lista</a>
                            <a class="dropdown-item" href="usuario">Agregar</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" data-toggle="tooltip" title="Proveedores">
                            <img src="views/img/icons/carro-blanco.png" alt="Proveedores" class="img-fluid" width="20" height="20">
                        </a>
                        <div class="dropdown-menu">
                            <h4 class="dropdown-header">Proveedor</h4>
                            <a class="dropdown-item" href="proveedores">Lista</a>
                            <a class="dropdown-item" href="proveedor">Agregar</a>
                        </div>
                    </li>
                    <?php } ?>
                    <!--li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            Menu 3
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Link 1</a>
                            <a class="dropdown-item" href="#">Link 2</a>
                            <a class="dropdown-item" href="#">Link 3</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            Menu 4
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Link 1</a>
                            <a class="dropdown-item" href="#">Link 2</a>
                            <a class="dropdown-item" href="#">Link 3</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            Menu 5
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Link 1</a>
                            <a class="dropdown-item" href="#">Link 2</a>
                            <a class="dropdown-item" href="#">Link 3</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            Menu 6
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Link 1</a>
                            <a class="dropdown-item" href="#">Link 2</a>
                            <a class="dropdown-item" href="#">Link 3</a>
                        </div>
                    </li-->
                </ul>
                <ul class="navbar-nav my-2 my-lg-0">                    
                    <!-- Dropdown -->
                    <li class="nav-item dropdown dropleft float-right">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            Perfil
                        </a>
                        <div class="dropdown-menu">
                            <div class="dropdown-header">Datos de perfil</div> 
                            <a class="dropdown-item" href="#">Link 1</a>
                            <a class="dropdown-item" href="#">Link 2</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="sesionclose">Cerrar Sesión</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container-fluid pt-3 pl-4">
        <!-- inicio del contenido -->
        <?php 

        $view =new ViewCtrl();
        $view->getViewAdminCtrl();

        ?>
        <!-- fin del contenido -->
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    </body>
</html>