<?php 
error_reporting(0);
// SEGURIDAD PHP --  Crear un inicio de sesion
session_start();
// Declarar $_SESSION con nombre y le asignamos un numero binario random de 32 bytes.
$_SESSION ['sessionToken'] = bin2hex(random_bytes(32));
// Llamar a la conexion
require_once '../pdo_connection.php';






// Definir la instruccion a seguir en una variable.
$select = "SELECT * FROM tareas WHERE idUsuario = :idUsuario ;";
// Preparación
$preparacion = $conn -> prepare($select);
$preparacion -> bindParam(':idUsuario', $_SESSION['idUsuario'], PDO::PARAM_INT);
// Ejecución
$preparacion -> execute();
// Obtención de valores seleccionados y transformacion en un array asociativo
$arrayFilas = $preparacion -> fetchAll();

// Agrupar tareas por día de la semana para la traduccion al mostrarlas en pantalla
$tareasPorDia = [];
$dias = [
    'Monday' => 'lunes',
    'Tuesday' => 'martes',
    'Wednesday' => 'miércoles',
    'Thursday' => 'jueves',
    'Friday' => 'viernes',
    'Saturday' => 'sábado',
    'Sunday' => 'domingo'
];
// foreach para recorrer el array de tareas y agruparlas por día de la seman
foreach ($arrayFilas as $fila) {
    // Usamos un ternario para comprobar si la tarea tiene el campo 'fechaFinal', si es asi se le asigna un dia, si no se le asigna 'Sin Fecha'.
    // Se utiliza la función date('l', strtotime($fila['fechaFinal']))
    // la 'l' en date() devuelve el nombre completo del día de la semana en inglés y con strtotime() se convierte la 'fechaFinal' en un timestamp,
    // se traduce al español usando el array $dias.
    $diaSemana = $fila['fechaFinal'] ? $dias[date('l', strtotime($fila['fechaFinal']))] : 'Sin Fecha'; 
    $tareasPorDia[$diaSemana][] = $fila;
}

// Ordenar $tareasPorDia para que 'Sin Fecha' vaya primero y el resto por fecha
uksort($tareasPorDia, function($a, $b) {
    if ($a === 'Sin Fecha') return -1;
    if ($b === 'Sin Fecha') return 1;
    return 0;
});

$conn = null;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/gestor.css">
</head>
<body>
    <header>
        <div class="nombreUser">
            <p>
                Hola <span><?= $_SESSION['usuario'] ?></span> ! Qué tal?
            </p>
        </div>
        <div><h1>GESTOR DE TAREAS</h1></div>
    </header>
