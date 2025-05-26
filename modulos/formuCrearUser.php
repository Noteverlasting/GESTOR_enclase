        <form action="insert_temporal.php" method="post">
            <fieldset class="crear-usuario">
            <h2>Crear cuenta</h2>
        <div>
            <label for="usuario">Nombre:</label>
            <input type="text" name="usuario" id="usuario">
        </div>
        <div>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password">
        </div>
        <div>
            <label for="password2">Repite la contraseña:</label>
            <input type="password" name="password2" id="password2">
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email">
        </div>
        <div>
            <label for="telefono">Telefono:</label>
            <input type="tel" name="telefono" id="telefono">
        </div>
                <div class="div-enlaces">
            <!-- CON ESTE HREF LE VAMOS A INDICAR QUE:
            dentro de index.php, enviamos esto -> ?formulario=crear-usuario 
            lo que se va a enviar es -> $_GET['formulario'] = crear-usuario 
            Entonces lo que nos llevará es a un formulario 'crear-usuario' sin salir del HTML, ni recargar toda la pagina-->
        <p>Ya tienes cuenta?<a href="index.php?formulario=login">  acceder</a></p>
        </div>
        <div class="botoncitos">
                        <button type="submit">enviar datos</button>
                        <button type="reset">borrar datos</button>
        </div>

        </fieldset>
        </form>