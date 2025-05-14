<?php

session_start();
require_once 'pdo_connection.php';

//VALIDACIONES

//Verificar lo que llega a insert_user.php
//-para que no se puedan inyectar datos directamente-
//1- Si llega algo y ese algo se manda desde $_POST
$verificarUsuario = isset($_POST['usuario']) && $_POST['usuario'];
$verificarPassword = isset($_POST['password']) && $_POST['password'];


if(!$verificarUsuario || !$verificarPassword) {
    $_SESSION['error'] = true;
    header ('Location: crear-usuario.php');
    exit();
}

//2- Quitar los espacios vacios y comprobar que no llegan vacios los campos
$usuario = trim($_POST['usuario']);
$password = trim($_POST['password']);


if (empty($usuario) || empty($password)) {
    $_SESSION['error'] = true;
    header ('Location: crear-usuario.php');
    exit();
}

//3- Evitar que se introduzca codigo malicioso
$usuario = htmlentities($usuario, ENT_QUOTES, 'UTF-8');
$password = htmlentities($password, ENT_QUOTES, 'UTF-8');


// BUSCAMOS QUE EL USUARIO EXISTA PARA VALIDARLO
$select = "SELECT * FROM usuarios WHERE usuario = :usuario";
// BUSCA CON EL SELECT EL USUARIO ESCRITO
$stmt = $conn->prepare($select);
$stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
$stmt->execute();

$usuarioExistente = $stmt->fetch(PDO::FETCH_ASSOC);
//SI la variable $usuarioExistente no tiene valor, devolvemos error y llevamos al usuario a la pagina index para comenzar de nuevo.
if (!$usuarioExistente) {
    $_SESSION['errorUserInexistente'] = true;
    header ('Location: crear-usuario.php');
    exit();
} 


//4- VERIFICAMOS CONTRASEÑA

if (!password_verify($password, $usuarioExistente['password'])) {
    $_SESSION['errorUserInexistente'] = true;
    header ('Location: index.php');
    exit();
}

// echo "Todo OK!";
// 13-05 -> Guardamos el idUsuario en la sesion para usarlo en la pagina colores/index.php
$_SESSION['idUsuario'] = $usuarioExistente['idUsuario'];
$_SESSION['usuario'] = $usuarioExistente['usuario'];
// 13-05 -> Redirigimos a la pagina colores/index.php ya que estamos juntando las conexiones en pdo_bind_connection.php
header('Location: 08_EJERCICIO_GESTOR/index.php');