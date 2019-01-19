<?php
//Validacion de datos POST
$mensaje = '';
if (isset($_POST["submit"])) {
	//Se agregan complementos .... 
	include("../Controlador/funciones.php");
	$username = $_POST["username"];
	$password =  md5($_POST["passowrd"]);

	if($username == NULL){
		http_response_code(400);
		$mensaje = "Nombre de usuario obligatorio.";
	}elseif($password == NULL){
		http_response_code(400);
		$mensaje = "Contraseña  obligatorio.";
	}else{
		$result = "";
		$function =  new funciones();
		$result = $function->accesoAdmin($username,$password);
		if (count($result) > 0) {
				# code...
			foreach ($result as $usuarios){
				# code...
				if ($usuarios['pasword_old'] == '') {
					header ("Location: https://gormless-subfunctio.000webhostapp.com/MercadoLibre2/Vista/login-reset.php?username=".$username);	
				}else{
					if ($usuarios['user'] ==  $username && $usuarios['password'] == $password) {
						# Respuesta
						session_start();
	                    $_SESSION['user'] = $usuarios['nombre'] .' '. $usuarios['apellido']; 
	                    header ("Location: https://gormless-subfunctio.000webhostapp.com/MercadoLibre2/Vista/logeado.php");					
					}
				}
			}
		}else{
			$mensaje = "Nombre de usuario o contraseña incorrectos";
		}
	}
}
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
		<div class="container-fluid jumbotron" >
			<!-- Contenedor -->
			<div class=" text-center ">
				<h1>Mercado Libre</h1>			
			</div>
			<div class="row">
				<div class="col-md-4"></div>

				<div id="login" class="col-md-4 formulario">
					<form action="login.php"  method="post" >
					 <h5 class="text-left" >Iniciar sesión</h5>
					 <small id="emailHelp" class="form-text text-muted text-danger"><?php echo $mensaje; ?></small>
					  <div class="form-group">
					    <label for="exampleInputEmail1">Nombre de usuario</label>
					    <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp" placeholder="Nombre de usuario">
					    <small id="emailHelp" class="form-text text-muted">Ingresa tu nombre de usuario..</small>
					  </div>
					  <div class="form-group">
					    <label for="exampleInputPassword1">Contraseña</label>
					    <input type="password" class="form-control" id="passowrd" name="passowrd"  >
					    <small id="emailHelp" class="form-text text-muted">Ingresa tu contraseña.</small>
					  </div>
					  <button type="submit" id="submit" name="submit" class="btn btn-primary">Login/Entrar</button>
					</form>
				</div>				
			</div>
		</div>
	</body>
</html>