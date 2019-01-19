<?php
//Validacion de datos POST
$login = '';
$msg = '';
$username  = '';
$mensaje = '';
$noexiste = '';
if (isset($_POST["submit"])) {
	//Se agregan complementos .... 
	include("../Controlador/funciones.php");
	$nameuser = $_POST["nameuser"];
	$password_actual =  $_POST["actual_password"];
	$password_new =  $_POST["new_password"];
	if($nameuser == NULL){
		http_response_code(400);
		$mensaje = "Nombre de usuario obligatorio.";
	}elseif($password_actual == NULL){
		http_response_code(400);
		$mensaje = "Contraseña actual obligatorio.";
	}elseif($password_new == NULL){
		http_response_code(400);
		$mensaje = "Contraseña nueva obligatorio.";
	}else{
		$function =  new funciones();
		$res = $function->actualizarUsuario($nameuser, md5($password_new), md5($password_actual));
		if ($res  == 1) {
			$msg = "La contraseña fue actualizada.";
			$login = '<a href="login.php">Login</a>';
		}elseif($res == 0){
			$mensaje = "La contraseña no se actualizo.";
		}elseif($res == 2){
			$noexiste = "No existe el usuario en nuestra base de datos.";
		}
		
	}
}

if (isset($_GET["username"])) {
	# code...
	$username = $_GET["username"];

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
				<small id="emailHelp" class="form-text text-muted">Es necesario cambiar la contraseña, para poder accesar al portal.</small>	
			</div>
			<div class="row">
				<div class="col-md-4"></div>

				<div id="login" class="col-md-4 formulario">
					<small id="emailHelp" class="form-text text-muted text-danger"><?php echo $mensaje; ?></small>
					<form action="login-reset.php"  method="post" >
					 <div class="form-group">
					    <label for="exampleInputEmail1">Nombre de usuario</label>
					    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="nameuser"  <?php  echo 'value="'.$username .'"'?>  placeholder="Nombre de usuario">
					    <small id="emailHelp" class="form-text text-muted">Ingresa tu nombre de usuario..</small>
					  </div>
					  <div class="form-group">
					    <label for="exampleInputPassword1">Contraseña actual.</label>
					    <input type="password" class="form-control" id="exampleInputPassword1-old"  id="actual_password"  name="actual_password">
					    <small id="emailHelp" class="form-text text-muted">Ingresa la contraseña que se le proporciono por el correo.</small>
					  </div>
					   <div class="form-group">
					    <label for="exampleInputPassword1">Nueva contraseña</label>
					    <input type="password" class="form-control" id="exampleInputPassword1-new" id="new_password" name="new_password" placeholder="Password">
					    <small id="emailHelp" class="form-text text-muted">Aqui puede crear su nueva contraseña ...</small>
					  </div>
					  <button type="submit" id="submit" name="submit" class="btn btn-primary">Guardar</button>
					</form>
					<p class="text-danger"><?php echo $noexiste; ?></p>
					<p class="text-success"><?php echo $msg; ?></p>
				</div>	
				
				<div class="col-md-4 "><p class="text-success"><?php echo $login; ?></p></div>			
			</div>
		</div>
	</body>
</html>