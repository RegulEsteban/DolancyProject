<?php
@session_start();
function isLogin() {
	if($_SESSION["dolancySession"]==true){
		return true;
	}else{
		return false;
	}
}

function esAdministrador(){
	if($_SESSION["dolancySession"])
		if($_SESSION["type_usu"]==1)
			return true;
		else
			return false;
	else
		return false;
}

function esSuper() {
	
	if($_SESSION["dolancySession"]) {
		
		if($_SESSION["type_usu"]==0)
			return true;
		else
			return false;
	}else
		return false;
}

function getUsuId(){
	if($_SESSION["dolancySession"]){
		return $_SESSION["employeeid"];
	}else{
		return 0;
	}
}

function getBranchId(){
	if($_SESSION["dolancySession"]){
		return $_SESSION["branchid"];
	}else{
		return 0;
	}
}

function toggleLogin()
{
	if(isLogin()) {
		echo '<li><a href="logout.php"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> '.$_SESSION["nombre"]. '<span> | Cerrar Sesión</span></a></li>';
	}else{
		echo '<li><a href="login.php">Iniciar Sesión</span></a></li>';
	}
}
?>