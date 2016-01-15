<?php 

include './funciones.php';

if($_POST)
{
    include_once './conf/query.inc';
    //buscar zapato por atributos
    if($_POST["model"]!=null && $_POST["color"]!=null && $_POST["size"]!=null){
    	$modelid = $_POST["model"];
    	$colorid = $_POST["color"];
    	$sizeid = $_POST["size"];
    	$sentencia = "s.status = 0 or s.status = 1 or s.status = 3 ";
    	
    	if($modelid!=0){
    		$sentencia=$sentencia."and m.modelid = $modelid ";
    	}
    	if($colorid!=0){
    		$sentencia=$sentencia."and c.colorid = $colorid ";
    	}
    	if($sizeid!=0){
    		$sentencia=$sentencia."and z.sizesid = $sizeid ";
    	}
    	
    	$query = new query();
    	$stocks = $query->select("s.stockid as id, shoe.price as price, m.title as model, c.title as color, z.size as size, b.name as branch_name, b.address as branch_address, s.status",
    					"detail_stock s
						join shoe on s.shoeid = shoe.shoeid
						join model m on m.modelid = shoe.modelid
						join sizes z on z.sizesid = shoe.sizesid
						join color c on c.colorid = shoe.colorid
						join branch b on b.branchid = s.branchid",
    					$sentencia." order by s.shoeid","", "obj");
    	
    	if(count($stocks)>0){
    		$result = "";
    		foreach ($stocks as $stock){
    			$result=$result.'<tr>
                  		<td>'.$stock->model.'</td>
                  		<td>'.$stock->size.'</td>
                  		<td>'.$stock->color.'</td>
                  		<td class="viewDiscount">'.$stock->price.'</td>
                  		<td><code>'.$stock->branch_name.'</code> <i class="icon-home icon-small"></i> '.$stock->branch_address.'</td>';
    			if($stock->status==1){
    				$result=$result.'<td><i class="icon-frown icon-small"></i> No disponible</td>';
    			}else{
    				$result=$result.'<td><a href="#" class="addShoeList" stockid='.$stock->id.'><span class="glyphicon glyphicon-plus"></span> Lista de Venta</a></td>';
    			}
    			$result=$result.'</tr>';
    		}
    		echo json_encode($result);
    	}else{
    		echo json_encode("null");
    	}
    }else if($_POST["addShoe"]){
    	$stockid = $_POST["stockid"];
    	$saleid = $_POST["saleid"];

    	$query = new Query();
    	
    	include_once './funcionesLogin.php';
    	$employeeid = getUsuId();
    	if(getUsuId()!=0){
    		if($saleid==0){
				if($query->insert("sale", "employeeid, total", "$employeeid, 0.0")){
					$ventas = $query->select("saleid", "sale", "employeeid = $employeeid", "and status=0", "obj");
					if(count($ventas)==1){
						foreach ($ventas as $venta){
							if($query->insert("detail_sale", "saleid,stockid","$venta->saleid,$stockid","") && $query->update("detail_stock", "status = 1","stockid = $stockid")){
								$stocks = $query->select("s.stockid as id, shoe.price as price, m.title as model, c.title as color, z.size as size",
										"detail_stock s
											join shoe on s.shoeid = shoe.shoeid
											join model m on m.modelid = shoe.modelid
											join sizes z on z.sizesid = shoe.sizesid
											join color c on c.colorid = shoe.colorid",
										"s.stockid = $stockid ","", "obj");
							
								if(count($stocks)==1){
									foreach ($stocks as $stock){
										$miArray = array("error"=>null,"model"=>$stock->model,"color"=>$stock->color,"size"=>$stock->size,"price"=>$stock->price,"saleid"=>$venta->saleid,"stockid"=>$stock->id);
										echo json_encode($miArray);
									}
								}else{
									$miArray = array("error"=>"Error al consultar existencia. Favor de solicitar al administrador.");
									echo json_encode($miArray);
								}
							}else{
								$miArray = array("error"=>"Error al agregar a la lista de venta. Favor de solicitar al administrador.");
								echo json_encode($miArray);
							}
						}
					}else{
						$miArray = array("error"=>"Error al insertar venta incompleta. Favor de solicitar al administrador.");
						echo json_encode($miArray);
					}
				}else{
					$miArray = array("error"=>"Error al insertar venta incompleta. Favor de solicitar al administrador.");
					echo json_encode($miArray);
				}
    		}else{
    		    if($query->insert("detail_sale", "saleid,stockid","$saleid,$stockid","") && $query->update("detail_stock", "status = 1","stockid = $stockid")){
    				$stocks = $query->select("s.stockid as id, shoe.price as price, m.title as model, c.title as color, z.size as size",
						    				"detail_stock s
											join shoe on s.shoeid = shoe.shoeid
											join model m on m.modelid = shoe.modelid
											join sizes z on z.sizesid = shoe.sizesid
											join color c on c.colorid = shoe.colorid",
						    				"s.stockid = $stockid ","", "obj");
    		
		    		if(count($stocks)==1){
		    			foreach ($stocks as $stock){
		    				$miArray = array("error"=>null,"model"=>$stock->model,"color"=>$stock->color,"size"=>$stock->size,"price"=>$stock->price,"saleid"=>$saleid,"stockid"=>$stock->id);
		    				echo json_encode($miArray);
		    			}
					}else{
						$miArray = array("error"=>"Error al consultar existencia. Favor de solicitar al administrador.");
						echo json_encode($miArray);
					}
		    	}else{
		    		$miArray = array("error"=>"Error al agregar a la lista de venta. Favor de solicitar al administrador.");
		    		echo json_encode($miArray);
		    	}
    		}
    	}else{
    		$miArray = array("error"=>"No hay usuario firmado");
			echo json_encode($miArray);
    	}
    	
    }else if($_POST["removeShoe"]){
    	$stockid = $_POST["stockid"];
    	$saleid = $_POST["saleid"];
    	
    	$query = new Query();
    	
    	if($saleid!=0){
    		if($query->remove("detail_sale", "saleid = $saleid","and stockid = $stockid") && $query->update("detail_stock", "status = 0","stockid = $stockid")){
    			$miArray = array("error"=>null);
    			echo json_encode($miArray);
    		}else{
    			$miArray = array("error"=>"No se pudo eliminar de la lista de venta.");
    			echo json_encode($miArray);
    		}
    	}else{
    		$miArray = array("error"=>"No hay venta seleccionada. Favor de solicitar al administrador.");
    		echo json_encode($miArray);
    	}
    }else if($_POST["getSale"]){
    	$saleid = $_POST["saleid"];
    	
    	$query = new Query();
    	if($saleid!=0){
    		$shoes = $query->select("shoe.price as price, m.title as model, c.title as color, z.size as size, ds.discountid",
    							"detail_sale ds
								join detail_stock s on ds.stockid = s.stockid
								join shoe on s.shoeid = shoe.shoeid
								join model m on m.modelid = shoe.modelid
								join sizes z on z.sizesid = shoe.sizesid
								join color c on c.colorid = shoe.colorid",
    							"ds.saleid = $saleid","","obj");
    		
    		if(count($shoes)>0){
    			$res = "";
    			$total = 0.0;
    			foreach ($shoes as $shoe){
    				$res = $res."<tr>
    							<td>$shoe->model</td>
    							<td>$shoe->color</td>
    							<td>$shoe->size</td>
    							<td>$shoe->price</td>";
    				
    				if($shoe->discountid!=0){
    					$discount = $query->select("monto, description","cash_discount","discountid = $shoe->discountid","and type=0","obj");
    					if(count($discount)==1){
    						foreach ($discount as $d){
    							$descuento = ($shoe->price)-($d->monto);
    							$res = $res."<td>".number_format($descuento, 2, '.', '')."</td>";
    							$total = $total + $descuento;
    						}
    					}else{
    						$miArray = array("error"=>"Demasiados descuento para un solo producto.");
    						echo json_encode($miArray);
    					}
    				}else{
    					$res = $res."<td>$shoe->price</td>";
    					$total = $total + $shoe->price;
    				}
    				$res = $res."</tr>";
    			}
    			$miArray = array("error"=>null, "resultado"=>$res, "total"=>"<h1>$".number_format($total, 2, '.', ',')."</h1>");
    			echo json_encode($miArray);
    		}else{
    			$miArray = array("error"=>"No hay productos en lista de venta.");
    			echo json_encode($miArray);
    		}
    	}else{
    		$miArray = array("error"=>"No hay venta seleccionada. Favor de solicitar al administrador.");
    		echo json_encode($miArray);
    	}
    }else if($_POST["appDiscount"]){
    	$detailSaleId = $_POST["detailSaleId"];
    	$discountid = $_POST["discountid"];
    	
    	$query = new Query();
    	if($detailSaleId!=0 && $discountid!=0){
    		if($query->update("detail_sale","discountid = $discountid", "detail_sale_id = $detailSaleId","")){
    			$miArray = array("error"=>null);
    			echo json_encode($miArray);
    		}else{
    			$miArray = array("error"=>"No se pudo aplicar el descuento. Favor de solicitar al administrador.");
    			echo json_encode($miArray);
    		}
    	}else{
    		$miArray = array("error"=>"Los valores para el descuento son incorrectos. Favor de solicitar al administrador.");
    		echo json_encode($miArray);
    	}
    }else if($_POST["getClients"]){
    	$query = new Query();
    	$clients = $query->select("firstname, lastname, matname, email, phone, clientid","client","1=1","","obj");
    	if(count($clients)>0){
    		$miArray = array("error"=>null,"resultado"=>$clients);
    		echo json_encode($miArray);
    	}else{
    		$miArray = array("error"=>"Sin valores");
    		echo json_encode($miArray);
    		
    	}
    }else if($_POST["saveClient"]){
    	$clientid = $_POST["clientid"];
    	$saleid = $_POST["saleid"];
    	
    	$query = new Query();
    	if($query->update("sale", "client_opid = $clientid", "saleid = $saleid","")){
    		$miArray = array("error"=>null);
    		echo json_encode($miArray);
    	}else{
    		$miArray = array("error"=>"Error al asignar cliente a venta.");
    		echo json_encode($miArray);
    	}
    }
    
//     if($_POST["id_estado"])
//     {
//         $id_estado=$_POST["id_estado"];
        
//         $query = new query();
//         $municipios = $query->select("id, nombre", "municipio","idEstado=$id_estado");
//         if ($municipios) 
//         {
//             foreach ($municipios as $municipio) {
//                 $res .= '<option value="' . $municipio->id . '">'.utf8_encode($municipio->nombre).'</option>';
//             }
//             $miArray = array("respuesta"=>$res);
//             echo json_encode($miArray);
//         }else{
//             echo json_encode("null");
//         }
//     }else if($_POST["id_koinonia"])
//     {
//         $id_koinonia=$_POST["id_koinonia"];
//         $query = new query();
//         if ($query->update("koinonia","status=1","id=$id_koinonia")) 
//         {
//             echo json_encode("success");
//         }else{
//             echo json_encode("null");
//         }
//     }else if($_POST["edad"] && $_POST["tipo"])
//     {
//         $edad=$_POST["edad"];
//         $tipo=$_POST["tipo"];
        
//         $query = new query();
//         $koinonias = $query->select("id, nombre", "koinonia","edad_min<=$edad and edad_max>=$edad and lugares_disponibles>0 and tipo='$tipo' and status=1");
//         if ($koinonias) 
//         {
//             foreach ($koinonias as $koinonia) {
//                 $res .= '<option value="' . $koinonia->id . '">' . $koinonia->nombre . '</option>';
//             }
//             $miArray = array("respuesta"=>$res);
//             echo json_encode($miArray);
//         }else{
//             echo json_encode("null");
//         }
//     }else if($_POST["cod_emp"] && $_POST["curso"])
//     {
//         $idCurso=$_POST["curso"];
//         $cod_empleado=$_POST["cod_emp"];
        
//         $query = new query();
//         $empleado=$query->select("*", "empleado","status=1 and codigo_empleado=$cod_empleado","","arr");
//         if($empleado)
//         {
//             $curso=$query->select("*","curso","status=1 and id=$idCurso","","arr");
//             if($curso)
//             {
//                 if ($query->insert("detalle_curso","idCurso,idEmpleado","'$curso[0]','$empleado[0]'")) 
//                 {
//                     $miArray = array("respuesta"=>"ok");
//                 }else{
//                     $miArray = array("respuesta"=>"error");
//                 }
//             }else{
//                 $miArray = array("respuesta"=>"error");
//             }
//         }else{
//             $miArray = array("respuesta"=>"error");
//         }
//         echo json_encode($miArray);
//     }
}else if($_GET){
    
}
?>