<?php
//COMO NO QUEREMOS QUE NOS SALGAN WARNINGS EN PANTALLA, DESACTIVAMOS LOS ERRORES
// Lo ideal es arreglarlo con javascript, pero si no se puede, lo desactivamos
error_reporting(0);

session_start();
require_once 'pdo_connection.php';


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include_once 'etiquetasMeta.php'; ?> 
    <title>GESTOR DE TAREAS - LOGIN</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <header>
        <nav class="index-nav">
            <ul>
                <li><a href="crear-usuario.php">Crear cuenta</a></li>
                <li><a href="login.php">Iniciar sesion</a></li>
            </ul>
        </nav>
    </header>
    <main class="index-main">
        <!--  Creamos un dialog       -->
        <dialog id="login" open closedby="any">
            <form action="login.php" method="post">
                <fieldset>
                    <h1>Iniciar sesion</h1>
                    <div>
                        <label for="usuario">Nombre:</label>
                        <input type="text" name="usuario" id="usuario">
                    </div>
                    <div>
                        <label for="password">Contraseña:</label>
                        <input type="password" name="password" id="password">
                    </div>
                    <div>
                    <a href="crear-usuario.php"> Crear cuenta</a>
                    </div>

                    <div class="errorCuenta">
                        <?php 
                        if ($_SESSION['error']):
                        ?>
                        <p> Error en los datos </p>
                        <?php endif; ?>
                    </div>
                    <div class="errorCuenta">
                        <?php 
                        if ($_SESSION['errorUserInexistente']):
                        ?>
                        <p> Usuario o contraseña incorrectos </p>
                        <?php endif; ?>
                    </div>
                    <div class="botones">
                        <button type="submit"> Enviar datos </button>
                        <button type="reset"> Borrar datos </button>
                    </div>


                </fieldset>
            </form>
        </dialog>
    </main>
</body>
</html>

<?php 

$_SESSION['errorUserInexistente'] = false;
$_SESSION['error'] = false;