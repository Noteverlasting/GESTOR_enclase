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
$titulo = htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8');
$descripcion = htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8');
// SEGURIDAD PHP => Creamos if para que no lleguen campos vacios tampoco
if ( empty($titulo) || empty($descripcion) || empty($estado) ){
    header("location: index.php");
    exit();
}
// SEGURIDAD PHP => if para que fechaFinal no esté vacia y sea un formato de fecha correcto
if ($fechaFinal !== null && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fechaFinal)) {
    $_SESSION['errorFechaInvalida'] = true;
    header ('Location: index.php');
    exit();
    
}
// SEGURIDAD PHP => if para que fechaFinal no sea anterior a hoy
if ($fechaFinal !== null && strtotime($fechaFinal) < strtotime(date('Y-m-d'))) {
    $_SESSION['errorFecha'] = true;
    header ('Location: index.php');
    exit();
}




//DECLARAMOS EL INSERT
$insert = "INSERT INTO tareas (titulo, descripcion, estado, fechaFinal, idUsuario) VALUES (?, ?, ?, ?, ?);";
//PREPARAMOS COMO FUNCIONARÁ EL INSERT
$insertPrepare = $conn -> prepare($insert);

$insertPrepare -> execute([$titulo, $descripcion, $estado, $fechaFinal, $_POST['idUsuario']]);
//PARAMOS EL PREPARE Y LA CONEXION
$insertPrepare = null;
$conn = null;

//VOLVEMOS A LA PAGINA DE ORIGEN
header("location: index.php");
// header("location: indexampliado.php");

?>