<?php
ob_start();
include ("funcionesLogin.php");
if(isLogin())
{
    header("Location:paginaInscritos.php");
}else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        include("head.php");
    ?>
    <title>Dolancy | Admin</title>
</head><!--/head-->
<body>
    <?php
        include("menu.php");
    ?>

    <section id="title" class="midnight-blue">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <h2 style="font-size: 5.0em; font-family: 'Open Sans', sans-serif;">Dolancy</h2>
                </div>
            </div>
        </div>
        <br/>
        <div class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <h2>Bienvenido</h2><br/>   
                    <?php 
                        if($_GET)
                        {
                            if($_GET["logout"]=="true")
                            {
                                ?>
                                <br/>
                                <div class="alert alizarin" role="alert">¡Sesión cerrada!</div>
                                <?php
                            }
                        }
                    ?> 
                    <form class="form-signin" role="form" action="verificaLogin.php" method="POST">
                        <div class="form-group">
                            <label for="usuario">Usuario</label>
                            <input type="email" class="form-control" id="nu" name="nu" placeholder="Ingresa el Usuario" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" class="form-control" id="pu" name="pu" placeholder="Ingresa la contraseña" required>
                        </div>
                        <button type="submit" class="btn btn-warning">Iniciar Sesión</button>
                    </form>
                    <?php 
                        if($_GET)
                        {
                            if($_GET["access"]=="false")
                            {
                                ?>
                                <br/>
                                <div class="alert alizarin" role="alert">Usuario o Contraseña incorrectos.</div>
                                <?php
                            }
                        }
                    ?>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
    </section>


    <?php
        include("footer.php");
    ?>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>

</body>
</html>
<?php
}
ob_end_flush();
?>