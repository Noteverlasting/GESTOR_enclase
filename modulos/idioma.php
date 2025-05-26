<?php 

//CREAMOS UNA VARIABLE DE SESION PARA EL IDIOMA Y POR DEFECTO LE DAMOS EL VALOR 'es' (ESPAÑOL)
$idioma = $_POST['idioma'] ?? 'es';
$_POST['idioma'] = $idioma;

