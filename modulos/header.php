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

            </div>
            <div>
            <p>
                Hola <span><?= $_SESSION['usuario'] ?></span> ! Qué tal?
            </p>
                            <form action="../perfil-usuario.php" method="post">
                <button type="submit" class="btnAcceder"> Tu perfil
                </button>
                </form></div>
        </div>
<div class="header-titulo">
  <h1>
    <span class="h1-ey">ey</span>
    <span class="h1-img">
      <img src="../08_EJERCICIO_GESTOR/img/home-imgs.png" alt="">
    </span>
    <span class="h1-task">task</span>
  </h1>
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
<div class="header-titulo">
  <h1>
    <span class="h1-ey">ey</span>
    <span class="h1-img">
      <img src="08_EJERCICIO_GESTOR/img/home-imgs.png" alt="">
    </span>
    <span class="h1-task">task</span>
  </h1>
</div>
            <?php endif ?>

    </header>
