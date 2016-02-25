<header class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./">Dolancy</a>
        </div>
        
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="Bienvenido"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Inicio</a></li>
                <li><a href="Empleados"><i class='icon-group icon-small'></i> Empleados</a></li>
                <li><a href="Usuarios"><i class='icon-coffee icon-small'></i> Usuarios</a></li>
                <?php toggleLogin() ?>
            </ul>
        </div>
    </div>
</header><!--/header-->