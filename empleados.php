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
    <title>Dolancy | Empleados</title>
</head>
<body>
    <?php include("menu_empleado.php"); ?>
	
    <div class="container-fluid">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="panel panel-primary">
	  				<div class="panel-body">
	  				
	  					<ul class="nav nav-tabs nav-justified" id="sampleTabs">
						  	<li role="presentation" class="active" id="newEmployeeTab"><a href="#newEmployee" aria-controls="newEmployee" role="tab" data-toggle="tab">Nuevo</a></li>
						  	<li role="presentation" id="tableEmployeeTab"><a href="#tableEmployee" aria-controls="tableEmployee" role="tab" data-toggle="tab">Seleccionar</a></li>
						</ul>
					
						<div class="tab-content">
						    <div role="tabpanel" class="tab-pane fade in active" id="newEmployee">
						    	<form id="newEmployeeForm">
	    							<p>Llene los campos para dar de alta un nuevo Empleado.</p>
	    							<div class="col-md-6">
	    								<div class="form-group">
		    								<label for="Employee_nombre_label">Nombres:</label>
		    								<input type="text" class="form-control" id="employee_name" name="employee_name" placeholder="Nombre(s)">
		  								</div>
		  								<div class="form-group">
		    								<label for="Employee_nombre_label">Apellido Paterno:</label>
		    								<input type="text" class="form-control" id="employee_lastname" name="employee_lastname" placeholder="Apellido Paterno">
		  								</div>
		  								<div class="form-group">
		    								<label for="Employee_nombre_label">Apellido Materno:</label>
		    								<input type="text" class="form-control" id="employee_matname" name="employee_matname" placeholder="Opcional">
		  								</div>
		  								<div class="form-group">
		    								<label for="Employee_direccion_label">Dirección:</label>
		    								<input type="text" class="form-control" id="employee_address" name="employee_address" placeholder="Dirección">
		  								</div>
	    							</div>
	    							<div class="col-md-6">
	    								<div class="form-group">
		    								<label for="Employee_email_label">Email:</label>
		    								<input type="email" class="form-control" id="employee_email" name="employee_email" placeholder="Correo Electrónico">
		  								</div>
		  								<div class="form-group">
		    								<label for="Employee_phone_label">Teléfono:</label>
		    								<input type="number" class="form-control" id="employee_phone" name="employee_phone" placeholder="Celular o de Casa" maxlength="10">
		  								</div>
		  								<div class="form-group">
		    								<label for="Employee_phone_label">Tipo de Empleado:</label>
		    								<select id="employee_type" name="employee_type" class="form-control">
		    									<option value="">Seleccione una opción</option>
		    									<option value="0">Vendedor</option>
		    									<option value="1">Gerente</option>
		    									<option value="2">Director</option>
		    								</select>
		  								</div>
		  								<div class="form-group">
	    									<label for="color_label">Sucursal: </label>
	    									<?php getBranchs(); ?>
	  									</div>
	    							</div>
	  								
	  								<button type="button" id="saveEmployee" class="btn btn-primary">Guardar</button>
								</form>
						    </div>
						    <div role="tabpanel" class="tab-pane fade" id="tableEmployee">
						    	<?php getAllEmployees(); ?>
						    </div>
					    </div>
	  				</div>
				</div>
    		</div>
    	</div>
    </div>

    <?php include("footer.php"); ?>
	<?php include("js.php"); ?>
	<script src="js/funciones.employees.js"></script>
	
</body>
</html>
<?php
}
ob_end_flush();
?>