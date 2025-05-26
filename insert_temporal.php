<?php
error_reporting(0);

session_start();
require_once 'pdo_connection.php';

// print_r($_POST);

//VALIDACIONES

//-para que no se puedan inyectar datos directamente-
//1- isset($_POST['x']): Verifica si existe el índice 'usuario' en el array $_POST (es decir, si se envió el campo 'usuario' por POST).
//2- $_POST['x']: Evalúa si el valor enviado en 'usuario' no es vacío o falso.
$verificarUsuario = isset($_POST['usuario']) && $_POST['usuario'];
$verificarPassword = isset($_POST['password']) && $_POST['password'];
$verificarPassword2 = isset($_POST['password2']) && $_POST['password2'];

if(!$verificarUsuario || !$verificarPassword || !$verificarPassword2) {
    $_SESSION['error'] = true;
    header ('Location: crear-usuario.php');
    exit();
}

//2- Quitar los espacios vacios y comprobar que no llegan vacios los campos
$usuario = trim($_POST['usuario']);
$password = trim($_POST['password']);
$password2 = trim($_POST['password2']);
$email = trim($_POST['email']);
$telefono = trim($_POST['telefono']);

if (empty($usuario) || empty($password) || empty($password2)) {
    $_SESSION['error'] = true;
    header ('Location: crear-usuario.php');
    exit();
}

//3- Evitar que se introduzca codigo malicioso
$usuario = htmlentities($usuario, ENT_QUOTES, 'UTF-8');
$password = htmlentities($password, ENT_QUOTES, 'UTF-8');
$password2 = htmlentities($password2, ENT_QUOTES, 'UTF-8');
$email = htmlentities($email, ENT_QUOTES, 'UTF-8');
$telefono = htmlentities($telefono, ENT_QUOTES, 'UTF-8');


//4- Comprobar si el password 1 y 2 coinciden
if ($password !== $password2) {
    $_SESSION['error'] = true;
    header ('Location: crear-usuario.php');
    exit();
}

// SINTAXIS ALTERNATIVA A 
// "SELECT * FROM usuarios WHERE usuario = ?"
$select = "SELECT * FROM usuarios WHERE usuario = :usuario";
// BUSCA CON EL SELECT EL USUARIO ESCRITO
$stmt = $conn->prepare($select);
$stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
$stmt->execute();
//SI DEVUELVE ALGO, LA VARIABLE $usuarioExistente TENDRÁ UN VALOR, POR LO CUAL LE DAREMOS ERROR.
$usuarioExistente = $stmt->fetch(PDO::FETCH_ASSOC);
if ($usuarioExistente) {
    $_SESSION['errorUser'] = true;
    header ('Location: crear-usuario.php');
    exit();
} 

//Encriptar la contraseña
$hash = password_hash($password, PASSWORD_DEFAULT);
// 22/05 AÑADIMOS TOKEN DE VERIFICACION PARA AÑADIR A LA TABLA TEMPORAL
$token = bin2hex(random_bytes(64));

$caducidad = new DateTime();
$caducidad->add(new DateInterval('PT2H'));
$caducidad = $caducidad->format('Y-m-d H:i:s');    //caducidad de dos horas

//REALIZAMOS EL INSERT
$insert = "INSERT INTO temporal (usuario, password, email, telefono, tokenRegistro, tokenCaducidad) VALUES (:usuario, :password, :email, :telefono, :token, :caducidad)";
$stmt = $conn->prepare($insert);
$stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
$stmt->bindParam(':password', $hash, PDO::PARAM_STR);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
$stmt->bindParam(':token', $token, PDO::PARAM_STR);
$stmt->bindParam(':caducidad', $caducidad, PDO::PARAM_STR);
$stmt->execute();

// echo "Usuario insertado correctamente <br>";

// header('Location: index.php');

// echo "De momento todo va bien";

// PREPARAMOS LA VARIABLE bodyAsunto, DONDE DEFINIMOS EL CUERPO DEL EMAIL. 
// EL LINK EN ESTE CASO ES LA RUTA QUE TENEMOS DENTRO DE LOCALHOST
$bodyAsunto = 
"<h1> Email de confirmación para $usuario</h1><br>
<p> Te enviamos el enlace para que puedas acceder a Favicolores:</p><br>
<a href='http://localhost/01_phpBasico/10_SesionGestor/registro.php?token=$token'> HAZ CLICK AQUI PARA CONFIRMAR </a><br>
<p> Si no has intentado acceder a la aplicación, puedes ignorar este correo.</p><br>";


include 'email_validacion.php';

header('location: index.php?formulario=revisar');