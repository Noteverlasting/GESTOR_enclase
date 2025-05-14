<?php

// SEGURIDAD PHP --  Creamos un inicio de sesion
session_start();
// SEGURIDAD PHP -- if para que compare que el numero generado en sessionToken por $_SESSION sea el mismo que el sessionToken generado por $_POST
// SEGURIDAD PHP -- Si no se ha accedido por el formulario (que devuelve el mismo valor de sessionToken), se para la ejecucion del script.
if (!hash_equals($_SESSION ['sessionToken'], $_POST['sessionToken'])){
    die("Token inválido");
}
// SEGURIDAD PHP -- HoneyPot
if (!empty($_POST['web'])) {
    die("Bot detectado");
}

// Llamamos al fichero de conexión
require_once '../pdo_connection.php';

// DECLARAMOS UNA VARIABLE CON CONDICION TERNARIA PARA QUE fechaFinal SEA NULL SI NO TIENE VALOR
// TAL QUE ASI  => condición ? valor_verdadero : valor_falso;
// - empty()    => ES LA CONDICION VERIFICA QUE EL CAMPO ESTÁ VACIO Y SI ES ASÍ, DEVUELVE TRUE
// - ? null : $_POST['fechaFinal']  => SON LOS VALORES SI HAY TRUE O FALSE
$fechaFinal = empty($_POST['fechaFinal']) ? null : $_POST['fechaFinal'];
// SEGURIDAD PHP => Añadimos variables con trim para impedir espacios vacios
$titulo = trim($_POST['titulo']);
$descripcion = trim($_POST['descripcion']);
$estado = trim($_POST['estado']);
// SEGURIDAD PHP => Creamos if para que no lleguen campos vacios tampoco
if ( empty($titulo) || empty($descripcion) || empty($estado) ){
    header("location: index.php");
    exit();
}


$update = "UPDATE tareas SET titulo = ?, descripcion = ?, estado = ?, fechaFinal= ? WHERE idTarea = ?;";

$updatePrepare = $conn -> prepare($update);
$updatePrepare -> execute([$titulo, $descripcion, $estado, $fechaFinal, $_POST['id']]);

$updatePrepare = null;
$conn = null;
header("location: index.php");
// header("location: indexampliado.php");