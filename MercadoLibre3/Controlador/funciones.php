<?php
include("../Modelo/conexion.php");
include("../Lib/class.phpmailer.php");
include("../Controlador/constantes.php");
class funciones{
	protected $db;
	public function __construct(){
		$this->db = DB();
	}
	public function  insertar_datos_csv($nombre,$apellido, $correo){
		 $cadena = trim($nombre);
		 $user = $cadena.rand(5,50);
		 $bytes = random_bytes(5);
		 $clave = bin2hex($bytes);

		 $mail = new PHPMailer;
		 //Configuracion de phpmail
		 $mail->IsSMTP();
		 $mail->Host = 'smtp.gmail.com';
		 $mail->SMTPAuth = true;
		 $mail->Username = 'berny0094@gmail.com';
		 $mail->Password = EMAIL_PASSWORD;
		 $mail->SMTPSecure = 'tls';
		 $mail->Port = 587;

		 //Configuracion del correo a enviar
		 $mail->setFrom('mercadolibre01@gmail.com');
		 $mail->AddAddress($correo);
		 $mail->WordWrap = 50;
		 $mail->IsHTML(true);
		 $mail->Subject = 'Correo CSV, tu cuenta se creo correctamente';
		 $message_body = '<p>Hola <strong>'.$nombre. ' '.$apellido.'</strong>,¡ Gracias por la espera, ya terminamos de crear tu cuenta en nuestro portal web, aqui abajo puedes encontrar tus accesos..</P>';
		 $message_body .= '<p>Usuario: <strong>'.$user.'</strong></p>';
		 $message_body .= '<p>Contraseña: <strong>'.$clave.'</strong></p><br><br><hr>';
		 $message_body .= '<p>¡Casi estás list@! Simplemente verifica tu datos he ingresa al portal.</p>';
		  $message_body .= '<p><a href="https://gormless-subfunctio.000webhostapp.com/MercadoLibre2/Vista/login.php">Clic aquí.</a></p>';
		 $mail->Body = $message_body;

		 if($mail->Send()){
		 	//$password = password_hash($clave, PASSWORD_BCRYPT, ['cost' => 11]);
		 	$password = md5($clave);
			try {
				$query = $this->db->prepare("INSERT INTO usuarios(nombre,apellido,correo,user,password) VALUES (?,?,?,?,?)");
				$query->execute(array($nombre,$apellido, $correo, $user, $password)); 
				return $query;
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
		 }
	}

	public function accesoAdmin($user,$password){
		$query = $this->db->prepare("SELECT nombre,apellido,correo,user,password,pasword_old FROM usuarios WHERE user  = :username AND password = :password");
		$query->bindParam(":username", $user, PDO::PARAM_STR);
        $query->bindParam(":password", $password, PDO::PARAM_STR);
		$query->execute();
		$row = $query-> fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}
	public function actualizarUsuario($user , $password_new, $password_actual){
		$id = '';
		$data1 = [
		    'user' => $user,
		    'password_actual' => $password_actual,
		];
		$query = $this->db->prepare("SELECT id FROM usuarios WHERE user  = :user AND password = :password_actual");
		$query->execute($data1);
		$res = $query-> fetchAll(PDO::FETCH_ASSOC);
		if(is_array($res)){
		    foreach($res as $per){
		         $id = $per['id'];
		    }
		    if ($id > 0) {
	        	$data = [
		        	'id' => $id,
				    'user' => $user,
				    'password_actual' => $password_actual,
				    'password_new' => $password_new,
				];
				$sql = "UPDATE usuarios SET  password=:password_new , pasword_old=:password_actual WHERE id=:id and user=:user";
				$stmt = $this->db->prepare($sql);
				$Result1 = $stmt->execute($data);
				if ($Result1 == TRUE) { 
					return 1; 
				}else { 
					return 0;
				}
	        }else{
	        	return 2;
	        }
		}
        
	}
}

?>