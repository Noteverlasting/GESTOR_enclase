<form action="reset_password.php" method="post">
                <fieldset class="crear-usuario">
                    <h2>Recuperar contraseña</h2>
                    <div>
                        <label for="usuario">Introduce tu user o email:</label>
                        <input type="text" name="usuario" id="usuario">
                        <p id="errorReset"></p>
                    </div>

                    <div class="div-enlaces">
                    <a href="index.php?formulario=login">Ya he recordado la contraseña</a>                    
                    <!-- CON ESTE HREF LE VAMOS A INDICAR QUE:
                         dentro de index.php, enviamos esto -> ?formulario=crear-usuario 
                         lo que se va a enviar es -> $_GET['formulario'] = crear-usuario 
                         Entonces lo que nos llevará es a un formulario 'crear-usuario' sin salir del HTML, ni recargar toda la pagina-->
                    <p>No tienes cuenta?<a href="index.php?formulario=crear-usuario">  crear cuenta</a></p>
                    </div>

                    <div class="botoncitos">
                        <button type="submit">enviar datos</button>
                        <button type="reset">borrar datos</button>
                    </div>


                </fieldset>
            </form>