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
    <?php include_once 'modulos/etiquetasMeta.php'; ?>
    
    <title>eytask // Gestor de tareas - LOGIN</title>
    <link rel="shortcut icon" href="08_EJERCICIO_GESTOR/img/favicon.gif" type="image/x-icon"> 
    <link rel="stylesheet" href="08_EJERCICIO_GESTOR/css/copia.css">
</head>
<body>
    <?php
    include_once 'modulos/headercopy.php';
    ?>
    <!-- <header class="index-titulo">
        <div class="nombreUser">
            <div>
                < ?php 
                if ($_SESSION['usuario']) : ?>
                <form action="../logout.php" method="post">
                    <button type="submit" class="btnLogout"> Cerrar sesion
                    <i class="fa-solid fa-door-open" style="color: red;"></i>
                    </button>
                </form>
                <form action="../perfil-usuario.php" method="post">
                <button type="submit" class="btnAcceder"> Tu perfil
                </button>
                </form>
            </div>
            <p>
                Hola <span>< ?= $_SESSION['usuario'] ?></span> ! Qué tal?
            </p>
        </div>

            < ?php else : ?>
            <form action="index-login.php" method="post">
                <button type="submit" class="btnAcceder"> Acceder
                </button>
            </form>
            
            <form action="crear-usuario.php" method="post">
                <button type="submit" class="btnAcceder"> Crear cuenta
                </button>
            </form>            
        </div></div>
            < ?php endif ?>

        <div >
            <h1>GESTOR DE TAREAS</h1>
        </div>
    </header> -->
    <main class="index-main">
        <!--  Creamos un dialog       -->
        <!-- <dialog id="login" open closedby="any">
            <form action="login.php" method="post">
                <fieldset>
                    <h2>Iniciar sesion</h2>
                    <div>
                        <label for="usuario">Nombre:</label>
                        <input type="text" name="usuario" id="usuario">
                    </div>
                    <div>
                        <label for="password">Contraseña:</label>
                        <input type="password" name="password" id="password">
                    </div>


                    <div class="errorCuenta">
                        < ?php /*
                        if ($_SESSION['error']):
                        ?>
                        <p> Error en los datos </p>
                        < ?php endif; ?>
                    </div>
                    <div class="errorCuenta">
                        < ?php 
                        if ($_SESSION['errorUserInexistente']):
                        ?>
                        <p> Usuario o contraseña incorrectos </p>
                        < ?php endif; */?>
                    </div>
                    <div class="botones">
                        <button type="submit"> Enviar datos </button>
                        <button type="reset"> Borrar datos </button>
                    </div>


                </fieldset>
            </form>
        </dialog> -->
        <section class="index-section">
        <div>
        <img src="08_EJERCICIO_GESTOR/img/home-imgs.png" alt="">
        </div>
        <div>
            <h2> ¿Como organizar tus tareas?</h2>
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Maxime saepe cumque delectus. 
            Nisi esse veritatis ratione suscipit, quo assumenda dolorem at nobis quia totam itaque officiis quos eius placeat ut?
            In libero aperiam ipsum numquam sint, labore cum consequuntur, blanditiis molestias expedita esse corporis reprehenderit, 
            repudiandae iusto. Earum similique, unde ipsa aperiam culpa cum debitis adipisci cumque sint ratione molestiae!
        </div>
    </section>
        <section>
        <!-- ESTE PHP VA A RECIBIR LO QUE TENGAMOS EN LA VARIABLE, PERO SI NO ESTÁ DISPONIBLE, USA EL LOGIN -->
        <?php 
        $formulario = $_GET['formulario'] ?? 'login';
        // CON EL SWITCH VAMOS A HACER QUE CARGUE UN FORMULARIO U OTRO EN FUNCION DE LO QUE LLEGUE POR URL GET
        switch ($formulario) {
            case 'login':
                include_once 'modulos/formuLogin.php';
                break;
            case 'crear-usuario':
                include_once 'modulos/formuCrearUser.php';
                break;
            case 'reset':
                include_once 'modulos/formuResetPass.php';
                break;
            default:
                include_once 'modulos/formuLogin.php';
                break;
        }
        ?>
    </section>

    
    </main>
</body>
<script src="js/index.js"></script>
</html>

<?php 

$_SESSION['errorUserInexistente'] = false;
$_SESSION['error'] = false;