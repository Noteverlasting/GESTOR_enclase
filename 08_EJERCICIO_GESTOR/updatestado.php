<?php
// Llamamos al fichero de conexión
require_once '../pdo_connection.php';

// Preparamos la consulta de actualización
$updatestado = "UPDATE tareas SET estado = ? WHERE idTarea = ?;";
$updatestadoPrepare = $conn->prepare($updatestado);

// Ejecutamos la consulta con los datos recibidos por GET
$updatestadoPrepare->execute([$_GET['estado'], $_GET['id']]);

$updatestadoPrepare = null;
$conn = null;

header("location: index.php");