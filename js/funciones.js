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
    	$('#tablasProductos a:first').tab('show');
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
                            	"<th>Acción</th>"+
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
    
    $(".close-modal").click(function(event){
    	Custombox.close();
    });
});

$(document).on('click', ".removeShoeSaleList", removeShoe);
$(document).on('click', ".addShoeList", addShoe);
$(document).on('click', "#realizaVenta", realizaVenta);
$(document).on('click', ".applyDiscount", applyDiscount);
$(document).on('click', ".viewDiscount", viewDiscount);
$(document).on('click', "#applicateDiscount", applicateDiscount);
$(document).on('click', "#saveClient", saveClient);
$(document).on('click', "#omiteClient", omiteClient);
$(document).on('click', "#search-shoe-qr", searchShoeQr);
$(document).on('click', "#add-list-shoe-qr", addListShoeQr);
$(document).on('click', ".orderImport", orderImport);
$(document).on('click', "#transactionsButton", transactionsButton);
$(document).on('click', ".receiveStock", receiveStock);
$(document).on('click', ".doTransition", doTransition);

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
			notificacionError(respuesta.error);
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
					notificacionError(respuesta.error);
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
			notificacionError("Debe seleccionar un cliente para realizar la venta.");
		}else{
			var clientid = tabla.row('.selected').data()[0];
			
			if(saleid===null || saleid===undefined || saleid==='0'){
				notificacionError("No existe venta. Favor de llamar a su administrador.");
			}else{
				$.post("funcionesJSON.php", { clientid: clientid, saleid: saleid, saveClient: true}, function(respuesta){
					if(respuesta.error != null){
						notificacionError(respuesta.error);
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

function omiteClient(e){
	var saleid = $("#idTableSaleList").attr("saleid");
	var clientid=0;
	$.post("funcionesJSON.php", { clientid: clientid, saleid: saleid, saveClient: true}, function(respuesta){
		if(respuesta.error != null){
			notificacionError(respuesta.error);
		}else{
			$('#clientModal').modal('hide');
			$('#datosCliente').html("<i class='icon-user icon-small'></i> Nombre: Desconocido <br/>" +
									"<i class='icon-envelope icon-small'></i> Email: Desconocido <br/>" +
									"<i class='icon-phone icon-small'></i> Teléfono: Desconocido <br/>")
			showSaleList(e);
			$('#newClientForm')[0].reset();
		}
	}, 'json');
	
}

function showSaleList(e){
	var saleid = $("#idTableSaleList").attr("saleid");
	
	if(saleid===null || saleid===undefined || saleid==='0'){
		notificacionError("Error!!! No existe venta. Favor de llamar a su administrador.");
	}else{
		$.post("funcionesJSON.php", { saleid: saleid, getSale: true}, function(respuesta){
			if(respuesta.error != null){
				notificacionError(respuesta.error);
			}else{
				$('#getSaleTable tbody').html(respuesta.resultado);
				$("#totalComponent").html(respuesta.total);
				
				openModal("#modalSale");
				e.preventDefault();
			}
		}, 'json');
	}
}

function realizaVenta(e){
	var tabla = $("#example").DataTable();
	tabla.clear().draw();
	var saleid = $("#idTableSaleList").attr("saleid");
	if(saleid===null || saleid===undefined || saleid==='0'){
		notificacionError("Aún no hay productos en la lista de venta.");
	}else{
		$.post("funcionesJSON.php", { getClients: true }, function(respuesta){
			if(respuesta.error != null){
				notificacionError(respuesta.error);
			}else{
				var res = respuesta.resultado;
				for( var index in res){
					if(index != 'remove')
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
	
}

function viewDiscount(e){
	$("#discount_select").val('0');
	
	var precioTxt = $(this).html();
	var precio = precioTxt * 1.0;
	var discount = precio - ($('#discount_select option:selected').attr('monto') * 1.0);
	
	$("#applicateDiscount").hide();
	
	if(discount === undefined){
		$("#testDiscount").html("No se puede aplicar.");
	}else{
		$("#testDiscount").html("<h2><span class='glyphicon glyphicon-thumbs-down'></span> $"+(precio.toFixed(2))+
				" &nbsp;&nbsp;&nbsp;&nbsp;<span class='glyphicon glyphicon-resize-horizontal'></span>&nbsp;&nbsp;&nbsp;&nbsp;"+
				"<span class='glyphicon glyphicon-thumbs-up'></span> $"+(discount.toFixed(2))+"</h2>");
		
		$("#discount_select").val('0');
		$('#discount_select').on('change', function() {
			  discount = precio - ($('#discount_select option:selected').attr('monto') * 1.0);
			  $("#testDiscount").html("<h2><span class='glyphicon glyphicon-thumbs-down'></span> $"+(precio.toFixed(2))+
						"&nbsp;&nbsp;&nbsp;&nbsp;<span class='glyphicon glyphicon-resize-horizontal'></span>&nbsp;&nbsp;&nbsp;&nbsp;"+
						"<span class='glyphicon glyphicon-thumbs-up'></span> $"+(discount.toFixed(2))+"</h2>");
		});
	}
	
	openModal("#modalDiscount");
}

function applyDiscount(event){
	$("#discount_select").val('0');
	var detail_sale_id = $(event.target).attr("stockidApply");
	var precioTxt = $(this).attr('monto');
	
	$.post("funcionesJSON.php", { detailSaleId: detail_sale_id, getDiscount: true }, function(respuesta){
		if(respuesta.error != null){
			notificacionError(respuesta.error);
		}else{
			if(respuesta.discountid==null || respuesta.discountid=='0'){
				var precio = precioTxt * 1.0;
				var discount = precio - ($('#discount_select option:selected').attr('monto') * 1.0);
				
				$("#applicateDiscount").show();
				$("#applicateDiscount").html("Aplicar Descuento");
				
				if(discount === undefined){
					$("#testDiscount").html("No se puede aplicar.");
				}else{
					$("#testDiscount").html("<h2><span class='glyphicon glyphicon-thumbs-down'></span> $"+(precio.toFixed(2))+
							" &nbsp;&nbsp;&nbsp;&nbsp;<span class='glyphicon glyphicon-resize-horizontal'></span>&nbsp;&nbsp;&nbsp;&nbsp;"+
							"<span class='glyphicon glyphicon-thumbs-up'></span> $"+(discount.toFixed(2))+"</h2>");
					
					$("#discount_select").val('0');
					$('#discount_select').on('change', function() {
						  discount = precio - ($('#discount_select option:selected').attr('monto') * 1.0);
						  $("#testDiscount").html("<h2><span class='glyphicon glyphicon-thumbs-down'></span> $"+(precio.toFixed(2))+
									"&nbsp;&nbsp;&nbsp;&nbsp;<span class='glyphicon glyphicon-resize-horizontal'></span>&nbsp;&nbsp;&nbsp;&nbsp;"+
									"<span class='glyphicon glyphicon-thumbs-up'></span> $"+(discount.toFixed(2))+"</h2>");
					});
				}
				$("#discount_select").attr("stockToDiscount",detail_sale_id);
				openModal("#modalDiscount");
			}else{
				$.post("funcionesJSON.php", { detailSaleId: detail_sale_id, discountid: 0, appDiscount: true}, function(respuesta){
					if(respuesta.error != null){
						notificacionError(respuesta.error);
					}else{
						notificacionSuccess("Descuento eliminado.");
					}
				}, 'json');
			}
		}
	}, 'json');
	
}

function applicateDiscount(e){
	var discountid = $("#discount_select").val();
	var detail_sale_id = $("#discount_select").attr("stockToDiscount");
	
	if(discountid==='0'){
		notificacionError("Debe de seleccionar al menos una opción de descuento.");
	}else{
		$.post("funcionesJSON.php", { detailSaleId: detail_sale_id, discountid: discountid, appDiscount: true}, function(respuesta){
			if(respuesta.error != null){
				notificacionError(respuesta.error);
			}
		}, 'json');
	}
}

function searchShoeQr(e){
	$('input#typeModalQR').val("S-QR");
	openModal("#qr");
	e.preventDefault();
}

function addListShoeQr(e){
	$('input#typeModalQR').val("AL-QR");
	openModal("#qr");
	e.preventDefault();
}

function orderImport(e){
	var stockid = $(event.target).attr("stockid");
	var branchid = $(event.target).attr("branchid");
	var $btn = $(this).button('loading');
	var n = noty({
        text        : '¿Seguro(a) que desea importar?',
        type        : 'alert',
        dismissQueue: true,
        layout      : 'center',
        modal		: true,
        theme       : 'defaultTheme',
        buttons     : [
            {addClass: 'btn btn-primary', text: 'Aceptar', onClick: function ($noty) {
	            	$.post("funcionesJSON.php", { stockid: stockid, branchid: branchid, transactionShoe: true}, function(respuesta){
	        			if(respuesta.error != null){
	        				notificacionError(respuesta.error);
	        			}
	        		}, 'json');
            	
            	
                	$noty.close();
            	}
            },
            {addClass: 'btn btn-danger', text: 'Cancelar', onClick: function ($noty) {
            		$btn.button('reset');
            		$noty.close();
            	}
            }
        ]
    });
}

function transactionsButton(e){
	$("#transactionsList tbody").empty();
	
	$.post("funcionesJSON.php", {getTransactions: true}, function(respuesta){
		if(respuesta.error != null){
			notificacionError(respuesta.error);
		}else{
			$('#modalTransactions').modal('show');
			$('#transactionsList tbody').append(respuesta.respuesta);
		}
	}, 'json');
}

function receiveStock(e){
	notificacionError(":D");
}

function doTransition(e){
	$('input#typeModalQR').val("TS-QR");
	openModal("#qr");
	e.preventDefault();
	 $("button#play").trigger("click");
}

function notificacionError(texto){
	var n = noty({
        text        : "<span class='glyphicon glyphicon-thumbs-down'></span> "+texto,
        type        : 'alert',
        dismissQueue: true,
        layout      : 'top',
        theme       : 'defaultTheme',
        type		: 'error',
        timeout     : 8000
    });
}

function notificacionSuccess(texto){
	var n = noty({
        text        : "<span class='glyphicon glyphicon-thumbs-down'></span> "+texto,
        type        : 'alert',
        dismissQueue: true,
        layout      : 'topRight',
        theme       : 'defaultTheme',
        type		: 'success',
        timeout     : 8000
    });
}

function openModal(modal){
	Custombox.open({
        target: modal,
        effect: 'fadein',
        zIndex: 1
    });
}