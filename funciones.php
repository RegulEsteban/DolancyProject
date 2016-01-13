<?php
include_once './conf/query.inc';
#Limpia los datos
function __($var)
{
	$dato =	htmlentities($var,ENT_QUOTES,'UTF-8');
	$dato = stripslashes($dato);
	return trim($dato);
}

function optionEdad()
{
	echo "<select name='edad' class='form-control' id='edad'>
			<option value='0' selected='selected'>Seleciona tu edad</option>";
		for($i=13;$i<=40;$i++)
		{
			echo "<option value='".$i."'>".$i."</option>";
		}
	echo "</select>";
}

function consultaEstados() {
    $query = new query();
    $estados = $query->select("*", "estado");

    if ($estados) {
        echo '<select name="estado" class="form-control" id="estado">
        			<option value="0" selected="selected">Seleciona el Estado</option>';
        foreach ($estados as $estado) {
            echo '<option value="' . $estado->id . '">' . utf8_encode($estado->nombre) . '</td>';
        }
        echo '</select>';
    }
}

function letras($param) {
    $namefields = "/^[a-zA-Z������������\-\s]+$/";
    if (preg_match($namefields, $param))
        return false;
    else
        return true;
}

function numeros($param) {
    $namefields = "/^[[:digit:]]+$/";
    if (preg_match($namefields, $param))
        return true;
    else
        return false;
}

function numerosLestras($param) {
    $namefields = "/^[a-zA-Z0-9������������\-\s]+$/";
    if (preg_match($namefields, $param))
        return false;
    else
        return true;
}

