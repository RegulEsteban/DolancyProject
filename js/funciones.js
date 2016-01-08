$(document).ready(function()
{
	var color_select = document.getElementById("color_select");
	var size_select = document.getElementById("size_select");
	var model_select = document.getElementById("model_select");
	var search_shoe_result = document.getElementById("search_shoe_result");
	
//	var ap_pat = document.getElementById("ap_pat");
//	var ap_mat = document.getElementById("ap_mat");
//	var edad = document.getElementById("edad");
//	var sexo = document.getElementById("sexo");
//	var telefono = document.getElementById("telefono");
//	var estado = document.getElementById("estado");
//	var municipio = document.getElementById("municipio");
//	var koinonia = document.getElementById("koinonia");
//
//	var valida_nombre = document.getElementById("valida_nombre");
//	var valida_ap_pat = document.getElementById("valida_ap_pat");
//	var valida_ap_mat = document.getElementById("valida_ap_mat");
//	var valida_edad = document.getElementById("valida_edad");
//	var valida_sexo = document.getElementById("valida_sexo");
//	var valida_telefono = document.getElementById("valida_telefono");
//	var valida_estado = document.getElementById("valida_estado");
//	var valida_municipio = document.getElementById("valida_municipio");
//	var valida_koinonia = document.getElementById("valida_koinonia");
//
//	$("#boton_enviar").click(function(event)
//    {
//        if(!esLetras(nombre.value)){
//        	valida_nombre.innerHTML = "<div class='alert alizarin' role='alert'>Nombre Inválido</div>";
//        	return false;
//        }else if(!esLetras(ap_pat.value)){
//        	valida_ap_pat.innerHTML = "<div class='alert alizarin' role='alert'>Apellido Paterno Inválido</div>";
//        	return false;
//        }else if(!esLetras(ap_mat.value)){
//        	valida_ap_mat.innerHTML = "<div class='alert alizarin' role='alert'>Apellido Materno Inválido</div>";
//        	return false;
//        }else if(edad.value==='0'){
//        	valida_edad.innerHTML = "<div class='alert alizarin' role='alert'>Selecciona la Edad</div>";
//        	return false;
//        }else if(sexo.value==='0'){
//        	valida_sexo.innerHTML = "<div class='alert alizarin' role='alert'>Selecciona el Genero.</div>";
//        	return false;
//        }else if(estado.value==='0'){
//        	valida_estado.innerHTML = "<div class='alert alizarin' role='alert'>Selecciona el Estado.</div>";
//        	return false;
//        }else if(municipio.value==='0'){
//        	valida_municipio.innerHTML = "<div class='alert alizarin' role='alert'>Selecciona el Municipio.</div>";
//        	return false;
//        }else if(koinonia.value==='0'){
//        	valida_koinonia.innerHTML = "<div class='alert alizarin' role='alert'>Selecciona una Koinonia.</div>";
//        	return false;
//        }else if(telefono.value.length>10){
//        	valida_telefono.innerHTML = "<div class='alert alizarin' role='alert'>Número de teléfono muy largo (Máximo 10 números).</div>";
//        	return false;
//        }
//       
//    });
//
//	$('select#estado').on('change', function(e)
//	{
//	    valida_estado.innerHTML = '';
//	    valida_municipio.innerHTML = '';
//	    municipio.innerHTML = '';
//	    $.post("funcionesJSON.php", {id_estado: estado.value}, function(respuesta)
//        {
//            if (respuesta === "null")
//            {
//                valida_municipio.innerHTML = "<div class='alert alizarin' role='alert'>Sin municipios.</div>";
//            } else {
//                municipio.innerHTML = respuesta.respuesta;
//            }
//        },'json');
//	});
//
//	$('select#edad').on('change', function(e)
//	{
//	    valida_edad.innerHTML='';
//	    koinonia.innerHTML = '';
//	    valida_koinonia.innerHTML = '';
//	    $.post("funcionesJSON.php", {edad: edad.value, tipo: sexo.value}, function(respuesta)
//        {
//            if (respuesta === "null")
//            {
//                valida_koinonia.innerHTML = "<div class='alert alizarin' role='alert'>Sin koinonias disponibles.</div>";
//            } else {
//                koinonia.innerHTML = respuesta.respuesta;
//            }
//        },'json');
//	});
//
//	$('select#sexo').on('change', function(e)
//	{
//	    valida_sexo.innerHTML='';
//	    koinonia.innerHTML = '';
//	    valida_koinonia.innerHTML = '';
//	    $.post("funcionesJSON.php", {edad: edad.value, tipo: sexo.value}, function(respuesta)
//        {
//            if (respuesta === "null")
//            {
//                valida_koinonia.innerHTML = "<div class='alert alizarin' role='alert'>Sin koinonias disponibles.</div>";
//            } else {
//                koinonia.innerHTML = respuesta.respuesta;
//            }
//        },'json');
//	});
//
//	$("#telefono").keyup(function(event) 
//    {
//        valida_telefono.innerHTML = "";
//    });
//
//    $("#nombre").keyup(function(event) 
//    {
//        valida_nombre.innerHTML = "";
//    });
//
//    $("#ap_pat").keyup(function(event) 
//    {
//        valida_ap_pat.innerHTML = "";
//    });
//
//    $("#ap_mat").keyup(function(event) 
//    {
//        valida_ap_mat.innerHTML = "";
//    });
//
//    function esLetras(input) 
//    {
//        //var RE = /^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ_\s]+$/;
//        var RE = /^[A-Za-záéíóúñ]{2,}([\s][A-Za-záéíóúñ]{2,})+$/;
//        if(RE.test(input)){
//        	return true;
//        }else{
//        	var RE = /^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ]+$/;
//			if(RE.test(input)){
//				return true;
//			}else{
//				return false;
//			}
//        }
//    }

    $("#search_shoe").click(function(event){
    	
    	$.post("funcionesJSON.php", {model: model_select.value, color: color_select.value, size: size_select.value}, function(respuesta) {
    		alert("dd");
    		if (respuesta === "null")
    		{
    			search_shoe_result.innerHTML = "<div class='alert alizarin' role='alert'>No hay resultados para la búsqueda.</div>";
    		} else {
    			search_shoe_result.innerHTML = "<table id='example' class='display table table-striped' cellspacing='0' width='100%'><thead><tr>"+
                            	"<th>Modelo</th>"+
                            	"<th>Talla</th>"+
                            	"<th>Color</th>"+
                            	"<th>Precio</th>"+
                            	"<th>Acción</th></tr></thead><tbody>"+respuesta.respuesta+"</tbody></table>";
    		}
      },'json');
    });
});