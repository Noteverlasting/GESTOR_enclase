<?php
session_start();

// Elimina todas las variables de sesión almacenadas en $_SESSION, sin borrar $_SESSION
session_unset(); 
// Se destruye la sesion actual
session_destroy();
print_r($_SESSION);

header('Location: index.php');

