<?php
@session_start();
function isLogin()
{
	if($_SESSION["pagInscripcionesErcaj"]==true)
	{
		return true;
	}else{
		return false;
	}
}

function esAdministrador()
{
	if($_SESSION["pagInscripcionesErcaj"])
		if($_SESSION["type"]=="Administrador")
			return true;
		else
			return false;
	else
		return false;
}

function esSuper()
{
	
	if($_SESSION["on"])
	{
		if($_SESSION["type"]=="Super Administrador")
			return true;
		else
			return false;
	}
	else
		return false;
}
function toggleLogin()
{
	
	if(isLogin())
	{
		echo '<li><a href="logout.php"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> '.$_SESSION["nombre"]. '<span> | Cerrar Sesión</span></a></li>';
	}
	else
	{
		echo '<li><a href="login.php">Iniciar Sesión</span></a></li>';
	}
}
?>