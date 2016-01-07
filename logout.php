<?php
session_start();
session_destroy();
/*echo"<h1 aign='center'>Usted se ha desloggeado Correctamente.</h1>
	<p><h2>El equipo de <b>Librer&iacute;as B&eacute;cquer</b>  agradece su trabajo.</h2></p>
	<p><h2>Esperamos verle pronto.</h2></p>
";*/
header("Location:admin-bye"); 
?>
