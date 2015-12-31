<?php 
/*
 * 1 verificar error
 * 2 verificar extension
 * 3 verificar tama�o 
 * 4 cambiar nombre
 * 5 copiar archivo
*/ 

class Documento
{		
	/*$_FILES["imagen"]["error"];# 1 al 6
	$_FILES["imagen"]["tmp_name"]; #c:/temp/php01ax.jpg
	$_FILES["imagen"]["name"]; #micky mouse.jpg
	$_FILES["imagen"]["size"]; #12324 = 12Kb
	$_FILES["imagen"]["type"];# image/jpg*/
		
	public $archivo;
	public $error;
	public $nombre;
	public $tamano;
	public $tipo;
	public $destino;
	public $titulo;
	
	private $extension;
	
	function __construct(){
	}
	function __destruct() {
	}
	
	function verificaError()
	{
		if($this->error>0)
		{
			exit("<p>ERROR al subir archivo</p>");
		}
		else
		{
			return TRUE;
		}
	}
	
	
	function verificaExtension()
	{
		//global $extensionPermitidasImg;
                $extensionPermitidasImg = array("jpg","bmp","png","gif","jpeg");
		if (in_array(end(explode(".",$this->nombre)),$extensionPermitidasImg))
		{
			$this->extension = end(explode(".",strtolower($this->nombre)));
			return TRUE;
		}
		else
		{
			exit ("<p> ERROR. Tipo de archivo no v&aacute;lido, s&oacute;lo se permiten
					extenciones: ".implode(", ",$extensionPermitidasImg)."</p>");
		}
	}
	
	
	function cambiarNombre()
	{
		$acento = array("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&ntilde;","&Aacute;","&Eacute;","&Iacute;","&Oacute;","&Uacute;","&Ntilde;");
		$sinacento  = array('a','e','i','o','u','n','A','E','I','O','U','N');
		$prefijo = substr(md5(uniqid(rand())),0,5);
		$this->titulo = str_replace($acento,$sinacento,$this->titulo);
		$this->titulo = preg_replace("/[^a-z0-9-_.]/i", "", $this->titulo);
		$this->nombre = preg_replace("/[^a-z0-9-_.]/i", "", $this->nombre);
		$this->nombre = str_replace($this->nombre,"_",$this->nombre);
		$this->nombre = str_replace("_",$this->titulo.".".$this->extension,$this->nombre);
		$this->nombre = strtolower($this->nombre);
		$this->nombre = str_replace($acento,$sinacento,$this->nombre);
		$this->nombre = str_replace(" ","_",$this->nombre);
		$this->nombre= $prefijo."_".$this->nombre;
		//echo $this->nombre;
		return TRUE;
	}
	
	function copia()
	{
		if(move_uploaded_file($this->archivo,$this->destino."/".$this->nombre))
		{
			unset($this->archivo);
			@unlink($this->archivo);
			return TRUE;
		}
		else
		{
			exit("<p>ERROR. El archivo no puede ser copiado, intenta nuevamente.");
		}
	}
}
?>