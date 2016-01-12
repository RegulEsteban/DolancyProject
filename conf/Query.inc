<?php

class query {

    private $idConexion;
    private $idQuery;
    private $arrObjetos = array();

    function __construct() {
        require_once ("Conexion.inc");
        $this->idConexion = new Conexion();
        $this->idQuery = NULL;
    }

    function insert($tabla, $campos = "", $valores, $adicionales = "") {
        if ($this->idConexion && !empty($tabla)) {
            $sql = "insert into $tabla ($campos) values ($valores)$adicionales";
            mysql_query($sql) or die("ERROR" . mysql_error());
            return true;
        }
    }

    function update($tabla, $set = "", $condicion, $adicionales = "") {
        if ($this->idConexion && !empty($tabla)) {
            $sql = "update $tabla set $set where $condicion $adicionales";
            mysql_query($sql) or die("ERROR" . mysql_error());
            return true;
        }
    }

    function select($campos = NULL, $tablas = NULL, $where = '1', $adicionales = NULL, $tipo = "obj") {
        if (!empty($campos) || !empty($tablas)) {
            unset($this->sql, $this->idQuery, $this->arregloObj, $this->arregloArr);
            $this->sql = "SELECT " . $campos . " FROM " . $tablas . " WHERE " . $where . " " . $adicionales;
            $this->idQuery = @mysql_query($this->sql) or die("ERROR EN MYSQL:" . " " . mysql_errno() . " " . mysql_error() . " "
                            . __FILE__ . " " . __LINE__ . " " . __CLASS__ . " "
                            . __FUNCTION__ . " " . __METHOD__ . " "
                            . $_SERVER['SCRIPT_FILENAME'] . " " . $this->sql);
            if (RESULTTRACE)
                echo "<p> Query exitoso <code> $this->sql</code></p>";
            if ($this->numRegistros() > 0) {
                if (strcmp($tipo, "obj") == 0) {
                    $this->arregloObj = array();
                    while ($row = mysql_fetch_object($this->idQuery)) {
                        $this->arregloObj[] = $row;
                    }
                    @mysql_free_result($this->idQuery);
                    return $this->arregloObj;
                } else if (strcmp($tipo, "arr") == 0) {
                    $this->arregloArr = array();
                    $this->arregloArr = mysql_fetch_array($this->idQuery, MYSQL_NUM);
                    @mysql_free_result($this->idQuery);
                    return $this->arregloArr;
                }
            } else {
                return NULL;
            }
        } else {
            exit("<p>ERROR: No has especificado un query \"SELECT\" v&oacute;lido.</p>");
        }
    }

    function numRegistros() {
        return ($this->idQuery) ? mysql_num_rows($this->idQuery) : 0;
    }

    function dameUltimo() {
        //return ($this-> idQuery) ?mysql_insert_id ():0;
        return mysql_insert_id();
    }
	
	function remove($tabla, $condicion, $adicionales = "") {
        if ($this->idConexion && !empty($tabla)) {
            $sql = "delete from $tabla where $condicion $adicionales";
            mysql_query($sql) or die("ERROR" . mysql_error());
            return true;
        }
    }
}
?>

