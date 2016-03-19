$(function(){
	$(".play-qr").on("click", function() {
		pluginQR.options.flipHorizontal = true;
		$("#scanned-QR").text("Scanning ...");
        $("#grab-img").removeClass("disabled");
        pluginQR.play();
    });
	
	$(".stop-qr").click(function(event) {
    	Custombox.close("#qr");
    	$("#grab-img").addClass("disabled");
        $("#scanned-QR").text("Stopped");
        pluginQR.stop();
        pluginQR.destroy();
    });
	
});

window.codeSearchQR = "ebc7d1bf1b49d796dbb0b9133df32c69";
window.codeAddToListQR = "823af0d6bc95a5f7e17f832d0dc67981";
window.codeSenderQR = "d94cd3e5b7642bd3ca52c9c78e220d5f";
window.codeTraspasoQR = "66926fb8bd121b266db480fee7497cce";
window.codeReceiveQR = "abb9ad4731f6a31a9589665459c5a6a2";

window.argsQR = {
		autoBrightnessValue: 100,
        resultFunction: function(res) {
            $("#scanned-img").attr("src", res.imgData);
            $("#scanned-QR").text(res.format + ": " + res.code);
            
            if($("#typeModalQR").val()===codeSearchQR){
            	getValuesStringQR(res.code, codeSearchQR);
            }else if($("#typeModalQR").val()===codeAddToListQR){
            	getValuesStringQR(res.code, codeAddToListQR);
            }else if($("#typeModalQR").val()===codeSenderQR){
            	getValuesStringQR(res.code, codeSenderQR);
            }else if($("#typeModalQR").val()===codeTraspasoQR){
            	getValuesStringQR(res.code, codeTraspasoQR);
            }else if($("#typeModalQR").val()===codeReceiveQR){
            	getValuesStringQR(res.code, codeReceiveQR);
            }
            
        }
    };
window.pluginQR = $("#webcodecam-canvas").WebCodeCamJQuery(argsQR).data().plugin_WebCodeCamJQuery;

function getValuesStringQR(texto, typeQR){
	var arrValues = texto.split("#");
	if(arrValues[0]!="sys.dolancy"){
		notificacionError("El valor del código es incorrecto. Favor de verificarlo.");
		return;
	}else if(arrValues[2]==codeSearchQR && typeQR==codeSearchQR){ /** S-QR **/
		$.post("funcionesJSON.php", { stockid: arrValues[1], getShoeProperties: true}, function(respuesta){
			if(respuesta.error != null){
				notificacionError(respuesta.error);
			}else{
				$("#search_shoe").trigger("click", {
					param_model: respuesta.modelid,
					param_color: respuesta.colorid,
					param_size: respuesta.sizesid
				});
				$(".stop-qr").trigger("click");
			}
		}, 'json');
	}else if(arrValues[2]==codeAddToListQR && typeQR==codeAddToListQR){ /** AL-QR **/
		
		$(".addShoeList").trigger("click", { stockid: arrValues[1] });
		$(".stop-qr").trigger("click");
		
	}else if(arrValues[2]==codeSenderQR && typeQR==codeSenderQR){ /** SEND-QR **/
		
		$.post("funcionesJSON.php", { employeeid_sender: arrValues[1], transactionid: $("#qr").attr("idt"), sendShoe: true}, function(respuesta){
			if(respuesta.error != null){
				notificacionError(respuesta.error);
			}else{
				notificacionSuccess("Transacción enviada.");
				$(".stop-qr").trigger("click");
			}
		}, 'json');
		
		
		$("#qr").removeAttr("idt");
		
	}else if(arrValues[2]==codeTraspasoQR && typeQR==codeTraspasoQR){ /** T-QR **/
		
		$.post("funcionesJSON.php", { employeeid_sender: arrValues[1], transactionid: $("#qr").attr("idt"), trasportShoe: true}, function(respuesta){
			if(respuesta.error != null){
				notificacionError(respuesta.error);
			}else{
				notificacionSuccess("Transacción en transporte.");
				$(".stop-qr").trigger("click");
			}
		}, 'json');
		
		
		$("#qr").removeAttr("idt");
	}else if(arrValues[2]==codeReceiveQR && typeQR==codeReceiveQR){ /** RECEIVE-QR **/
		
		$.post("funcionesJSON.php", { employeeid_sender: arrValues[1], transactionid: $("#qr").attr("idt"), receiveShoe: true}, function(respuesta){
			if(respuesta.error != null){
				notificacionError(respuesta.error);
			}else{
				notificacionSuccess("Transacción completada.");
				$(".stop-qr").trigger("click");
			}
		}, 'json');
		
		
		$("#qr").removeAttr("idt");
	}else{
		console.log(arrValues);
		notificacionError("El valor del código no corresponde a algún tipo establecido en el sistema.");
	}
}