function esEmail($email = "") {
    $car = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
    if (strpos($email, '@') !== false && strpos($email, '.') !== false) {
        if (preg_match($car, $email)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function limpiaEmail($email) {
    $limpio = preg_replace('/[^a-z0-9+_.@-]/i', '', $email);
    return strtolower($limpio);
}

function validaCadena2($var) {
    $patron = "/^[a-zA-Z0-9_-áéíóú\s]+$/";
    if (preg_match($patron, $var))
        return true;
    else
        false;
}

function codificaMail($email="")
{
	$mailCodificado = "";
    for ($i=0; $i < strlen($email); $i++)
	{
        if(rand(0,1) == 0)
		{
            $mailCodificado .= "&#" . (ord($email[$i])) . ";";
        }
		else
		{
            $mailCodificado .= "&#X" . dechex(ord($email[$i])) . ";";
        }
    }
	return $mailCodificado;
}


function getColors(){
	$query=new Query();
	$values = $query->select("colorid, title","color","view_type = 1","","obj");
	if(count($values)>0){
		echo "<select id='color_select' name='color_select' class='form-control'>";
		echo "<option value='0' selected>Seleccione un color</option>";
		foreach ($values as $color){
			echo "<option value='".$color->colorid."'>".$color->title."</option>";
		}
		echo "</select>";
	}else{
		echo "<div class='alert alizarin' role='alert'>No hay colores por mostrar.</div>";
	}
	
}

function getSizes(){
	$query=new Query();
	$values = $query->select("sizesid, size","sizes","1=1","","obj");
	if(count($values)>0){
		echo "<select id='size_select' name='size_select' class='form-control'>";
		echo "<option value='0' selected>Seleccione una talla</option>";
		foreach ($values as $size){
			echo "<option value='".$size->sizesid."' >".$size->size."</option>";
		}
		echo "</select>";
	}else{
		echo "<div class='alert alizarin' role='alert'>No hay tallas por mostrar.</div>";
	}
}

function getModels(){
	$query=new Query();
	$values = $query->select("modelid, title","model","view_type = 1","","obj");
	if(count($values)>0){
		echo "<select id='model_select' name='model_select' class='form-control'>";
		echo "<option value='0' selected>Seleccione un modelo</option>";
		foreach ($values as $model){
			echo "<option value='".$model->modelid."'>".$model->title."</option>";
		}
		echo "</select>";
	}else{
		echo "<div class='alert alizarin' role='alert'>No hay modelos por mostrar.</div>";
	}
}

function getDiscounts($type){
	$query=new Query();
	$values = $query->select("discountid, monto, description","cash_discount","type = $type","","obj");
	if(count($values)>0){
		echo "<select id='discount_select' name='discount_select' class='form-control'>";
		echo "<option value='0' selected>Seleccione un descuento</option>";
		foreach ($values as $d){
			echo "<option value='".$d->discountid."' monto='".$d->monto."'>".$d->description."</option>";
		}
		echo "</select>";
	}else{
		echo "<div class='alert alizarin' role='alert'>No hay descuentos disponibles.</div>";
	}
}

function getEmployee($employeeid){
	$query=new Query();
	$values = $query->select("e.firstname, e.lastname, e.matname, e.email, e.phone, e.address, e.type_employee, b.name branch_name, b.address","employee e join branch b on b.employeeid = e.employeeid","e.employeeid = $employeeid ","","obj");
	
	if(count($values)==1){
		echo "<div class='media'><div class='pull-left'><i class='icon-user icon-md'></i></div><div class='media-body'>";
		foreach ($values as $em){
			echo "<h4 class='media-heading'>".utf8_encode($em->firstname.' '.$em->lastname.' '.$em->matname)."</h4>
				<i class='icon-home icon-small'></i> Dirección: ".utf8_encode($em->address)."<br/>
				<i class='icon-phone icon-small'></i> Teléfono: ".$em->phone."<br/>
				<i class='icon-envelope icon-small'></i> Email: ".$em->email."<br/>";
		}
		echo "</div></div>";
		
		echo "<div class='media'><div class='pull-left'><i class='icon-building icon-md'></i></div><div class='media-body'>";
		foreach ($values as $em){
			echo "<h4>Sucursal</h4>
					<i class='icon-tag icon-small'></i> Nombre: ".$em->branch_name."<br/>
					<i class='icon-map-marker icon-small'></i> Dirección: ".$em->address."<br/>";
		}
		echo "</div></div>";
	}else{
		echo "<div class='alert alizarin' role='alert'>Error al consultar empleado.</div>";
	}
}

function existSaleList($employeeid){
	$query = new Query();
	$ventas = $query->select("saleid", "sale", "employeeid = $employeeid", "and status=0", "obj");
	if(count($ventas)==1){
		foreach ($ventas  as $venta){
			return $venta->saleid;
		}
	}else{
		return 0;
	}
}

function getSaleList($employeeid){
	$query = new Query();
	$ventas = $query->select("saleid, employeeid, client_opid, total", "sale", "employeeid = $employeeid", "and status=0", "obj");
	if(count($ventas)==1){
		foreach ($ventas as $venta){
			$stocks = $query->select("shoe.price, m.title as model, c.title as color, z.size as size, s.stockid as id ",
									"detail_sale ds
									join detail_stock s on ds.stockid = s.stockid
									join shoe on s.shoeid = shoe.shoeid
									join model m on m.modelid = shoe.modelid
									join sizes z on z.sizesid = shoe.sizesid
									join color c on c.colorid = shoe.colorid",
									"ds.saleid = $venta->saleid ", "", "obj");
			if(count($stocks)>0){
				foreach ($stocks as $stock){
					echo '<tr>
                  			<td>'.$stock->model.'</td>
                  			<td>'.$stock->size.'</td>
                  			<td>'.$stock->color.'</td>
                  			<td>'.$stock->price.'</td>
                  			<td><a href="#" class="removeShoeSaleList" stockid='.$stock->id.'><span class="glyphicon glyphicon-remove"></span> Eliminar</a></td>
						</tr>';
				}
			}
		}
	}else{
		echo "<div id='noResultSaleList' class='alert alizarin' role='alert'>No hay resultados para la búsqueda.</div>";
	}
}

function getShoes($branchid){
	$query = new Query();
	$stocks = $query->select("s.stockid as id, shoe.price as price, m.title as model, c.title as color, z.size as size, b.name as branch_name, b.address as branch_address, s.status",
			"detail_stock s
			join shoe on s.shoeid = shoe.shoeid
			join model m on m.modelid = shoe.modelid
			join sizes z on z.sizesid = shoe.sizesid
			join color c on c.colorid = shoe.colorid
			join branch b on b.branchid = s.branchid",
			"b.branchid = $branchid and s.status = 0 or s.status = 1 or s.status = 3 order by s.status","", "obj");
	 
	if(count($stocks)>0){
		echo "<table id='tableShoes' class='table table-striped'><thead><tr>
				<th>Modelo</th>
				<th>Talla</th>
				<th>Color</th>
				<th>Precio</th>
				<th>Sucursal</th>
				<th>Agregar</th>
				</tr></thead><tbody>";
		foreach ($stocks as $stock){
			echo '<tr>
                  	<td>'.$stock->model.'</td>
                  	<td>'.$stock->size.'</td>
                  	<td>'.$stock->color.'</td>
                  	<td class="viewDiscount">'.$stock->price.'</td>
                  	<td><code>'.$stock->branch_name.'</code> <i class="icon-home icon-small"></i> '.$stock->branch_address.'</td>';
			if($stock->status==1){
				echo '<td><i class="icon-frown icon-small"></i> No disponible</td>';
			}else{
				echo '<td><a href="#" class="addShoeList" stockid='.$stock->id.'><span class="glyphicon glyphicon-plus"></span> Lista de Venta</a></td>';
			}
			echo '</tr>';
		}
		echo "</tbody></table>";
	}else{
		echo "<div class='alert alizarin' role='alert'>No hay resultados para la búsqueda.</div>";
	}
}

function editaDatos($tabla,$donde)
{
	include_once ("Query.inc");
	$query=new Query();
	$valores=$query->select("id_inscripciones,nombre,edad,estado,fecha_inscripcion,telefono,email_muestra,facebook,genero", $tabla,$donde);
	echo  "<form class='form-horizontal' role='form' action='modificaReg.php' method='post'>";
		if($valores)
		{
			foreach ($valores as $valor)
			{
				$valor->id_inscripciones;
				$valor->nombre;
				$valor->edad;
				$valor->estado;
				$valor->fecha_inscripcion;
				$valor->telefono;
				$valor->email_muestra;
				$valor->facebook;
				$valor->genero;
			}
			
			echo "
			<div class='form-group'>
		    <label class='col-sm-2 control-label'>Id: </label>
		    <div class='col-sm-10'>
		      <input type='text' class='form-control' name='id' value=".$valor->id_inscripciones." required>
		    </div>
		 </div>
  		<div class='form-group'>
		    <label class='col-sm-2 control-label'>Nombre Completo:</label>
		    <div class='col-sm-10'>
		      <input type='text' class='form-control' name='nombre' value=".$valor->nombre." required>
		    </div>
		 </div>
      	  <div class='form-group'>
		    <label for='inputEmail3' class='col-sm-2 control-label'>Email:</label>
		    <div class='col-sm-10'>
		      <input type='email' name='email' class='form-control' value=".$valor->email." required>
		    </div>
		  </div>
		  <div class='form-group'>
		    <label class='col-sm-2 control-label'>Tel�fono:</label>
		    <div class='col-sm-10'>
		      <input type='text' name='telefono' class='form-control' value=".$valor->telefono." maxlength='10' required>
		    </div>
		  </div>
		  <div class='form-group'>
		    <label class='col-sm-2 control-label'>Facebook:</label>
		    <div class='col-sm-10'>
		      <input type='text' name='facebook' class='form-control' placeholder='Nombre de la cuenta' required>
		    </div>
		  </div>
		  <div class='form-group'>
      		<label class='col-sm-2 control-label'>Koinonia:</label>
		    <div class='col-sm-10' id='prueba'>".dameKoinonia(''.$valor->genero.'')."</div>
		  </div>
		  <div class='form-group'>
		    <label class='col-sm-2 control-label'>Genero:</label>
		    <div class='col-sm-10' id='setGenero'>
		      <input type='text' name='genero' value=".$valor->genero." class='form-control' maxlength='1'>
		    </div>
		  </div>
		  <div class='form-group'>
		    <div class='col-sm-offset-2 col-sm-10'>
		      <button type='submit' class='btn btn-default'>Inscribir</button>
		    </div>
		  </div></form>";


		}
}

function actualizaRegistroEditado()
{
	$id = __($_POST["id"]);
	$nombre = __($_POST["nombre"]);
	$telefono = __($_POST["telefono"]);
	$email = __($_POST["email"]);
	$facebook = __($_POST["facebook"]);
	
	if(empty($nombre))
	{
		exit("<p>UPSS!!!. El campo <code><b>Nombre</b></code> est&aacute; vacio. Verif&iacute;calo</p>
			<br/>
			<b><a href='modificaReg.php?id=$id'>Regresar</a></b>");
	}else if(empty($email))
	{
		exit("<p>UPSS!!!. El campo <code><b>E-mail</b></code> debe ser v&aacute;lido. Verif&iacute;calo</p>
			<br/>
			<b><a href='modificaReg.php?id=$id'>Regresar</a></b>");
	}else if(!esEmail(limpiaEmail($email)))
	{
			exit("<p>UPSS!!!. El campo <code><b>E-Mail</b></code> debe ser v&aacute;lido. Verif&iacute;calo</p>
				<br/>
				<b><a href='modificaReg.php?id=$id'>Regresar</a></b>");
	}else{
		$nombre = __($nombre);
		$email = limpiaEmail($email);
	}
	
	require_once ("Query.inc");  //Ya no lo necesita se agrego en la funcion siExiste
	$query=new Query();
	if($corralito=='0')
	{
		if($query->updateMultiple("inscripciones","nombre = '$nombre',telefono = '$telefono',forma_pago = '$forma_pago',
						pago = '$pago',email_muestra = '$email',facebook = '$facebook',twitter = '$twitter',cd = '$cd'"
						,"id_inscripciones = '$id'"))
		{
			echo "<p>Datos Actualizados</p>
			<b><a href='paginaInscritos.php'>Ir a Inicio</a></b>";
		}
	}else{
		if($query->updateMultiple("inscripciones","nombre = '$nombre',telefono = '$telefono',forma_pago = '$forma_pago',
						pago = '$pago',email_muestra = '$email',facebook = '$facebook',twitter = '$twitter',
						cd = '$cd', corralito = '$corralito'"
						,"id_inscripciones = '$id'"))
		{
			echo "<p>Datos Actualizados</p>
			<b><a href='paginaInscritos.php'>Ir a Inicio</a></b>";
		}
	}
}

function siExiste($campo,$tabla,$email)
{
	include_once ("./conf/query.inc");
	$queryExiste=new Query();
	$valores=$queryExiste->select($campo, $tabla,$email);
		if($valores)
		{
			foreach ($valores as $valor)
			{
				return TRUE;
			}
		}
	return FALSE;
}

function guardaArchivo($carpeta,$titulo)
{
	include_once("Documento.inc");
	$img = new Documento();
	$img->archivo = $_FILES["url_imagen"]["tmp_name"];
	$img->error = $_FILES["url_imagen"]["error"];
	$img->nombre = $_FILES["url_imagen"]["name"];
	$img->tamano = $_FILES["url_imagen"]["size"];
	$img->tipo = $_FILES["url_imagen"]["type"];
	$img->destino = $carpeta;
	$img->titulo = $titulo;
	if($img->verificaError())
		if($img->verificaExtension())
			if($img->cambiarNombre())
				if($img->copia())
	{
		return $img->destino."/".$img->nombre;
	}else{
		echo "Con errores";
	}
}

function envioCorreoEfectivo($nombre,$email)
{
	$titulo = "Pre-Inscripci�n E.R.Ca.J. M&eacute;xico 2012";
	$mensaje = "
<br><div><div dir='ltr'><div><div dir='ltr'><div><table border='0' cellpadding='40' cellspacing='0' width='98%'><tbody><tr><td style='font-family:lucida grande,tahoma,verdana,arial,sans-serif' bgcolor='#f7f7f7' width='100%'><table border='0' cellpadding='0' cellspacing='0' width='620'><tbody><tr><td style='background:#F2F2F2;color:#3b5998;font-weight:bold;font-family:lucida grande,tahoma,verdana,arial,sans-serif;border-left:1px solid #3b5998;border-right:1px solid #3b5998;border-top:1px solid #3b5998;border-bottom:#2D2D2D solid 8px;vertical-align:middle;padding:10px 40px;font-size:24px;letter-spacing:2px;text-align:left'>
<a href='http://www.ercaj.org/inscripcionesercaj.php' style='color:#3b5998;text-decoration:none' target='_blank'>
Pre-Inscripci&oacute;n E.R.Ca.J. M&eacute;xico.
</a>
</td>
</tr>
<tr>
<td colspan='2' style='background-color:#FFFFFF;border-bottom:1px solid #3b5998;border-left:1px solid #CCCCCC;border-right:1px solid #CCCCCC;font-family:lucida grande,tahoma,verdana,arial,sans-serif;padding:15px' valign='top'>
<table width='100%'>
<tbody>
<tr>
<td style='font-size:16px' align='left' valign='top' width='470px'><div style='margin-bottom:15px;font-size:14px'>
Hola, $nombre:
</div>
<div style='margin-bottom:15px'>PROCESO DE PAGO: En Efectivo
<br>
<br>

<span style='color:#333333'>
Acudir a la siguiente direcci&oacute;n para realizar el pago en efectivo a:
</span>
<span style='color:#333333'>
<ul>
<li style='padding-top:15px'>
Chocolateria Samper's
<br>
<span style='color:#333333'>
Paseo Col�n No. 304 Enfrente de la Casa del Gobernador<br/>
Toluca, Estado de M&eacute;xico.
</span>
</li>
</ul>
</span>
<br>

</div><div style='margin-bottom:15px'>
Gracias.
<br>
<br>
Inscripciones E.R.Ca.J. M&eacute;xico
<br>
<br>
'Creo Se&ntilde;or Aumenta mi Fe'
<br>
<br>
<br>
<table style='border-collapse:collapse' cellpadding='0' cellspacing='0'>
<tbody>
<tr>
<td style='padding:10px;background-color:#F2F2F2;border-left:1px solid #3b5998;border-right:1px solid #3b5998;border-top:1px solid #3b5998;border-bottom:#2D2D2D solid 4px'>
<a href='http://www.ercaj.org/' style='color:#3b5998;text-decoration:none' target='_blank'>
Ir al Sitio Oficial del E.R.Ca.J.
</a>
</td>
</tr>
</tbody>
</table>
</div>
</td>
<td style='padding-left:15px' align='left' valign='top' width='150'>
<table style='border-collapse:collapse' cellpadding='0' cellspacing='0'>
<tbody>
<tr>
<td style='padding:2px;background-color:#2D2D2D;border-left:0px solid #e2c822;border-right:0px solid #e2c822;border-top:0px solid #e2c822;border-bottom:0px solid #e2c822'>
<table style='border-collapse:collapse' cellpadding='0' cellspacing='0'>
<tbody>
<tr>
<td style='border-width:1px;border-style:solid;border-color:#3b6e22 #3b6e22 #2c5115;background-color:#F2F2F2'>
<table style='border-collapse:collapse' cellpadding='0' cellspacing='0'>
<tbody>
<tr>
<td style='font-size:11px;font-family:lucida grande, tahoma, verdana, arial, sans-serif;padding:4px 10px 5px;border-top:1px solid #fff'>
<a href='http://www.ercaj.org/inscripcionesercaj.php' style='color:#F2F2F2;text-decoration:none' target='_blank'>
<span style='font-weight:bold;color:#fff;font-size:13px'>
<img src='http://www.ercaj.org/imagenes/logo.jpg' style='border:0;width;140px;height:140px'>
</span></a></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr>
<td colspan='2' style='color:#999999;padding:10px;font-size:12px;font-family:lucida grande,tahoma,verdana,arial,sans-serif;padding:10px;border-top:0px solid #3b5998;border-bottom:#2D2D2D solid 2px'>
El mensaje se envi� a $email. Dudas o Aclaraciones contactanos: ercajmexico@hotmail.com
http://www.ercaj.org
Encuentro Renovado Cat�lico Juvenil.
</td></tr></tbody></table></td></tr></tbody></table></div></div></div> </div></div>
	";

	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=utf-8\n";
	$headers .= "From: Pre-Inscipciones E.R.Ca.J. M�xico 2012 <contacto@ercaj.org>";
	echo $email;
	mail($email,$titulo,$mensaje,$cabeceras) or die ("Su mensaje no se envio.");
}

function envioCorreoTransferencia($nombre,$email)
{
	$titulo = "Pre-Inscripci�n E.R.Ca.J. M&eacute;xico 2012";
	$mensaje = "
<br><div><div dir='ltr'><div><div dir='ltr'><div><table border='0' cellpadding='40' cellspacing='0' width='98%'><tbody><tr><td style='font-family:lucida grande,tahoma,verdana,arial,sans-serif' bgcolor='#f7f7f7' width='100%'><table border='0' cellpadding='0' cellspacing='0' width='620'><tbody><tr><td style='background:#F2F2F2;color:#3b5998;font-weight:bold;font-family:lucida grande,tahoma,verdana,arial,sans-serif;border-left:1px solid #3b5998;border-right:1px solid #3b5998;border-top:1px solid #3b5998;border-bottom:#2D2D2D solid 8px;vertical-align:middle;padding:10px 40px;font-size:24px;letter-spacing:2px;text-align:left'>
<a href='http://www.ercaj.org/inscripcionesercaj.php' style='color:#3b5998;text-decoration:none' target='_blank'>
Pre-Inscripci&oacute;n E.R.Ca.J. M&eacute;xico.
</a>
</td>
</tr>
<tr>
<td colspan='2' style='background-color:#FFFFFF;border-bottom:1px solid #3b5998;border-left:1px solid #CCCCCC;border-right:1px solid #CCCCCC;font-family:lucida grande,tahoma,verdana,arial,sans-serif;padding:15px' valign='top'>
<table width='100%'>
<tbody>
<tr>
<td style='font-size:16px' align='left' valign='top' width='470px'><div style='margin-bottom:15px;font-size:14px'>
Hola, $nombre:
</div>
<div style='margin-bottom:15px'>PROCESO DE PAGO: Transferencia Bancaria
<br>
<br>

<span style='color:#333333'>
Realizar la transferencia a la sigueinte cuenta para completar el pago:
</span>
<span style='color:#333333'>
<ul>
<li style='padding-top:15px'>
Banamex
<br>
<span style='color:#333333'>
Cta. a Nombre de: Enrique Estrada Segura<br/>
Sucursal: 7003<br/>
Cuenta: 6754255<br/>
Clabe: 002420700367542558
</span>
</li>
</ul>
</span>
<br>

</div><div style='margin-bottom:15px'>
Gracias.
<br>
<br>
Inscripciones E.R.Ca.J. M&eacute;xico
<br>
<br>
'Creo Se&ntilde;or Aumenta mi Fe'
<br>
<br>
<br>
<table style='border-collapse:collapse' cellpadding='0' cellspacing='0'>
<tbody>
<tr>
<td style='padding:10px;background-color:#F2F2F2;border-left:1px solid #3b5998;border-right:1px solid #3b5998;border-top:1px solid #3b5998;border-bottom:#2D2D2D solid 4px'>
<a href='http://www.ercaj.org/' style='color:#3b5998;text-decoration:none' target='_blank'>
Ir al Sitio Oficial del E.R.Ca.J.
</a>
</td>
</tr>
</tbody>
</table>
</div>
</td>
<td style='padding-left:15px' align='left' valign='top' width='150'>
<table style='border-collapse:collapse' cellpadding='0' cellspacing='0'>
<tbody>
<tr>
<td style='padding:2px;background-color:#2D2D2D;border-left:0px solid #e2c822;border-right:0px solid #e2c822;border-top:0px solid #e2c822;border-bottom:0px solid #e2c822'>
<table style='border-collapse:collapse' cellpadding='0' cellspacing='0'>
<tbody>
<tr>
<td style='border-width:1px;border-style:solid;border-color:#3b6e22 #3b6e22 #2c5115;background-color:#F2F2F2'>
<table style='border-collapse:collapse' cellpadding='0' cellspacing='0'>
<tbody>
<tr>
<td style='font-size:11px;font-family:lucida grande, tahoma, verdana, arial, sans-serif;padding:4px 10px 5px;border-top:1px solid #fff'>
<a href='http://www.ercaj.org/inscripcionesercaj.php' style='color:#F2F2F2;text-decoration:none' target='_blank'>
<span style='font-weight:bold;color:#fff;font-size:13px'>
<img src='http://www.ercaj.org/imagenes/logo.jpg' style='border:0;width;140px;height:140px'>
</span></a></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr>
<td colspan='2' style='color:#999999;padding:10px;font-size:12px;font-family:lucida grande,tahoma,verdana,arial,sans-serif;padding:10px;border-top:0px solid #3b5998;border-bottom:#2D2D2D solid 2px'>
El mensaje se envi� a $email. Dudas o Aclaraciones contactanos: ercajmexico@hotmail.com
http://www.ercaj.org
Encuentro Renovado Cat�lico Juvenil.
</td></tr></tbody></table></td></tr></tbody></table></div></div></div> </div></div>";

	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=utf-8\n";
	$headers .= "From: Pre-Inscipciones E.R.Ca.J. M�xico 2012 <contacto@ercaj.org>";
	
	mail($email,$titulo,$mensaje,$cabeceras) or die ("Su mensaje no se envio.");
}

function envioCorreoDeposito($nombre,$email)
{
	$titulo = "Pre-Inscripci�n E.R.Ca.J. M&eacute;xico 2012";
	$mensaje = "
<br><div><div dir='ltr'><div><div dir='ltr'><div><table border='0' cellpadding='40' cellspacing='0' width='98%'><tbody><tr><td style='font-family:lucida grande,tahoma,verdana,arial,sans-serif' bgcolor='#f7f7f7' width='100%'><table border='0' cellpadding='0' cellspacing='0' width='620'><tbody><tr><td style='background:#F2F2F2;color:#3b5998;font-weight:bold;font-family:lucida grande,tahoma,verdana,arial,sans-serif;border-left:1px solid #3b5998;border-right:1px solid #3b5998;border-top:1px solid #3b5998;border-bottom:#2D2D2D solid 8px;vertical-align:middle;padding:10px 40px;font-size:24px;letter-spacing:2px;text-align:left'>
<a href='http://www.ercaj.org/inscripcionesercaj.php' style='color:#3b5998;text-decoration:none' target='_blank'>
Pre-Inscripci&oacute;n E.R.Ca.J. M&eacute;xico.
</a>
</td>
</tr>
<tr>
<td colspan='2' style='background-color:#FFFFFF;border-bottom:1px solid #3b5998;border-left:1px solid #CCCCCC;border-right:1px solid #CCCCCC;font-family:lucida grande,tahoma,verdana,arial,sans-serif;padding:15px' valign='top'>
<table width='100%'>
<tbody>
<tr>
<td style='font-size:16px' align='left' valign='top' width='470px'><div style='margin-bottom:15px;font-size:14px'>
Hola, $nombre:
</div>
<div style='margin-bottom:15px'>PROCESO DE PAGO: Dep&oacute;sito Bancario
<br>
<br>

<span style='color:#333333'>
Realizar el dep&oacute;sito a la sigueinte cuenta para completar el pago:
</span>
<span style='color:#333333'>
<ul>
<li style='padding-top:15px'>
Banamex
<br>
<span style='color:#333333'>
Cta. a Nombre de: Enrique Estrada Segura<br/>
Sucursal: 7003<br/>
Cuenta: 6754255<br/>
</span>
</li>
</ul>
</span>
<br>

</div><div style='margin-bottom:15px'>
Gracias.
<br>
<br>
Inscripciones E.R.Ca.J. M&eacute;xico
<br>
<br>
'Creo Se&ntilde;or Aumenta mi Fe'
<br>
<br>
<br>
<table style='border-collapse:collapse' cellpadding='0' cellspacing='0'>
<tbody>
<tr>
<td style='padding:10px;background-color:#F2F2F2;border-left:1px solid #3b5998;border-right:1px solid #3b5998;border-top:1px solid #3b5998;border-bottom:#2D2D2D solid 4px'>
<a href='http://www.ercaj.org/' style='color:#3b5998;text-decoration:none' target='_blank'>
Ir al Sitio Oficial del E.R.Ca.J.
</a>
</td>
</tr>
</tbody>
</table>
</div>
</td>
<td style='padding-left:15px' align='left' valign='top' width='150'>
<table style='border-collapse:collapse' cellpadding='0' cellspacing='0'>
<tbody>
<tr>
<td style='padding:2px;background-color:#2D2D2D;border-left:0px solid #e2c822;border-right:0px solid #e2c822;border-top:0px solid #e2c822;border-bottom:0px solid #e2c822'>
<table style='border-collapse:collapse' cellpadding='0' cellspacing='0'>
<tbody>
<tr>
<td style='border-width:1px;border-style:solid;border-color:#3b6e22 #3b6e22 #2c5115;background-color:#F2F2F2'>
<table style='border-collapse:collapse' cellpadding='0' cellspacing='0'>
<tbody>
<tr>
<td style='font-size:11px;font-family:lucida grande, tahoma, verdana, arial, sans-serif;padding:4px 10px 5px;border-top:1px solid #fff'>
<a href='http://www.ercaj.org/inscripcionesercaj.php' style='color:#F2F2F2;text-decoration:none' target='_blank'>
<span style='font-weight:bold;color:#fff;font-size:13px'>
<img src='http://www.ercaj.org/imagenes/logo.jpg' style='border:0;width;140px;height:140px'>
</span></a></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr>
<td colspan='2' style='color:#999999;padding:10px;font-size:12px;font-family:lucida grande,tahoma,verdana,arial,sans-serif;padding:10px;border-top:0px solid #3b5998;border-bottom:#2D2D2D solid 2px'>
El mensaje se envi� a $email. Dudas o Aclaraciones contactanos: ercajmexico@hotmail.com
http://www.ercaj.org
Encuentro Renovado Cat�lico Juvenil.
</td></tr></tbody></table></td></tr></tbody></table></div></div></div> </div></div>
	";

	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=utf-8\n";
	$headers .= "From: Pre-Inscipciones E.R.Ca.J. M�xico 2012 <contacto@ercaj.org>";
	
	mail($email,$titulo,$mensaje,$cabeceras) or die ("Su mensaje no se envio.");
}

function insertaRegistro()
{
	$nombre = __($_POST["nombre"]);
	$ap_pat = __($_POST["ap_pat"]);
	$ap_mat = __($_POST["ap_mat"]);
	$edad = $_POST["edad"];
	$telefono_casa = $_POST["telefono"];
	$idMunicipio = $_POST["municipio"];
	$sexo = $_POST["sexo"];
	$email = limpiaEmail($_POST["email"]);
	$idKoinonia = $_POST["koinonia"];
	
	
	if(empty($nombre))
	{
		exit("<p>UPSS!!!. El campo <code><b>Nombre</b></code> est&aacute; vacio. Verif&iacute;calo</p>
			<br/>
			<b><a href='inscribir.php'>Regresar</a></b>");
	}else if(empty($ap_pat))
	{
		exit("<p>UPSS!!!. El campo <code><b>Apellido Paterno</b></code> est&aacute; vacio. Verif&iacute;calo</p>
			<br/>
			<b><a href='inscribir.php'>Regresar</a></b>");
	}else if(empty($ap_mat))
	{
		exit("<p>UPSS!!!. El campo <code><b>Apellido Materno</b></code> est&aacute; vacio. Verif&iacute;calo</p>
			<br/>
			<b><a href='inscribir.php'>Regresar</a></b>");
	}else  if(!esEmail($email))
	{
		exit("<p>UPSS!!!. El campo <code><b>E-Mail</b></code> debe ser v&aacute;lido. Verif&iacute;calo</p>
			<br/>
			<b><a href='inscribir.php'>Regresar</a></b>");
	}else if(empty($telefono_casa))
	{
		exit("<p>UPSS!!!. El campo <code><b>Tel&eacute;fono</b></code> est&aacute; vacio. Verif&iacute;calo</p>
			<br/>
			<b><a href='inscribir.php'>Regresar</a></b>");
	}else if(empty($edad))
	{
		exit("<p>UPSS!!!. El campo <code><b>Edad</b></code> est&aacute; vacio. Verif&iacute;calo</p>
			<br/>
			<b><a href='inscribir.php'>Regresar</a></b>");
	}else if(siExiste("email","asistente","email='$email'"))
	{
		exit("<p>UPSS!!!. El campo <code><b>Email</b></code> ya est&aacute; registrado. Verif&iacute;calo</p>
			<br/>
			<b><a href='inscribir.php'>Regresar</a></b>");
	}else if(empty($idKoinonia))
	{
		exit("<p>UPSS!!!. El campo <code><b>Koinonia</b></code> est&aacute; vacio. Verif&iacute;calo</p>
			<br/>
			<b><a href='inscribir.php'>Regresar</a></b>");
	}else if(empty($idMunicipio))
	{
		exit("<p>UPSS!!!. El campo <code><b>Municipio</b></code> est&aacute; vacio. Verif&iacute;calo</p>
			<br/>
			<b><a href='inscribir.php'>Regresar</a></b>");
	}else{

		//require ("Query.inc");  //Ya no lo necesita se agrego en la funcion siExiste||
		$query=new Query();
		if($query->insert("asistente","nombre, ap_pat, ap_mat, telefono_casa, idMunicipio, edad, email, sexo, idKoinonia",
						  "'$nombre','$ap_pat','$ap_mat','$telefono_casa','$idMunicipio','$edad','$email','$sexo','$idKoinonia'"))
		{
			if(!$query->update("koinonia","lugares_disponibles=(lugares_disponibles-1)","id=$idKoinonia")){
				echo "<p>Error al asignar Koinon�a</p>";
			}				
				echo"<h2>Datos insertados correctamente</h2>
				<br/>
				<br/>
				<h2>Gracias por inscribirte $nombre!</h2>
				<br/>
				<br/>
				<p><a href='paginaInscritos.php'>Ver todos los Inscritos</a></p>
				<br/>
				<h2><a href='inscribir.php'>Seguir Inscribiendo</a></h2>";
		}
	}
}

function consultaKoinonias()
{
	$query = new query();
    $koinonias = $query->select("id, nombre, edad_min, edad_max, tipo, status, lugares_disponibles", "koinonia", "1=1 order by status");
    if ($koinonias) {
        echo '<div class="tab-content">
            <table id="example" class="display table table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Edades</th>
                            <th>Hombres / Mujeres</th>
                            <th>Status</th>
                            <th>Lugares Disponibles</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
        <tbody>';
        foreach ($koinonias as $koinonia) {
        	if($koinonia->tipo=='M') { $tipo="Hombres";}else if($koinonia->tipo == 'F'){$tipo="Mujeres";}else{$tipo="Desconocido";}
        	if($koinonia->status == 1){$status="<span class='glyphicon glyphicon-thumbs-up' ></span>";}else 
        	if($koinonia->status == 0){$status="<a href='#' class='activarKoinonia' ide='" . $koinonia->id . "'><span class='glyphicon glyphicon-thumbs-down' ></span> Activar</a>";}else{$status="Desconocido";}
            echo '<tr>
                  <td>' . utf8_encode($koinonia->nombre) . '</td>
                  <td>' . $koinonia->edad_min . ' - ' . $koinonia->edad_max . '</td>
                  <td>'. $tipo .'</td>
                  <td>'. $status .'</td>
                  <td>'. $koinonia->lugares_disponibles .'</td>
                  <td><a href="editarKoinonia.php?id=' . $koinonia->id . '" ><span class=\'glyphicon glyphicon-pencil\' ></span> Editar</a></td></tr>';
        }
        echo '</tbody>
        </table></div>';
    }else{
    	echo "<div class='alert wet-asphalt' role='alert'>No se encontraron Koinon�as.</div>";
    }
}


function consultaAsistentes() {
    $query = new query();
    $asistentes = $query->select("id, nombre, ap_pat, ap_mat, edad, sexo, telefono_casa, email, idKoinonia, idMunicipio", "asistente");
    if ($asistentes) {
        echo '<div class="tab-content">
            <table id="example" class="display table table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Edad</th>
                            <th>Tel&eacute;fono de Emergencia</th>
                            <th>Municipio</th>
                            <th>Estado</th>
                            <th>Koinonia</th>
                            <th>Email</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
        <tbody>';
        foreach ($asistentes as $asistente) {
            $municipio = $query->select("*", "municipio", "id=$asistente->idMunicipio", "", "arr");
            $estado = $query->select("*", "estado", "id=$municipio[2]", "", "arr");
            $koinonia = $query->select("*", "koinonia", "id=$asistente->idKoinonia", "", "arr");
            echo '<tr>
                  <td>' . utf8_encode($asistente->nombre) . ' ' . utf8_encode($asistente->ap_pat) . ' ' . utf8_encode($asistente->ap_mat) . '</td>
                  <td>' . $asistente->edad . '</td>
                  <td>' . $asistente->telefono_casa . '</td>
                  <td>'. utf8_encode($municipio[1]) .'</td>
                  <td>'. utf8_encode($estado[1]).'</td>
                  <td>'. utf8_encode($koinonia[1]) .'</td>
                  <td>' . $asistente->email . '</td>
                  <td><a href="editarAsistente.php?id=' . $asistente->id . '" ><span class=\'glyphicon glyphicon-pencil\' ></span> Editar</a></td></tr>';
        }
        echo '</tbody>
        </table></div>';
    }else{
    	echo "<div class='alert wet-asphalt' role='alert'>No se encontraron asistentes.</div>";
    }
}

?>  