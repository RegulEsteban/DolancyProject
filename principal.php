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
						<p>Ver lista de ventas de hoy</p>
	    				<a target="_self" href="#" class="btn btn-primary btn-lg"><i class="icon-list icon-small"></i> Lista de hoy</a>
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
    				<div class='panel-heading'>
						<p>
							Listas de Venta
							<button type="button" class="btn btn-success pull-right"><i class='icon-qrcode icon-small'></i> Escanear QR</button>
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

    <?php include("footer.php"); ?>
	
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  		<div class="modal-dialog" role="document">
    		<div class="modal-content">
      			<div class="modal-header">
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        			<h4 class="modal-title">Error</h4>
      			</div>
      			<div class="modal-body">
        			<div id="modalTitle" class='alert alizarin' role='alert'>...</div>
      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
      			</div>
    		</div>
  		</div>
	</div>
	
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
    						
    						<div class='media'>
    							<div class='pull-left'><i class='icon-user icon-md'></i></div>
    							<div class='media-body'>
    								<h3>Cliente</h3>
    								<i class='icon-user icon-small'></i> Nombre: <br/>
    								<i class='icon-envelope icon-small'></i> Email: <br/>
    								<i class='icon-phone icon-small'></i> Teléfono: <br/>
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
    								<input type="text" class="form-control" id="client_name" placeholder="Nombre(s)" required>
  								</div>
  								<div class="form-group">
    								<label for="client_nombre_label">Apellido Paterno:</label>
    								<input type="text" class="form-control" id="client_lastname" placeholder="Apellido Paterno" required>
  								</div>
  								<div class="form-group">
    								<label for="client_nombre_label">Apellido Materno:</label>
    								<input type="text" class="form-control" id="client_matname" placeholder="Opcional">
  								</div>
  								<div class="form-group">
    								<label for="client_email_label">Email:</label>
    								<input type="email" class="form-control" id="client_email" placeholder="Correo Electrónico" required>
  								</div>
  								<div class="form-group">
    								<label for="client_phone_label">Teléfono:</label>
    								<input type="text" class="form-control" id="client_phone" placeholder="Celular o de Casa" required>
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
	
	<?php include("js.php"); ?>
	
</body>
</html>
<?php
}
ob_end_flush();
?>