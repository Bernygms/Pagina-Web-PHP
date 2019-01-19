<?php
//Validacion de datos POST
if (isset($_POST["enviar"])) {
	//Se agregan complementos .... 
	include("../Controlador/funciones.php");

	$archivo = $_FILES["archivo"]["name"];
	$archivo_copia = $_FILES["archivo"]["tmp_name"];
	$time = time();
	$fecha =  date("d-m-Y - H:i:s ", $time);
	$archivo_guardado = $fecha.$archivo;

	//echo $archivo . " Esta es l aruta temporal " . $archivo_copia."<br>";
	//Copeamos el archivo CSV a la ruta de trabajo
	if (copy($archivo_copia,$archivo_guardado)) {
		//echo "Se copeo correctamente el archivo temporal a nuestra ruta de trabajo.<br>";
	}else{
		echo "Hubo un error, el archivo no se copeo.<br>";
	}
	if (file_exists($archivo_guardado)) {
		# code...
		$fp = fopen($archivo_guardado, "r"); //Abrimos el archivo
		$rows = 0;
		$contador =0;
		$msg = " ";
		while ($datos = fgetcsv($fp , 100 , ";")) {
			$rows++;
			$function =  new funciones();
			if ($rows > 1) {
				$rest = $function->insertar_datos_csv($datos[0],$datos[1],$datos[2]);
				if ($rest) {
					# code...
				}else{
					echo "No se  inserto el dato de la fila".$rows;
				}
			}
			
		}
		echo "<script> window.location.replace('https://gormless-subfunctio.000webhostapp.com/MercadoLibre2/Vista/success.php'); </script>";
	}else{
		echo "El archivo no esxiste.<br>";
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
					<form  action="index2.php"  class="from" method="POST" enctype="multipart/form-data">
						<h5 class="text-left" >Subir archivo CSV</h5>
						<input type="file" name="archivo" class="from-control" >
						<input type="submit" value="Subir Arhivo" class="from-control" name="enviar">
					</form>
				</div>				
			</div>
		</div>
	</body>
</html>