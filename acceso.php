<?php

function iniciaSession(){
	
	ob_start();
	
	if($_POST){
		include("funciones.php");
		
		$usuario = __($_POST["nu"]);
		$password = __($_POST["pu"]);
		$email=limpiaEmail($usuario);
		
		if(empty($usuario)){
			exit("<p>ERROR. El campo <code><b>usuario</b></code> est&aacute; vacio. verif&iacute;calo</p>");
		}else if(!esEmail(limpiaEmail($usuario))){
			exit("<p>ERROR. El campo <code><b>usuario</b></code> debe ser un email v&aacute;lido. verif&iacute;calo</p>");
		}else if(empty($password)){
			exit("<p>ERROR. El campo <code><b>Password</b></code> est&aacute; vacio. verif&iacute;calo</p>");
		}else{
			$password=$password."#ercaj#";
			require_once("./conf/query.inc");
			$query=new Query();
			$us = $query->select("email","admin","email = '".sha1(limpiaEmail($usuario))."'","","arr");
			if($us[0]==sha1(limpiaEmail($usuario)))
			{
				$us = $query->select("password","admin","password = '".sha1(__($password))."'","","arr");
				if($us[0]==sha1(__($password)))
				{
					$us = $query->select("nombre, ap_pat","admin","email = '".sha1(limpiaEmail($usuario))."' and password = '".sha1(__($password))."'","","obj");
					if($us)
					{
						session_start();
						$_SESSION["pagInscripcionesErcaj"]=true;
						foreach ($us as $u) :
							$_SESSION["nombre"]=$u->nombre." ".$u->ap_pat;
							$_SESSION["email"]=$email;
						endforeach;
						header("Location:paginaInscritos.php");
					}else{
						header("Location:login.php?access=false");
					}
				}else{
					header("Location:login.php?access=false");
				}
			}else{
				header("Location:login.php?access=false");
			}
		}
	}
	else
	{
		#redirecciona si la pagina se carga directamente
		header("Location:login.php");
	}
	ob_end_flush();
}

?>