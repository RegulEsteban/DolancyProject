$(document).ready(function()
{
	$(".activarKoinonia").click(function(event)
    {
    	var idKoinonia=$(".activarKoinonia").attr("ide");

    	$.post("funcionesJSON.php", {id_koinonia: idKoinonia}, function(respuesta)
        {
            if (respuesta === "null")
            {
                alert("No se pudo activar la Koinonía.");
            } else {
                location.reload();
            }
        });
    });
});