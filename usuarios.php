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
    <title>Dolancy | Usuarios</title>
</head>
<body>
    <?php include("menu_empleado.php"); ?>
	
    <div class="container-fluid">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="panel panel-default">
    				<div class="panel-heading">
    					<h1>Usuarios</h1>
    				</div>
	  				<div class="panel-body">
	  					<ul class="nav nav-tabs nav-justified" id="sampleTabs">
						  	<li role="presentation" class="active" id="newUserTab"><a href="#newUser" aria-controls="newUser" role="tab" data-toggle="tab">Nuevo</a></li>
						  	<li role="presentation" id="tableUsersTab"><a href="#tableUsers" aria-controls="tableUsers" role="tab" data-toggle="tab">Seleccionar</a></li>
						</ul>
					
						<div class="tab-content">
						    <div role="tabpanel" class="tab-pane fade in active" id="newUser">
						    	<form id="newUserForm">
	    							<p>Llene los campos para dar de alta un nuevo Usuario.</p>
	    							<div class="col-md-6">
	    								<div class="form-group">
		    								<label for="Usu_email_label">Email:</label>
		    								<input type="email" class="form-control" id="usu_email" name="usu_email" placeholder="Correo Electrónico">
		  								</div>
	    								<div class="form-group">
		    								<label for="Usu_password_label">Password:</label>
		    								<input type="password" class="form-control" id="usu_pass" name="usu_pass" placeholder="Password">
		  								</div>
	    							</div>
	    							<div class="col-md-6">
		  								<div class="checkbox">
    										<label><input type="checkbox" checked="checked" id="usu_check" name="usu_check"> ¿Activo?</label>
  										</div>
		  								<div class="form-group">
	    									<label for="color_label">Empleado: </label>
	    									<?php getEmployeesList(); ?>
	  									</div>
	    							</div>
	  								
	  								<button type="button" id="saveUsu" class="btn btn-primary">Guardar</button>
								</form>
						    </div>
						    <div role="tabpanel" class="tab-pane fade" id="tableUsers">
						    	<?php getAllUsers(); ?>
						    </div>
					    </div>
	  				</div>
				</div>
    		</div>
    	</div>
    </div>

    <?php include("footer.php"); ?>
	<?php include("js.php"); ?>
	<script src="js/funciones.usuarios.js"></script>
	
</body>
</html>
<?php
}
ob_end_flush();
?>