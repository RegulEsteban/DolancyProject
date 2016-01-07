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
                <li><a href="./"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Inicio</a></li>
                <li><a href="portfolio.php"><span class="glyphicon glyphicon-camera" aria-hidden="true"></span> Fotos</a></li>
                <li><a href="contact-us.html"><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span> Contacto</a></li>
                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dolancy <i class="icon-chevron-down icon-small"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="que-es-ercaj.php">¿Quíenes somos?</a></li>
                        <li><a href="portfolio.php">Misión</a></li>
                        <li><a href="blog.html">Visión</a></li>
                    </ul>
                </li>
                
                <?php toggleLogin() ?>
            </ul>
        </div>
    </div>
</header><!--/header-->