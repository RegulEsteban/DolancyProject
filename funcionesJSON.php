<?php 

include './funciones.php';

if($_POST)
{
    include_once './conf/query.inc';
    if($_POST["model"] && $_POST["color"] && $_POST["size"]){
    	$modelid = $_POST["model"];
    	$colorid = $_POST["color"];
    	$sizeid = $_POST["size"];
    	$query = new query();
    	$stocks = $query->select("shoe.price as price, m.title as model, c.title as color, z.size as size, b.name as branch_name, b.address as branch_address",
    					"from detail_stock s
						join shoe on s.shoeid = shoe.shoeid
						join model m on m.modelid = shoe.modelid
						join sizes z on z.sizesid = shoe.sizesid
						join color c on c.colorid = shoe.colorid
						join branch b on b.branchid = s.branchid",
    					"where m.modelid = $modelid and z.sizesid = $sizeid and c.colorid = $colorid ", "", "obj");
    	
    	if(count($stocks)>0){
    		foreach ($stocks as $stock){
    			
    		}
    	}else{
    		echo json_encode("null");
    	}
    }
    
    if($_POST["id_estado"])
    {
        $id_estado=$_POST["id_estado"];
        
        $query = new query();
        $municipios = $query->select("id, nombre", "municipio","idEstado=$id_estado");
        if ($municipios) 
        {
            foreach ($municipios as $municipio) {
                $res .= '<option value="' . $municipio->id . '">'.utf8_encode($municipio->nombre).'</option>';
            }
            $miArray = array("respuesta"=>$res);
            echo json_encode($miArray);
        }else{
            echo json_encode("null");
        }
    }else if($_POST["id_koinonia"])
    {
        $id_koinonia=$_POST["id_koinonia"];
        $query = new query();
        if ($query->update("koinonia","status=1","id=$id_koinonia")) 
        {
            echo json_encode("success");
        }else{
            echo json_encode("null");
        }
    }else if($_POST["edad"] && $_POST["tipo"])
    {
        $edad=$_POST["edad"];
        $tipo=$_POST["tipo"];
        
        $query = new query();
        $koinonias = $query->select("id, nombre", "koinonia","edad_min<=$edad and edad_max>=$edad and lugares_disponibles>0 and tipo='$tipo' and status=1");
        if ($koinonias) 
        {
            foreach ($koinonias as $koinonia) {
                $res .= '<option value="' . $koinonia->id . '">' . $koinonia->nombre . '</option>';
            }
            $miArray = array("respuesta"=>$res);
            echo json_encode($miArray);
        }else{
            echo json_encode("null");
        }
    }else if($_POST["cod_emp"] && $_POST["curso"])
    {
        $idCurso=$_POST["curso"];
        $cod_empleado=$_POST["cod_emp"];
        
        $query = new query();
        $empleado=$query->select("*", "empleado","status=1 and codigo_empleado=$cod_empleado","","arr");
        if($empleado)
        {
            $curso=$query->select("*","curso","status=1 and id=$idCurso","","arr");
            if($curso)
            {
                if ($query->insert("detalle_curso","idCurso,idEmpleado","'$curso[0]','$empleado[0]'")) 
                {
                    $miArray = array("respuesta"=>"ok");
                }else{
                    $miArray = array("respuesta"=>"error");
                }
            }else{
                $miArray = array("respuesta"=>"error");
            }
        }else{
            $miArray = array("respuesta"=>"error");
        }
        echo json_encode($miArray);
    }
}else if($_GET)
{
    
}
?>