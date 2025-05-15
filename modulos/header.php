    <header>
        <div class="nombreUser">
            <div>
                <?php 
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
                Hola <span><?= $_SESSION['usuario'] ?></span> ! Qué tal?
            </p>
        </div>

            <?php else : ?>
            <form action="index-login.php" method="post">
                <button type="submit" class="btnAcceder"> Acceder
                </button>
            </form>
            
            <form action="crear-usuario.php" method="post">
                <button type="submit" class="btnAcceder"> Crear cuenta
                </button>
            </form>            
        </div></div>
            <?php endif ?>

        <div>
            <h1>GESTOR DE TAREAS</h1>
        </div>
    </header>
