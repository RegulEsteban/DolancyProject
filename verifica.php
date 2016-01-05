<?php
/*
 * Valida si el usuario existe e inicia la session 
 */
session_start();
if ($_POST) {
    include_once("./funcionesLogin.php");
    $usuario = urldecode(str_replace("nu=", "", ($_POST["nu"])));
    $password = urldecode(str_replace("pu=", "", ($_POST["pu"])));
    if (empty($usuario) || empty($password)) {
        exit("<h4><i class='icon-warning-sign'></i>Ingresa tus datos.</h4>");
    } else {
        if (letras($usuario)) {
            exit("<h4><i class='icon-remove-sign'></i>Error. Datos incorrectos. Intenta nuevamente.</h4>");
        }
        if (numerosLestras($password)) {
           exit("<h4><i class='icon-remove-sign'></i>Error. Datos incorrectos. Intenta nuevamente.</h4>");
        }
        if(accesoAutorizado ($usuario,$password ) )
                {
        echo "<h4 class='correcto c'><i class='icon-ok'></i> Acceso autorizado.</h4>
				      <p class='c'><a href='ListadoMaestro'>Click aqu&iacute; para continuar</a></p>";
        
        } else
        {
        echo "<h4><i class='icon-remove-sign'></i> Error. Datos incorrectos. Intenta nuevamente.</h4>";
    }
}
} else
{
exit("<h4><i class='icon-remove-sign'></i> <b>ERROR. No hay datos.</b></h4>");
}
?>