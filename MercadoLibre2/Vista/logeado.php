<?php
//Validacion de datos POST
	include("../Controlador/funciones.php");
	session_start();
	if (isset($_SESSION['user'])) {
	    $perfil = $_SESSION['user'];
?>
<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
	<title>Routing</title>
	<link 	type="text/css"	href="../Bootstrap3/css/bootstrap.min.css" rel="stylesheet" />
	<script type="text/javascript"  src="../Bootstrap3/js/1.7/jquery-3.3.1.min.js" ></script>
	<script type="text/javascript"  src="../Bootstrap3/js/1.7/bootstrap.min.js" ></script>
	</head>
	<body >
		<nav class="navbar navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button>
                    <a id="principal-main" href="#myPage" class="navbar-brand" >Pagina Web </a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a class="page-scroll" href="#Perfil"><?php echo $perfil; ?></a></li>
                        <li><a class="page-scroll" href="destruir_sesion.php">Salir</a></li>
                    </ul>
                </div>
            </div>
        </nav>
		<div class="container-fluid jumbotron" >
			<!-- Contenedor -->
			<div class=" text-center ">
				<h1>Mercado Libre</h1>	
				<h3>Bienvenid@  	<?php echo ' '.$perfil; ?> </h3>		
			</div>
			<div class="row">
				<div class="col-md-4"></div>

				<div id="login" class="col-md-4 formulario">
				</div>				
			</div>
		</div>
	<?php
    } else {
        echo '<SCRIPT LANGUAGE="javascript">location.href = "login.php";</SCRIPT>';
    }
    ?>
	</body>
</html>