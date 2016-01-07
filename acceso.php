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
			$password=$password."#dolancy100291#";
			require_once("./conf/query.inc");
			$query=new Query();
			$us = $query->select("email","user_credentials","email = '".sha1(limpiaEmail($usuario))."'","","arr");
			if($us[0]==sha1(limpiaEmail($usuario)))
			{
				$us = $query->select("password","user_credentials","password = '".sha1(__($password))."'","","arr");
				if($us[0]==sha1(__($password)))
				{
					$credentials = $query->select("email, password, employeeid","user_credentials","email = '".sha1(limpiaEmail($usuario))."' and password = '".sha1(__($password))."'","","obj");
					if(count($credentials)==1){
						foreach ($credentials as $c){
							$em = $query->select("firstname, lastname","employee","employeeid = '".$c->employeeid."'","","obj");
							if(count($em)==1){
								session_start();
								$_SESSION["dolancySession"]=true;
								foreach ($em as $u) :
								$_SESSION["nombre"]=$u->firstname." ".$u->lastname;
								$_SESSION["email"]=$u->email;
								endforeach;
								header("Location:Bienvenido");
							}else{
								header("Location:admin-denegado");
							}
						}
					}else{
						header("Location:admin-denegado");
					}
				}else{
					header("Location:admin-denegado");
				}
			}else{
				header("Location:admin-denegado");
			}
		}
	}else{
		#redirecciona si la pagina se carga directamente
		header("Location:admin");
	}
	ob_end_flush();
}

?>