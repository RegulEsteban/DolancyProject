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
  							<a target="_self" href="#" class="btn btn-success pull-right" id="search-shoe-qr"><i class="icon-qrcode icon-small"></i> Escanear QR</a>
						</form>
	  				</div>
				</div>
    		</div>
    		<div class="col-xs-4">
	    		<div class="panel panel-warning">
	    			<div class="panel-heading"><span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span> Herramientas</div>
	  				<div class="panel-body">
						<button type="button" id="transactionsButton" class="btn btn-warning btn-lg btn-block">
							<span class="glyphicon glyphicon-home" aria-hidden="true"></span>
							<span class="glyphicon glyphicon-transfer" aria-hidden="true"></span>
							<span class="glyphicon glyphicon-home" aria-hidden="true"></span>
							 Transacciones
						</button>
						<button type="button" class="btn btn-warning btn-lg btn-block">
							<span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Lista
						</button>
						<button type="button" class="btn btn-warning btn-lg btn-block">
							<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> Discounts
						</button>
	  				</div>
				</div>
    		</div>
    		<div class="col-xs-4">
	    		<div class="panel panel-default">
	  				<div class="panel-heading">
						<?php getEmployee(getUsuId())?>
	  				</div>
				</div>
				<div id="liveclock" style="background:#34495E;color:#fff;border-radius:10px;padding:5px 10px 5px 25px;" class="block"></div>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-xs-12">
    			<ul class="nav nav-tabs nav-justified" id="tablasProductos">
				  	<li role="presentation" class="active" id="busquedaProductosTab"><a href="#busquedaProductos" aria-controls="busquedaProductos" role="tab" data-toggle="tab">Productos</a></li>
				  	<li role="presentation" id="listaVentasTab"><a href="#listaVentas" aria-controls="listaVentas" role="tab" data-toggle="tab">Lista de Venta</a></li>
				</ul>
    			<div class="tab-content">
		    		<div id="busquedaProductos" class="panel panel-warning tab-pane fade in active" role="tabpanel">
	    				<div class="panel-heading">Resultados de Búsqueda</div>
	    				<div id="search_shoe_result" class="panel-body">
	    					<?php 
	    					getShoes(getBranchId()) 
	    					?>
	    				</div>
	  				</div>
	    			<div id="listaVentas" class="panel panel-warning tab-pane fade" role="tabpanel">
	    				<div class='panel-heading'>
							<p>
								Lista de Venta
								<button type="button" id="add-list-shoe-qr" class="btn btn-success pull-right"><i class='icon-qrcode icon-small'></i> Escanear QR</button>
								<button type="button" id="realizaVenta" class="btn btn-primary pull-right" ><span class='glyphicon glyphicon-new-window'></span> Realizar</button>						
							</p>
	    				</div>
	    				<div class='panel-body'>
	    					<?php 
	    					if(existSaleList(getUsuId())==0){
	    						getSaleList(getUsuId());
	    					}
							?>
	    					<table id="idTableSaleList" saleid="<?php echo existSaleList(getUsuId()) ?>" class="table table-striped">
		                    	<thead>
		                        	<tr>
		                            	<th>Modelo</th>
		                            	<th>Talla</th>
		                            	<th>Color</th>
		                            	<th>Precio</th>
		                            	<th>Acción</th>
		                            	<th>Adicional</th>
		                        	</tr>
		                    	</thead>
		        				<tbody>
		        					<?php 
			    					if(existSaleList(getUsuId())>0){
			    						getSaleList(getUsuId());
			    					}
									?>
		        				</tbody>
	        				</table>
	    				</div>
	  				</div>
	  			</div>
    		</div>
    	</div>
    </div>

    <?php include("footer.php"); ?>
	
	<div class="modal fade" id="modalSale" tabindex="-1" role="dialog" aria-labelledby="ModalSale">
  		<div class="modal-dialog modal-lg" role="document">
    		<div class="modal-content">
      			<div class="modal-header">
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        			<h4 class="modal-title">Detalle de Venta</h4>
      			</div>
      			<div id="services" class="modal-body">
        			<div class="row">
    					<div class="col-xs-6">
    						<div class="panel panel-default">
    							<div class='panel-heading'>Cliente</div>
    							<div class="panel-body">
    								<div class='media'>
		    							<div class='pull-left'><i class='icon-user icon-md'></i></div>
		    							<div id="datosCliente" class='media-body'></div>
		    						</div>
    							</div>
    						</div>
    					</div>
    					<div class="col-xs-6">
    						<p>Total:</p>
    						<div id="totalComponent"></div>
    					</div>
    				</div>
    				
    				<div class="row">
    					<div id="contenidoModal" class="col-xs-12">
    						<table id="getSaleTable" class="table table-striped">
			                    <thead>
			                        <tr>
			                            <th>Modelo</th>
			                            <th>Color</th>
			                            <th>Talla</th>
			                            <th>Precio</th>
			                            <th>Precio con descuento</th>
			                        </tr>
			                    </thead>
			                    <tbody>
			                    </tbody>
			            	</table>
    					</div>
    				</div>
    				
      			</div>
      			<div class="modal-footer">
      				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        			<button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
      			</div>
    		</div>
  		</div>
	</div>
	
	
	<div class="modal fade" id="modalDiscount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  		<div class="modal-dialog" role="document">
    		<div class="modal-content">
      			<div class="modal-header">
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        			<h4 class="modal-title">Descuentos</h4>
      			</div>
      			<div class="modal-body">
					<form>
  						<div class="form-group">
    						<label for="labelDiscount">Descuentos Disponibles</label>
    						<?php getDiscounts(0); ?>
  						</div>
					</form>
					<div id="testDiscount" class="alert alert-success" role="alert">...</div>
      			</div>
      			<div class="modal-footer">
      				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        			<button type="button" id="applicateDiscount" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
      			</div>
    		</div>
  		</div>
	</div>
	
	<div class="modal fade" id="clientModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  		<div class="modal-dialog modal-lg" role="document">
    		<div class="modal-content">
      			<div class="modal-header">
        			<button type="button" id="omiteClient" class="btn btn-default btn-small pull-right" data-dismiss="modal" aria-label="Omitir Cliente">Omitir Cliente <span class='glyphicon glyphicon-chevron-right'></span></button>
        			<h4 class="modal-title">Seleccionar Cliente</h4>
      			</div>
      			<div class="modal-body">
        			<ul class="nav nav-tabs nav-justified" id="sampleTabs">
					  	<li role="presentation" class="active" id="newClientTab"><a href="#newClient" aria-controls="newClient" role="tab" data-toggle="tab">Nuevo</a></li>
					  	<li role="presentation" id="tableClientTab"><a href="#tableClient" aria-controls="tableClient" role="tab" data-toggle="tab">Seleccionar</a></li>
					</ul>
					
					<div class="tab-content">
					    <div role="tabpanel" class="tab-pane fade in active" id="newClient">
					    	<form id="newClientForm">
    							<p>Llene los campos para dar de alta un nuevo cliente.</p>
  								<div class="form-group">
    								<label for="client_nombre_label">Nombres:</label>
    								<input type="text" class="form-control" id="client_name" name="client_name" placeholder="Nombre(s)" required>
  								</div>
  								<div class="form-group">
    								<label for="client_nombre_label">Apellido Paterno:</label>
    								<input type="text" class="form-control" id="client_lastname" name="client_lastname" placeholder="Apellido Paterno" required>
  								</div>
  								<div class="form-group">
    								<label for="client_nombre_label">Apellido Materno:</label>
    								<input type="text" class="form-control" id="client_matname" name="client_matname" placeholder="Opcional">
  								</div>
  								<div class="form-group">
    								<label for="client_email_label">Email:</label>
    								<input type="email" class="form-control" id="client_email" name="client_email" placeholder="Correo Electrónico" required>
  								</div>
  								<div class="form-group">
    								<label for="client_phone_label">Teléfono:</label>
    								<input type="number" class="form-control" id="client_phone" name="client_phone" placeholder="Celular o de Casa" required>
  								</div>
							</form>
					    </div>
					    <div role="tabpanel" class="tab-pane fade" id="tableClient">
					    	<table id="example" class="display" cellspacing="0" width="100%">
			                    <thead>
			                        <tr>
			                        	<th>Identificador</th>
			                            <th>Nombre</th>
			                            <th>Email</th>
			                            <th>Teléfono</th>
			                        </tr>
			                    </thead>
			                    <tbody>
			                    </tbody>
			            	</table>
			            </div>
					 </div>
      			</div>
      			<div class="modal-footer">
      				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        			<button type="button" id="saveClient" class="btn btn-primary">Aceptar</button>
      			</div>
    		</div>
  		</div>
	</div>
	
	<div class="modal fade" id="qr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  		<div class="modal-dialog modal-lg" role="document">
    		<div class="modal-content">
      			<div class="modal-header">
        			<button type="button" class="close stop-qr" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        			<h4 class="modal-title">Escanear código</h4>
      			</div>
      			<div class="modal-body">
					<div class="panel panel-info">
		                <div class="panel-heading">
	                        Seleccionar cámara: <select class="form-control" id="camera-select"></select>
		                </div>
		                <div class="panel-body text-center">
		                    <div class="col-md-6">
		                    	<input type="hidden" id="typeModalQR" value="">
		                        <div class="well" style="position: relative;display: inline-block;">
		                            <canvas width="320" height="240" id="webcodecam-canvas"></canvas>
		                            <div class="scanner-laser laser-rightBottom" style="opacity: 0.5;"></div>
		                            <div class="scanner-laser laser-rightTop" style="opacity: 0.5;"></div>
		                            <div class="scanner-laser laser-leftBottom" style="opacity: 0.5;"></div>
		                            <div class="scanner-laser laser-leftTop" style="opacity: 0.5;"></div>
		                        </div>
		                    </div>
		                    <div class="col-md-6">
		                        <div class="thumbnail" id="result">
		                            <div class="well">
		                                <img width="320" height="240" id="scanned-img" src="">
		                            </div>
		                            <div class="caption">
		                                <h3>Scanned result</h3>
		                                <p id="scanned-QR"></p>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		      		</div>
      			</div>
      			<div class="modal-footer">
      				<button type="button" class="btn btn-danger stop-qr" data-dismiss="modal">Cancelar</button>
        			<button type="button" class="btn btn-primary stop-qr" data-dismiss="modal">Aceptar</button>
      			</div>
    		</div>
  		</div>
	</div>
	
	<div class="modal fade" id="modalTransactions" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  		<div class="modal-dialog modal-xlg" role="document">
    		<div class="modal-content">
      			<div class="modal-header">
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        			<h4 class="modal-title">Transacciones</h4>
      			</div>
      			<div class="modal-body">
					<table id="transactionsList" class="table table-striped">
	                    <thead>
	                        <tr>
	                        	<th>Modelo</th>
	                        	<th>Color</th>
	                        	<th>Talla</th>
	                        	<th>Fecha de salida</th>
	                        	<th>Sucursal de Origen</th>
	                            <th>Sucursal de Destino</th>
	                            <th>Petición</th>
	                            <th>Envió</th>
	                            <th>Transportador</th>
	                            <th>Recibió</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    </tbody>
	            	</table>			            	
      			</div>
      			<div class="modal-footer">
      				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        			<button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
      			</div>
    		</div>
  		</div>
	</div>
	
	<?php include("js.php"); ?>
	<script src="js/funciones.js"></script>
	
</body>
</html>
<?php
}
ob_end_flush();
?>