<?php
session_start();
require_once 'pdo_connection.php';
print_r($_GET['token']);

// Comprobamos la caducidad del token
$ahora = new DateTime();
$ahora = $ahora->format('Y-m-d H:i:s');


if (!$_GET['token']) {
    header ('Location: index.php');
    exit();
}

// Comprobar si el token existe en la tabla temporal
$select = "SELECT * FROM temporal WHERE tokenRegistro = :token";
$prep = $conn->prepare($select);
$prep->bindParam(':token', $_GET['token'], PDO::PARAM_STR);
$prep->execute();

// Comprobamos si el usuario ha sido encontrado con un match del token
$usuario = $prep->fetch(PDO::FETCH_ASSOC);
if (!$usuario) {
    header ('Location: index.php');
    exit();
}   

if ($usuario['tokenCaducidad'] < $ahora) {
   
    header ('Location: index.php?formulario=token-caducado');
    exit();
}



$insert = "INSERT INTO usuarios (usuario, email, telefono, password)
           VALUES (:usuario, :email, :telefono, :password)";
$prep = $conn->prepare($insert);
$prep->bindParam(':usuario', $usuario['usuario'], PDO::PARAM_STR);
$prep->bindParam(':email', $usuario['email'], PDO::PARAM_STR);
$prep->bindParam(':telefono', $usuario['telefono'], PDO::PARAM_STR);
$prep->bindParam(':password', $usuario['password'], PDO::PARAM_STR);
$prep->execute();

// Eliminamos el usuario de la tabla temporal
$delete = "DELETE FROM temporal WHERE tokenRegistro = :token";
$prep = $conn->prepare($delete);
$prep->bindParam(':token', $_GET['token'], PDO::PARAM_STR);
$prep->execute();

// Eliminamos los tokens caducados de la tabla temporal
$delete = "DELETE FROM temporal WHERE tokenCaducidad < :token";
$prep = $conn->prepare($delete);
$prep->bindParam(':token', $ahora, PDO::PARAM_STR);
$prep->execute();

// Redirigir al usuario a la página de inicio de sesión
$_SESSION['nombre-usuario'] = $usuario['usuario'];
header('Location:index.php?formulario=login&mensaje=registro_ok');



$conn = null; // Cerramos la conexión a la base de datos
$prep = null; // Cerramos la sentencia preparada

?>