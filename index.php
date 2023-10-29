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

    <!-- Agregar todos las bibliotecas necesitadas -->

     <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <!-- Bootstrap v5.1.3 CDNs -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap.min.css"/>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap.min.js"></script>
    <!-- DataTables export data -->
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.1/css/buttons.dataTables.min.css">

    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"/>

    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

    <!-- w cluster -->
    <!-- https://www.npmjs.com/package/w-cluster -->
    <script src="https://cdn.jsdelivr.net/npm/w-cluster@1.0.17/dist/w-cluster.umd.js"></script>

    <!-- Sweet Alert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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