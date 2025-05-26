<form action="login.php" method="post">
                        <!-- Mensaje de bienvenida  -->
                <?php if(isset($_GET['mensaje']) && $_GET['mensaje']=="registro_ok") : ?>
                    <p>Ya puedes introducir tus datos, <?= $_SESSION['nombre-usuario'] ?></p>
                <?php endif; ?>
                <fieldset class="crear-usuario">

                    <h2>Iniciar sesion</h2>
                    <div>
                        <label for="usuario">Nombre:</label>
                        <input type="text" name="usuario" id="usuario">
                        <p id="errorUsuario"></p>
                    </div>
                    <div>
                        <label for="password">Contraseña:</label>
                        <input type="password" name="password" id="password">
                        <p id="errorPassword"></p>
                    </div>
                    <!-- <div>
                    <a href="crear-usuario.php"> Crear cuenta</a>
                    </div> -->

                    <div class="div-enlaces">
                    <p>No tienes cuenta?<a href="index.php?formulario=crear-usuario">  crear cuenta</a></p>
                    <a href="index.php?formulario=reset">No recuerdo la contraseña</a>
                    </div>
                    </div>
                    <div class="botoncitos">
                        <button type="submit">enviar datos</button>
                        <button type="reset">borrar datos</button>
                    </div>
        <!-- <div class="volver">
            <p><a href="index.php"> volver a inicio</a></p>
        </div>                     -->


                </fieldset>
            </form>