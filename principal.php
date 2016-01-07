<?php
ob_start();
include ("funcionesLogin.php");
if(!isLogin())
{
    header("Location:admin");
}else{
	include ("funciones.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        include("head.php");
    ?>
    <title>Dolancy | Bienvenido</title>
</head><!--/head-->
<body>
    <?php
        include("menu_empleado.php");
    ?>
	
    <div class="container">
    	<div class="row">
    		<div class="col-xs-4">
	    		<div class="panel panel-warning">
	  				<div class="panel-body">
	    				Basic panel example
	  				</div>
				</div>
    		</div>
    		<div class="col-xs-4">
	    		<div class="panel panel-warning">
	  				<div class="panel-body">
	    				Basic panel example
	  				</div>
				</div>
    		</div>
    		<div class="col-xs-4">
	    		<div class="panel panel-warning">
	  				<div class="panel-body">
	    				Basic panel example
	  				</div>
				</div>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-xs-6">
	    		
    		</div>
    		<div class="col-xs-6">
	    		
    		</div>
    	</div>
        <div class="center gap">
            <h3>¿Qué podemos ofrecer?</h3>
            <p class="lead">En terminos simples abarcamos las siguientes areas de la mejor manera y con el mejor personal calificado</p>
        </div>

        <div class="row-fluid">
            <div class="span4">
                <div class="media">
                    <div class="pull-left">
                        <i class="icon-globe icon-medium"></i>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">Redes</h4>
                        <p>Podemos ofrecer cableado de Red Cat 5-6, conexiones telefónicas rj11 - telefonía IP, presupuestos pueden incluir o no materiales, disponemos de proveedores.</p>
                    </div>
                </div>
            </div>            

            <div class="span4">
                <div class="media">
                    <div class="pull-left">
                        <i class="icon-thumbs-up-alt icon-medium"></i>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">Camaras</h4>
                        <p>Contamos con insumos, experiencia y buenos resultados de nuestros trabajos, instalamos cámaras, puede cotizar instalación incluyendo los materiales de toda la obra. Puede ser desde 1 simple a cámara a una central DVR conectada a una aplicación android.</p>
                    </div>
                </div>
            </div>            

            <div class="span4">
                <div class="media">
                    <div class="pull-left">
                        <i class="icon-leaf icon-medium icon-rounded"></i>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">Presupuestos rapidos</h4>
                        <p>Contáctese con nosotros en un plazo no mayor a 24 hrs, estaremos en contacto con usted, también tiene la opción de visitarnos en nuestra tienda como de llamarnos</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="gap"></div>

        <div class="row-fluid">
            <div class="span4">
                <div class="media">
                    <div class="pull-left">
                        <i class="icon-shopping-cart icon-medium"></i>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">Stock Insumos</h4>
                        <p>Contamos con un gran stock para que su compra sea más ágil, podemos armar y montar equipos de manera ágil, ven y visitanos puedes encontrar lo que buscas, tenemos proveedores de gran fidelidad.</p>
                    </div>
                </div>
            </div>            

            <div class="span4">
                <div class="media">
                    <div class="pull-left">
                        <i class="icon-globe icon-medium"></i>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">SEO &amp; Solución</h4>
                        <p>Nuestro gerente es participe de cada proceso, analizando y visualizando que se cumplan los protocolos de la empresa, con esto mantenemos el buen servicio a nuestros clientes y no perdemos la calidad de estos.</p>
                    </div>
                </div>
            </div>            

            <div class="span4">
                <div class="media">
                    <div class="pull-left">
                        <i class="icon-globe icon-medium"></i>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">Comunicación</h4>
                        <p>Para nosotros es importante mantener una buena relación con los clientes, es por esto que cuando usted registra una obra, o compra un producto, automáticamente generamos un número de respaldo, con el cual puede llamar o visitar el local y consultar alguna duda, estado, o retiro de dicho producto.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

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