<main>
    <section class="formu">
        <?php if ($_GET) : ?>
                <div class="hache2">
            <h2>Modificar la tarea</h2>
            </div>
            <form action="update.php" method="post">
                <fieldset>
                    <!-- SEGURIDAD PHP -- Token de sesión -->
                    <input type="hidden" name="sessionToken" value="<?= $_SESSION ['sessionToken']?>">
                    <!-- SEGURIDAD PHP -- HoneyPot -->
                    <input type="text" name="web" style="display:none">
                    <input type="text" name="id" id="id" value="<?=$_GET['id']?>" hidden>
                    <div>
                        <label for="titulo">Titulo*:</label>
                        <input type="text" name="titulo" id="titulo" value="<?=$_GET['titulo']?>">
                    </div>
                    <div>
                        <label for="descripcion">Descripcion*:</label>
                        <input type="text" name="descripcion" id="descripcion" value="<?=$_GET['descripcion']?>">
                    </div>
                    <div>
                        <label for="estado">Estado de la tarea*:</label>
                        <select name="estado" id="estado" value="<?=$_GET['estado']?>">
                        <option value="urgente" style="color: red; font-weight: 700;">urgente</option>
                        <option value="pendiente" style="color: blue; font-weight: 700;">pendiente</option>   
                        <option value="ejecucion" style="color: green; font-weight: 700;">en ejecucion</option>
                        <option value="finalizada" style="color: gray; font-weight: 700;">finalizada</option>
                        </select>
                    </div>
                    <div>
                        <label for="fechaFinal">Fecha de finalizacion (si precisa):</label>
                        <input type="date" name="fechaFinal" id="fechaFinal">
                    </div>
                    <div class="botoncitos">
                        <button type="submit" class="enviar">MODIFICAR</button>
                        <a href="index.php">
                        <button type="button" class="cancelar">CANCELAR</button>
                        </a>
                    </div>
                    <p class="fecha" style="text-align: right; color: purple; padding-right:1rem;">(*)campos requeridos</p>
                </fieldset>
            </form>

        <?php else : ?>
                <div class="hache2">
                <h2>Crea una tarea</h2>
                </div>
            <form action="insert.php" method="post">
                <fieldset>
                    <!-- SEGURIDAD PHP -- Token de sesión -->
                    <input type="hidden" name="sessionToken" value="<?= $_SESSION ['sessionToken']?>">
                    <input type="hidden" name="idUsuario" value="<?= $_SESSION['idUsuario']?>">
                    <!-- SEGURIDAD PHP -- HoneyPot -->
                    <input type="text" name="web" style="display:none">

                    <div>
                    <label for="titulo">Titulo*:</label>
                    <input type="text" name="titulo" id="titulo">
                    </div>
                    <div>
                        <label for="descripcion">Descripcion*:</label>
                        <input type="text" name="descripcion" id="descripcion">
                    </div>
                    <div>
                        <label for="estado">Estado de la tarea*:</label>
                        <select name="estado" id="estado">
                        <option value="urgente" style="color: red; font-weight: 700;">urgente</option>
                        <option value="pendiente" style="color: blue; font-weight: 700;">pendiente</option>   
                        <option value="ejecucion" style="color: green; font-weight: 700;">en ejecucion</option>
                        <option value="finalizada" style="color: gray; font-weight: 700;">finalizada</option>
                        </select>
                    </div>
                    <div>
                        <label for="fechaFinal">Fecha de finalizacion (si precisa):</label>
                        <input type="date" name="fechaFinal" id="fechaFinal">
                    </div>
                    <div class="errorFecha">
                        <?php 
                        if ($_SESSION['errorFecha']):
                        ?>
                        <p> La fecha final no puede ser anterior a hoy. </p>
                        <?php endif; ?>
                    </div>
                    <div class="errorFecha">
                        <?php 
                        if ($_SESSION['errorFechaInvalida']):
                        ?>
                        <p> Fecha no válida. </p>
                        <?php endif; ?>
                    </div>


                    <div class="botoncitos">
                        <button type="submit" class="enviar">CREAR</button>
                        <button type="reset" class="reset">LIMPIAR</button>
                        
                    </div>
                    <p class="requerido">(*) campos requeridos</p>
                </fieldset>
            </form>

        <?php  endif; ?>
        <!-- Añado un boton para alternar la vista de las tareas por dia o estado -->
        <div class="toggleView">
    <button id="toggleEstado">Ver por Estado</button>
    <button id="toggleDia">Ver por Día</button>
