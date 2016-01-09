<?php
ob_start();
include ("funcionesLogin.php");

if(!isLogin()){	
    header("Location:admin");
}else{
	include ("funciones.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("head.php"); ?>
    <title>Dolancy | Bienvenido</title>
</head>
<body>
    <?php include("menu_empleado.php"); ?>
	
    <div class="container-fluid">
    	<div class="row">
    		<div class="col-xs-4">
	    		<div class="panel panel-warning">
	  				<div class="panel-body">
	  					<form>
  							<div class="form-group">
    							<label for="color_label">Color: </label>
    							<?php getColors(); ?>
  							</div>
  							<div class="form-group">
    							<label for="talla_label">Talla: </label>
    							<?php getSizes(); ?>
  							</div>
  							<div class="form-group">
    							<label for="model_label">Modelo: </label>
    							<?php getModels(); ?>
  							</div>
  							<button type="button" class="btn btn-primary" id="search_shoe"><i class="icon-search icon-small"></i> Buscar</button>
  							<a target="_self" href="#" class="btn btn-success pull-right"><i class="icon-qrcode icon-small"></i> Escanear QR</a>
						</form>
	  				</div>
				</div>
    		</div>
    		<div class="col-xs-4">
	    		<div class="panel panel-warning">
	  				<div class="panel-body">
	    				<p>Buscar usando un código QR</p>
	    				<a target="_self" href="#" class="btn btn-success btn-lg"><i class="icon-qrcode icon-small"></i> Escanear QR</a>
						<hr>
						<p>Ver lista de ventas de hoy</p>
	    				<a target="_self" href="#" class="btn btn-warning btn-lg"><i class="icon-list icon-small"></i> Ventas de hoy</a>
	  				</div>
				</div>
    		</div>
    		<div class="col-xs-4">
	    		<div class="panel panel-success">
	  				<div class="panel-heading">
						<?php getEmployee(getUsuId())?>
						<hr>
						<div class="media services"><div class="pull-left"><i class="icon-time icon-md"></i></div>
              				<div class="media-body" id="liveclock"></div>
              			</div>
	  				</div>
				</div>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-xs-6">
	    		<div class="panel panel-warning">
    				<div class="panel-heading">Resultados de Búsqueda</div>
    				<div id="search_shoe_result" class="panel-body">
    					<?php 
    					getShoes(getBranchId()) 
    					?>
    				</div>
  				</div>
    		</div>
    		<div class="col-xs-6">
    			<div class="panel panel-warning">
    				<?php getSaleList(getUsuId())?>
  				</div>
    		</div>
    	</div>
    </div>

    <?php include("footer.php"); ?>

    <?php include("js.php"); ?>
	
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  		<div class="modal-dialog" role="document">
    		<div class="modal-content">
      			<div class="modal-header">
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        			<h4 class="modal-title" id="modalTitle">Modal title</h4>
      			</div>
      			<div class="modal-body">
        			...
      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        			<button type="button" class="btn btn-primary">Save changes</button>
      			</div>
    		</div>
  		</div>
	</div>
	
</body>
</html>
<?php
}
ob_end_flush();
?>