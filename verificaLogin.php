<?php
ob_start();
if($_POST)
{
	include("acceso.php");
	include("funcionesLogin.php");

	iniciaSession();
}else{
	header("Location:./");
}
ob_end_flush();
?>