$(function()
{
	$('#example').dataTable({
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ning&uacute;n dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        bInfo: false, bLengthChange: false
    });
	
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
    
    $('#newClientForm').validate({
    	lang: 'es',
        rules: {
            client_name: {
                minlength: 2,
                required: true
            },
            client_lastname: {
                minlength: 2,
                required: true
            },
            client_matname: {
                minlength: 2
            },
            client_email: {
                required: true,
                email: true
            },
            client_phone: {
                minlength: 10,
                maxlength: 10,
                required: true
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if(element.parent('.form-control').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
    
    $('#example tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }else {
        	$('#example').DataTable().$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });
    
});

$(document).on('click', ".removeShoeSaleList", removeShoe);
$(document).on('click', ".addShoeList", addShoe);
$(document).on('click', "#realizaVenta", realizaVenta);
$(document).on('click', ".applyDiscount", applyDiscount);
$(document).on('mousedown', ".viewDiscount", viewDiscount);
$(document).on('click', "#applicateDiscount", applicateDiscount);
$(document).on('click', "#saveClient", saveClient);
$(document).on('click', "#search-shoe-qr", searchShoeQr);
$(document).on('click', "#add-list-shoe-qr", addListShoeQr);

function removeShoe(event){
	var row = $(this).parents('tr')[0];
	var stockid = $(event.target).attr("stockid");
	var saleid = $("#idTableSaleList").attr("saleid");
	
	$.post("funcionesJSON.php", {stockid: stockid, saleid: saleid, removeShoe: true}, function(respuesta){
		
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
					'</td><td><a href="#" class="removeShoeSaleList" stockid="'+respuesta.stockid+'"><span class="glyphicon glyphicon-remove"></span> Eliminar</a></td>'+
					'<td><a href="#" class="applyDiscount" stockidApply="'+respuesta.stockid+'"><span class="glyphicon glyphicon-heart-empty"></span> Adicional</a></td>'+
					'</tr>');
			row.remove();
		}
	}, 'json');
}

function saveClient(e){
	var tabActive = $("ul#sampleTabs li.active")[0].id;
	var tabla = $("#example").DataTable();
	var saleid = $("#idTableSaleList").attr("saleid");
	if(tabActive === 'newClientTab'){
		var isValid = $('#newClientForm').valid();
		if(isValid === true){
			$.post("funcionesJSON.php", { client_name: $('#client_name').val(), 
										client_lastname: $('#client_lastname').val(),
										client_matname: $('#client_matname').val(),
										client_email: $('#client_email').val(),
										client_phone: $('#client_phone').val(),
										saleid: saleid, saveNewClient: true}, function(respuesta){
				if(respuesta.error != null){
					$("#modalTitle").html("<span class='glyphicon glyphicon-thumbs-down'></span> "+respuesta.error);
					$('#myModal').modal('show');
				}else{
					$('#clientModal').modal('hide');
					$('#datosCliente').html("<i class='icon-user icon-small'></i> Nombre: "+$('#client_name').val()+" "+$('#client_lastname').val()+" "+$('#client_matname').val()+"<br/>" +
											"<i class='icon-envelope icon-small'></i> Email: "+$('#client_email').val()+"<br/>" +
											"<i class='icon-phone icon-small'></i> Teléfono: "+$('#client_phone').val()+"<br/>")
					showSaleList(e);
					$('#newClientForm')[0].reset();
				}
			}, 'json');
			
		}
	}else if(tabActive === 'tableClientTab'){
		if(tabla.row('.selected').data() === undefined){
			alert("Debe seleccionar un cliente para realizar la venta.");
		}else{
			var clientid = tabla.row('.selected').data()[0];
			
			if(saleid===null || saleid===undefined || saleid==='0'){
				$("#modalTitle").html("<span class='glyphicon glyphicon-thumbs-down'></span> Error!!! No existe venta. Favor de llamar a su administrador.");
				$('#myModal').modal('show');
			}else{
				$.post("funcionesJSON.php", { clientid: clientid, saleid: saleid, saveClient: true}, function(respuesta){
					if(respuesta.error != null){
						$("#modalTitle").html("<span class='glyphicon glyphicon-thumbs-down'></span> "+respuesta.error);
						$('#myModal').modal('show');
					}else{
						$('#clientModal').modal('hide');
						$('#datosCliente').html("<i class='icon-user icon-small'></i> Nombre: "+tabla.row('.selected').data()[1]+"<br/>" +
												"<i class='icon-envelope icon-small'></i> Email: "+tabla.row('.selected').data()[2]+"<br/>" +
												"<i class='icon-phone icon-small'></i> Teléfono: "+tabla.row('.selected').data()[3]+"<br/>")
						showSaleList(e);
					}
				}, 'json');
			}
		}
		
	}else{
		return false;
	}
}

function showSaleList(e){
	var saleid = $("#idTableSaleList").attr("saleid");
	
	if(saleid===null || saleid===undefined || saleid==='0'){
		$("#modalTitle").html("<span class='glyphicon glyphicon-thumbs-down'></span> Error!!! No existe venta. Favor de llamar a su administrador.");
		$('#myModal').modal('show');
	}else{
		$.post("funcionesJSON.php", { saleid: saleid, getSale: true}, function(respuesta){
			if(respuesta.error != null){
				$("#modalTitle").html("<span class='glyphicon glyphicon-thumbs-down'></span> "+respuesta.error);
				$('#myModal').modal('show');
			}else{
				$('#getSaleTable tbody').html(respuesta.resultado);
				$("#totalComponent").html(respuesta.total);
				$('#modalSale').modal('show');
			}
		}, 'json');
	}
}

function realizaVenta(e){
	var tabla = $("#example").DataTable();
	tabla.clear().draw();
	
	$.post("funcionesJSON.php", { getClients: true }, function(respuesta){
		if(respuesta.error != null){
			$("#modalTitle").html("<span class='glyphicon glyphicon-thumbs-down'></span> "+respuesta.error);
			$('#myModal').modal('show');
		}else{
			var res = respuesta.resultado;
			for( var index in res){
				tabla.row.add([res[index].clientid, 
				               res[index].firstname+' '+res[index].lastname+' '+res[index].matname, 
				               res[index].email, 
				               res[index].phone])
				               .draw();
			}
			
			$('#clientModal').modal('show');
		}
	}, 'json');
	
}

function viewDiscount(e){
	if(e.button == 2){
		var precio = $(this).html();
		var discount = $("#discount_select").val();
		$("#applicateDiscount").hide();
		
		if(discount === undefined){
			$("#testDiscount").html("No se puede aplicar.");
		}else{
			$("#testDiscount").html("<h2>$"+(precio-discount)+"</h2>");
			
			$("#discount_select").val('0');
			$('#discount_select').on('change', function() {
				  discount = $('#discount_select option:selected').attr('monto');
				  $("#testDiscount").html("<h2>$"+(precio-discount)+"</h2>");
			});
		}
		
		$("#modalDiscount").modal('show');
	}
}

function applyDiscount(event){
	var detail_sale_id = $(event.target).attr("stockidApply");
	var discount = $("#discount_select").val();
	
	$("#applicateDiscount").show();
	
	$("#testDiscount").html("...");
	$("#applicateDiscount").html("Aplicar Descuento");
	
	if(discount === undefined){
		$("#testDiscount").html("No se puede aplicar.");
		$("#applicateDiscount").hide();
	}else{
		$("#discount_select").attr("stockToDiscount", detail_sale_id);
		$("#discount_select").val('0');
		$('#discount_select').on('change', function() {
			  discount = $('#discount_select option:selected').attr('monto');
			  $("#testDiscount").html("<h2>$"+discount+"</h2>");
		});
	}
	
	$("#modalDiscount").modal('show');
}

function applicateDiscount(e){
	var discountid = $("#discount_select").val();
	var detail_sale_id = $("#discount_select").attr("stockToDiscount");
	
	if(discountid==='0'){
		$("#modalTitle").html("<span class='glyphicon glyphicon-thumbs-down'></span>Debe de seleccionar al menos una opción de descuento.");
		$('#myModal').modal('show');
	}else{
		$.post("funcionesJSON.php", { detailSaleId: detail_sale_id, discountid: discountid, appDiscount: true}, function(respuesta){
			if(respuesta.error != null){
				$("#modalTitle").html("<span class='glyphicon glyphicon-thumbs-down'></span> "+respuesta.error);
				$('#myModal').modal('show');
			}
		}, 'json');
	}
}

function searchShoeQr(e){
	$('#qr').modal('show');
	$('input#typeModalQR').val("S-QR");
}

function addListShoeQr(e){
	$('#qr').modal('show');
	$('input#typeModalQR').val("AL-QR");
}