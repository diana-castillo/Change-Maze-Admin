<?php
    include 'php/jugador.php'; 
    include 'php/usuario.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChangeMaze Admin</title>
    <link rel="icon" href="modulos/icono.png" type="image">

    <!-- Agregar todos las bibliotecas necesitadas -->

     <!-- jquery -->
    <script src="libs/js/jquery/jquery.min.js"></script>

    <!-- Bootstrap v5.1.3 CDNs -->
    <link rel="stylesheet" href="libs/css/bootstrap/bootstrap.min.css"/>
    <script src="libs/js/bootstrap/bootstrap.bundle.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="libs/css/datatables/jquery.dataTables.css"/>
    <link rel="stylesheet" href="libs/css/datatables/responsive.bootstrap.min.css"/>
    <script src="libs/js/datatables/jquery.dataTables.js"></script>
    <script src="libs/js/datatables/dataTables.responsive.min.js"></script>
    <script src="libs/js/datatables/responsive.bootstrap.min.js"></script>
    <!-- DataTables export data -->
    <script src="libs/js/datatables_export/dataTables.buttons.min.js"></script>
    <script src="libs/js/datatables_export/jszip.min.js"></script>
    <script src="libs/js/datatables_export/buttons.html5.min.js"></script>
    <script src="libs/js/datatables_export/buttons.print.min.js"></script>
    <link rel="stylesheet" href="libs/css/datatables_export/buttons.dataTables.min.css"/>

    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"/>

    <!-- Chart.js -->
    <script src="libs/js/chartjs/chart.min.js"></script>

    <!-- w cluster -->
    <!-- https://www.npmjs.com/package/w-cluster -->
    <script src="libs/js/w-cluster/w-cluster.umd.js"></script>

    <!-- Sweet Alert 2 -->
    <script src="libs/js/sweetalert2/sweetalert2.js"></script>

    <script src="modulos/funciones.js"></script>

</head>
<body style="background: #f8fafc;">
    <?php
        if (isset($_GET["ruta"])){
                
            if ($_GET["ruta"] == 'login')
                include 'modulos/login.php';
            
            if ($_GET["ruta"] == 'inicio')
                include 'modulos/inicio.php';

            if ($_GET["ruta"] == 'completos')
                include 'modulos/completos.php';
            
            if ($_GET["ruta"] == 'incompletos')
                include 'modulos/incompletos.php';
            
            if ($_GET["ruta"] == 'usuarios')
                include 'modulos/usuarios.php';

            if($_GET["ruta"] == 'salir')
                include 'modulos/salir.php';
        }else{
            include 'modulos/login.php';
        }
    ?>
</body>
</html>