<?php
include 'config.php';
class Conexion
{
	protected $idConexion;

    function __construct()
	{
        $this->idConexion = mysql_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PASS);
		if($this->idConexion)
		{
			if(RESULTTRACE) print("<p>Conexi&oacute;n exitosa a MySQL.</p>");
			if(mysql_select_db(MYSQL_NAME,$this->idConexion))
			{
				if(RESULTTRACE) print("<p>Ha sido seleccionada correctamente la base de datos: ".MYSQL_NAME."</p>");	
				return $this->idConexion;	
			}
			else
			{
				exit("<p>ERROR en MySQL</p>
					<p>Error No:  ".mysql_errno()."</p>
					<p>ERROR:  ".mysql_error()."</p>
					<p>Archivo. ".__FILE__."</p>
					<p>Linea: ".__LINE__."</p>
					<p>Clase: ".__CLASS__."</p>
					<p>Funcion: ".__FUNCTION__."</p>
					<p>Metodo: ".__METHOD__."</p>
					<p>Scrip PHP: ".$_SERVER['PHP_SELF']."</p>");
			}
		}
		else
		{
			exit("<p>ERROR en MySQL</p>
					<p>Error No:  ".mysql_errno()."</p>
					<p>ERROR:  ".mysql_error()."</p>
					<p>Archivo. ".__FILE__."</p>
					<p>Linea: ".__LINE__."</p>
					<p>Clase: ".__CLASS__."</p>
					<p>Funcion: ".__FUNCTION__."</p>
					<p>Metodo: ".__METHOD__."</p>
					<p>Scrip PHP: ".$_SERVER['PHP_SELF']."</p>");
		}
	}

	function __destruct()
	{
		if($this->idConexion)
		{	
			mysql_close($this->idConexion);
			if(RESULTTRACE) print("<p>Conexion a MySQL cerrada.</p>");
            return true;
		}
	}
}
?>
