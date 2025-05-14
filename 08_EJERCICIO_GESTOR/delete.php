<?php
// Llamamos al fichero de conexión
require_once '../pdo_connection.php';

echo $_GET['id'];

$delete = "DELETE FROM tareas WHERE idTarea = ?;";

$deletePrepare = $conn -> prepare($delete);
$deletePrepare -> execute([$_GET['id']]);

$deletePrepare = null;
$conn = null;

header("location: index.php");
// header("location: indexampliado.php");