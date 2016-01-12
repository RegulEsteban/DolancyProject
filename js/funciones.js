$(function()
{
	var color_select = document.getElementById("color_select");
	var size_select = document.getElementById("size_select");
	var model_select = document.getElementById("model_select");

    $("#search_shoe").click(function(event){
    	$.post("funcionesJSON.php", {model: model_select.value, color: color_select.value, size: size_select.value}, function(respuesta) {
    		if (respuesta === "null")
    		{
    			$("#search_shoe_result").html("<div class='alert alizarin' role='alert'>No hay resultados para la búsqueda.</div>");
    		} else {
    			$("#search_shoe_result").html("<table class='table table-striped'><thead><tr>"+
                            	"<th>Modelo</th>"+
                            	"<th>Talla</th>"+
                            	"<th>Color</th>"+
                            	"<th>Precio</th>"+
                            	"<th>Sucursal</th>"+
                            	"<th>Agregar</th>"+
                            	"</tr></thead><tbody>"+respuesta+"</tbody></table>");
    		}
      },'json');
    });
});

$(document).on('click', ".removeShoeSaleList", removeShoe);
$(document).on('click', ".addShoeList", addShoe);
$(document).on('click', "#realizaVenta", realizaVenta);

function removeShoe(event){
	var row = $(this).parents('tr')[0];
	var stockid = $(event.target).attr("stockid");
	var saleid = $("#idTableSaleList").attr("saleid");
	
	$.post("funcionesJSON.php", {stockid: stockid, saleid: saleid, removeShoe: true}, function(respuesta){
		console.log(respuesta);
		if(respuesta.error === null){
			row.remove();
		}else{
			$("#modalTitle").html(respuesta.error);
			$('#myModal').modal('show');
		}
	}, 'json');
}

function addShoe(event){
	var stockid = $(event.target).attr("stockid");
	var saleid = $("#idTableSaleList").attr("saleid");
	var row = $(this).parents('tr')[0];
	$.post("funcionesJSON.php", {stockid: stockid, saleid: saleid, addShoe: true}, function(respuesta){
		if(respuesta.error != null){
			$("#modalTitle").html("<span class='glyphicon glyphicon-thumbs-down'></span> "+respuesta.error);
			$('#myModal').modal('show');
		}else{
			$("#noResultSaleList").hide();
			$("#idTableSaleList").attr("saleid", respuesta.saleid);
			$('#idTableSaleList tbody').append('<tr><td>'+respuesta.model+
					'</td><td>'+respuesta.size+
					'</td><td>'+respuesta.color+
					'</td><td>'+respuesta.price+
					'</td><td><a href="#" class="removeShoeSaleList" stockid="'+respuesta.stockid+'"><span class="glyphicon glyphicon-remove"></span> Eliminar</a></td></tr>');
			row.remove();
		}
	}, 'json');
}

function realizaVenta(e){
	$('#modalSale').modal('show');
}