</div>
    </section>
    <section class="estadosTareas">
        <div>
            <h3>Urgentes</h3>
            <?php foreach ($arrayFilas as $fila): ?>
                <?php if ($fila['estado'] === 'urgente'): ?>
                    <div class="tarea urgente">
                        <details>
                            <summary class="titulo"><i class="fa-solid fa-angle-down"></i> <?= htmlspecialchars($fila['titulo'], ENT_QUOTES, 'UTF-8') ?></summary>
                            <p class="descripcion"><?= htmlspecialchars($fila['descripcion'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="fecha">Añadido: <?= htmlspecialchars($fila['fecha'], ENT_QUOTES, 'UTF-8') ?></p>
                            <?php if ($fila['fechaFinal']): ?>
                            <p class="fechaFinal">Fecha fin: <?= htmlspecialchars($fila['fechaFinal'], ENT_QUOTES, 'UTF-8') ?></p>
                            <?php endif; ?>
                        
                            <span>
                                <a href="delete.php?id=<?=$fila['idTarea']?>" title="Eliminar tarea">
                                <i class="fa-solid fa-trash fa-xs" ></i>
                                </a>
                                <a href="index.php?id=<?=$fila['idTarea']?>&titulo=<?= str_replace(" ", "%20", $fila['titulo'])?>&descripcion=<?= str_replace(" ", "%20", $fila['descripcion'])?>&estado=<?=$fila['estado']?>" title="Modificar tarea">
                                <i class="fa-solid fa-pen fa-xs" ></i>
                                </a>
                                <a href="updatestado.php?id=<?=$fila['idTarea']?>&estado=pendiente" title="Marcar como pendiente">
                                <i class="fa-solid fa-clock fa-xs" style="color: blue;"></i>
                                </a>
                                <a href="updatestado.php?id=<?=$fila['idTarea']?>&estado=ejecucion" title="Marcar como en ejecución">
                                <i class="fa-solid fa-spinner fa-xs" style="color: green;"></i>
                                </a>
                                <a href="updatestado.php?id=<?=$fila['idTarea']?>&estado=finalizada" title="Marcar como finalizada">
                                <i class="fa-solid fa-check fa-xs" style="color: gray;"></i>
                                </a>
                            </span>
                        </details>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <div>
            <h3>Pendientes</h3>
            <?php foreach ($arrayFilas as $fila): ?>
                <?php if ($fila['estado'] === 'pendiente'): ?>
                    <div class="tarea pendiente">
                    <details>
                        <summary class="titulo"><i class="fa-solid fa-angle-down"></i> <?= $fila['titulo'] ?></summary>
                        <p class="descripcion"><?= $fila['descripcion'] ?></p>
                        <p class="fecha">Añadido: <?= $fila['fecha'] ?></p>
                        <?php if ($fila['fechaFinal']): ?>
                            <p class="fechaFinal">Fecha fin: <?= $fila['fechaFinal'] ?></p>
                        <?php endif; ?>
                        
                        <span>
                            <a href="delete.php?id=<?=$fila['idTarea']?>" title="Eliminar tarea">
                            <i class="fa-solid fa-trash fa-xs" ></i>
                            </a>
                            <a href="index.php?id=<?=$fila['idTarea']?>&titulo=<?= str_replace(" ", "%20", $fila['titulo'])?>&descripcion=<?= str_replace(" ", "%20", $fila['descripcion'])?>&estado=<?=$fila['estado']?>" title="Modificar tarea">
                            <i class="fa-solid fa-pen fa-xs" ></i>
                            </a>
                            <a href="updatestado.php?id=<?=$fila['idTarea']?>&estado=urgente" title="Marcar como urgente">
                            <i class="fa-solid fa-circle-exclamation fa-xs" style="color: red;"></i>
                            </a>
                            <a href="updatestado.php?id=<?=$fila['idTarea']?>&estado=ejecucion" title="Marcar como en ejecución">
                            <i class="fa-solid fa-spinner fa-xs" style="color: green;"></i>
                            </a>
                            <a href="updatestado.php?id=<?=$fila['idTarea']?>&estado=finalizada" title="Marcar como finalizada">
                            <i class="fa-solid fa-check fa-xs" style="color: gray;"></i>
                            </a>
                        </span>
                        </details>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <div>
            <h3>En ejecución</h3>
            <?php foreach ($arrayFilas as $fila): ?>
                <?php if ($fila['estado'] === 'ejecucion'): ?>
                    <div class="tarea ejecucion">
                    <details>
                        <summary class="titulo"><i class="fa-solid fa-angle-down"></i> <?= $fila['titulo'] ?></summary>
                        <p class="descripcion"><?= $fila['descripcion'] ?></p>
                        <p class="fecha">Añadido: <?= $fila['fecha'] ?></p>
                        <?php if ($fila['fechaFinal']): ?>
                            <p class="fechaFinal">Fecha fin: <?= $fila['fechaFinal'] ?></p>
                        <?php endif; ?>
                        
                        <span>
                            <a href="delete.php?id=<?=$fila['idTarea']?>" title="Eliminar tarea">
                            <i class="fa-solid fa-trash fa-xs" ></i>
                            </a>
                            <a href="index.php?id=<?=$fila['idTarea']?>&titulo=<?= str_replace(" ", "%20", $fila['titulo'])?>&descripcion=<?= str_replace(" ", "%20", $fila['descripcion'])?>&estado=<?=$fila['estado']?>" title="Modificar tarea">
                            <i class="fa-solid fa-pen fa-xs" ></i>
                            </a>
                            <a href="updatestado.php?id=<?=$fila['idTarea']?>&estado=urgente" title="Marcar como urgente">
                            <i class="fa-solid fa-circle-exclamation fa-xs" style="color: red;"></i>
                            </a>
                            <a href="updatestado.php?id=<?=$fila['idTarea']?>&estado=pendiente" title="Marcar como pendiente">
                            <i class="fa-solid fa-clock fa-xs" style="color: blue;"></i>
                            </a>
                            <a href="updatestado.php?id=<?=$fila['idTarea']?>&estado=finalizada" title="Marcar como finalizada">
                            <i class="fa-solid fa-check fa-xs" style="color: gray;"></i>
                            </a>
                        </span>
                        </details>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <div>
            <h3>Finalizadas</h3>
            <?php foreach ($arrayFilas as $fila): ?>
                <?php if ($fila['estado'] === 'finalizada'): ?>
                    <div class="tarea finalizada">
                    <details>
                        <summary class="titulo"><i class="fa-solid fa-angle-down"></i> <?= $fila['titulo'] ?></summary>
                        <p class="descripcion"><?= $fila['descripcion'] ?></p>
                        <p class="fecha">Añadido: <?= $fila['fecha'] ?></p>
                        <?php if ($fila['fechaFinal']): ?>
                            <p class="fechaFinal">Fecha fin: <?= $fila['fechaFinal'] ?></p>
                        <?php endif; ?>
                        
                        <span>
                            <a href="delete.php?id=<?=$fila['idTarea']?>" title="Eliminar tarea">
                            <i class="fa-solid fa-trash fa-xs" ></i>
                            </a>
                            <a href="index.php?id=<?=$fila['idTarea']?>&titulo=<?= str_replace(" ", "%20", $fila['titulo'])?>&descripcion=<?= str_replace(" ", "%20", $fila['descripcion'])?>&estado=<?=$fila['estado']?>" title="Modificar tarea">
                            <i class="fa-solid fa-pen fa-xs" ></i>
                            </a>
                            <a href="updatestado.php?id=<?=$fila['idTarea']?>&estado=urgente" title="Marcar como urgente">
                            <i class="fa-solid fa-circle-exclamation fa-xs" style="color: red;"></i>
                            </a>
                            <a href="updatestado.php?id=<?=$fila['idTarea']?>&estado=pendiente" title="Marcar como pendiente">
                            <i class="fa-solid fa-clock fa-xs" style="color: blue;"></i>
                            </a>
                            <a href="updatestado.php?id=<?=$fila['idTarea']?>&estado=ejecucion" title="Marcar como en ejecución">
                            <i class="fa-solid fa-spinner fa-xs" style="color: limegreen;"></i>
                            </a>
                        </span>
                        </details>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="tareasPorDia" style="display: none;">
    <h2>Tareas por Día de la Semana</h2>
    <?php foreach ($tareasPorDia as $dia => $tareas): ?>
        <div class="dia">
            <?php 
            // Obtener la fecha concreta de la primera tarea del día
            $fechaConcreta = $tareas[0]['fechaFinal'] ? date('d/m/Y', strtotime($tareas[0]['fechaFinal'])) : '';
            ?>
                <h3><?= htmlspecialchars($dia, ENT_QUOTES, 'UTF-8') ?><?= $fechaConcreta ? htmlspecialchars($fechaConcreta, ENT_QUOTES, 'UTF-8') : '' ?></h3>
                <?php foreach ($tareas as $tarea): ?>
                    <div class="tarea <?= htmlspecialchars($tarea['estado'], ENT_QUOTES, 'UTF-8') ?>">
                    <details>
                        <summary class="titulo"><i class="fa-solid fa-angle-down"></i><?= htmlspecialchars($tarea['titulo'], ENT_QUOTES, 'UTF-8') ?></summary>
                        <p class="descripcion"><?= htmlspecialchars($tarea['descripcion'], ENT_QUOTES, 'UTF-8') ?></p>
                        <p class="fecha">Añadido: <?= htmlspecialchars($tarea['fecha'], ENT_QUOTES, 'UTF-8') ?></p>
                        <?php if ($tarea['fechaFinal']): ?>
                            <p class="fechaFinal">Fecha fin: <?= htmlspecialchars($tarea['fechaFinal'], ENT_QUOTES, 'UTF-8') ?></p>
                        <?php endif; ?>
                            <span>
                                <a href="delete.php?id=<?=$fila['idTarea']?>" title="Eliminar tarea">
                                <i class="fa-solid fa-trash fa-xs" ></i>
                                </a>
                                <a href="index.php?id=<?=$fila['idTarea']?>&titulo=<?= str_replace(" ", "%20", $fila['titulo'])?>&descripcion=<?= str_replace(" ", "%20", $fila['descripcion'])?>&estado=<?=$fila['estado']?>" title="Modificar tarea">
                                <i class="fa-solid fa-pen fa-xs" ></i>
                                </a>
                                <a href="updatestado.php?id=<?=$fila['idTarea']?>&estado=pendiente" title="Marcar como pendiente">
                                <i class="fa-solid fa-clock fa-xs" style="color: blue;"></i>
                                </a>
                                <a href="updatestado.php?id=<?=$fila['idTarea']?>&estado=ejecucion" title="Marcar como en ejecución">
                                <i class="fa-solid fa-spinner fa-xs" style="color: green;"></i>
                                </a>
                                <a href="updatestado.php?id=<?=$fila['idTarea']?>&estado=finalizada" title="Marcar como finalizada">
                                <i class="fa-solid fa-check fa-xs" style="color: gray;"></i>
                                </a>
                            </span>
                    </details>
                    </div>
                <?php endforeach; ?>
            
        </div>
    <?php endforeach; ?>
</section>

</main>
<script>
// SCRIPT PARA EL BOTON DE CAMBIO DE VISTAS
// Aqui se indica que el boton de 'Ver por Estado' muestre la vista de tareas por estado ocultando la otra vista
// y viceversa para el boton de 'Ver por Dia'
document.getElementById('toggleEstado').addEventListener('click', function () {
    document.querySelector('.estadosTareas').style.display = 'grid';
    document.querySelector('.tareasPorDia').style.display = 'none';
});

document.getElementById('toggleDia').addEventListener('click', function () {
    document.querySelector('.estadosTareas').style.display = 'none';
    document.querySelector('.tareasPorDia').style.display = 'grid';
});
</script>
</body>
</html>
<?php
$_SESSION['errorFecha'] = false;