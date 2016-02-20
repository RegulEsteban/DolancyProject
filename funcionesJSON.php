<?php 

include './funciones.php';

if($_POST)
{
    include_once './conf/query.inc';
    include_once './funcionesLogin.php';
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
    	$stocks = $query->select("s.stockid as id, shoe.price as price, m.title as model, c.title as color, z.size as size, b.name as branch_name, b.address as branch_address, b.branchid, s.status",
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
    			$transacciones = $query->select("stockid","transition_shoe_log","stockid = $stock->id","","obj");
    			$result=$result.'<tr>
                  		<td>'.$stock->model.'</td>
                  		<td>'.$stock->size.'</td>
                  		<td>'.$stock->color.'</td>
                  		<td class="viewDiscount">'.$stock->price.'</td>
                  		<td><code>'.$stock->branch_name.'</code> <i class="icon-home icon-small"></i> '.$stock->branch_address.'</td>';
    			if($stock->status==1){
    				$result=$result.'<td><i class="icon-frown icon-small"></i> No disponible</td>';
    				$result=$result.'<td><i class="icon-frown icon-small"></i> No disponible</td>';
    			}else if(count($transacciones)>0){
    				$result=$result.'<td><span class="glyphicon glyphicon-send" aria-hidden="true"></span> Importando...</td>';
    				$result=$result.'<td><span class="glyphicon glyphicon-send" aria-hidden="true"></span> Importando...</td>';
    			}else{
    				$result=$result.'<td><a href="#" class="addShoeList" stockid='.$stock->id.'><span class="glyphicon glyphicon-plus"></span> Lista de Venta</a></td>';
    				if(getBranchId()==$stock->branchid){
    					$result=$result.'<td><a role="button" stockid='.$stock->id.' data-loading-text="Importando..." class="btn btn-primary btn-sm orderImport" disabled="disabled"><span class="glyphicon glyphicon-import"></span> Importar</a></td>';
    				}else{
    					$result=$result.'<td><a role="button" stockid='.$stock->id.' branchid='.$stock->branchid.' data-loading-text="Importando..." class="btn btn-primary btn-sm orderImport" autocomplete="off"><span class="glyphicon glyphicon-import"></span> Importar</a></td>';
    				}
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
    	
    	$stockBranch = $query->select("branchid","detail_stock","stockid = $stockid","","arr");
    	if($stockBranch[0]==getBranchId()){
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
    	}else{
    		$miArray = array("error"=>"El producto no puede ser agregado a la lista de venta ya que no pertenece a la sucursal actual.</br></br><b> Solicite un traspaso.</b>");
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
    }else if($_POST["saveNewClient"]){
    	$name = $_POST["client_name"];
    	$lastname = $_POST["client_lastname"];
    	$matname = $_POST["client_matname"];
    	$email = $_POST["client_email"];
    	$phone = $_POST["client_phone"];
    	$saleid = $_POST["saleid"];
    	
    	$query = new Query();
    	$cliente = $query->select("clientid","client","firstname like '$name' and lastname like '$lastname' and email like '$email' and phone like '$phone'", "", "obj");
    	if(count($cliente)>0){
    		$cliente = $query->select("clientid","client","firstname like '$name' and lastname like '$lastname' and email like '$email' and phone like '$phone'", "", "arr");
    		if($query->update("sale", "client_opid = $cliente[0]", "saleid = $saleid","")){
    			$miArray = array("error"=>null);
    			echo json_encode($miArray);
    		}else{
    			$miArray = array("error"=>"Error al asignar cliente a venta.");
    			echo json_encode($miArray);
    		}
    	}else{
    		if($query->insert("client", "firstname, lastname, matname, email, phone","'$name', '$lastname', '$matname', '$email', '$phone'","")){
    			$cliente = $query->select("clientid","client","firstname like '$name' and lastname like '$lastname' and email like '$email' and phone like '$phone'", "", "arr");
    			if($query->update("sale", "client_opid = $cliente[0]", "saleid = $saleid","")){
    				$miArray = array("error"=>null);
    				echo json_encode($miArray);
    			}else{
    				$miArray = array("error"=>"Error al asignar cliente a venta.");
    				echo json_encode($miArray);
    			}
    		}else{
    			$miArray = array("error"=>"Error al insertar nuevo cliente a venta.");
    			echo json_encode($miArray);
    		}
    	}
    }else if($_POST["saveNewEmployee"]){
    	$name = $_POST["employee_name"];
    	$lastname = $_POST["employee_lastname"];
    	$matname = $_POST["employee_matname"];
    	$email = $_POST["employee_email"];
    	$phone = $_POST["employee_phone"];
    	$address = $_POST["employee_address"];
    	$type = $_POST["employee_type"];
    	$branchid = $_POST["employee_branch"];
    	 
    	$query = new Query();
    	
    	if($query->insert("employee", "firstname, lastname, matname, email, phone, address, type_employee, branchid","'$name', '$lastname', '$matname', '$email', '$phone', '$address', $type, $branchid","")){
    		$employee = $query->select("employeeid","employee","firstname like '$name' and lastname like '$lastname' and email like '$email' and phone like '$phone' and type_employee = $type and branchid = $branchid", "", "obj");
    		if(count($employee)==1){
    			foreach ($employee as $e){
    				$miArray = array("error"=>null,"id"=>$e->employeeid);
    				echo json_encode($miArray);
    			}
    		}else{
    			$miArray = array("error"=>"Error al insertar empleado.");
    			echo json_encode($miArray);
    		}
    	}else{
    		$miArray = array("error"=>"Error al insertar empleado.");
    		echo json_encode($miArray);
    	}
    		
    }else if($_POST["transactionShoe"]){
    	$stockid=$_POST["stockid"];
    	$branchidOrigin = $_POST["branchid"];
    	$branchidDestination = getBranchId();
    	$employeeid = getUsuId();
    	
    	$query = new Query();
    	if(!$query->insert("transition_shoe_log", "branch_destination_id, branch_origin_id, stockid, date_transition_down, employeeid_order", "$branchidDestination, $branchidOrigin, $stockid, NOW(), $employeeid","")){
    		$miArray = array("error"=>"No se pudo registrar la transacción.");
    		echo json_encode($miArray);
    	}else{
    		$miArray = array("respuesta"=>"ok");
    		echo json_encode($miArray);
    	}
    }else if($_POST["removeEmployee"]){
    	$employeeid = $_POST["employeeid"];
    	
    	$query = new Query();
    	if(!$query->update("employee", "status = 0", "employeeid = $employeeid","")){
    		$miArray = array("error"=>"No se pudo eliminar empleado.");
    		echo json_encode($miArray);
    	}else{
    		$miArray = array("respuesta"=>"ok");
    		echo json_encode($miArray);
    	}
    }else if($_POST["getTransactions"]){
    	$employeeid = getUsuId();
    	$branchid = getBranchId();
    	$res = "";
    	
    	$query = new Query();
    	$transacciones = $query->select("transitionid, t.date_transition_down, employeeid_sender, 
    									t.date_transition_up, employeeid_transporter, employeeid_receiber,
    									concat(eo.firstname,' ',eo.lastname,' ',eo.matname) as employee_order, 
    									concat(bo.name,' ',bo.address) as branch_origin, 
    									concat(bd.name,' ',bd.address) as branch_destination, 
    									m.title as model, c.title as color, sz.size, s.stockid",
    			"transition_shoe_log t
				join employee eo on t.employeeid_order = eo.employeeid
				join branch bo on t.branch_origin_id = bo.branchid 
				join branch bd on t.branch_destination_id = bd.branchid
				join detail_stock s on t.stockid = s.stockid
				join shoe sh on s.shoeid = sh.shoeid
				join model m on sh.modelid = m.modelid
				join color c on sh.colorid = c.colorid
				join sizes sz on sh.sizesid = sz.sizesid",
				"","","obj");
    	
    	if(count($transacciones)>0){
    		foreach ($transacciones as $t){
    			$e_transporter = "Sin confirmar";
    			$e_sender = "Sin confirmar";
    			if($t->employeeid_transporter!=null){
    				$e_transporter_tmp = $query->select("concat(firstname,' ',lastname,' ',matname)","employee","employeeid = $t->employeeid_transporter","","arr");
    				$e_transporter = $e_transporter_tmp[0];
    			}
    			if($t->employeeid_sender!=null){
    				$e_sender_tmp = $query->select("concat(firstname,' ',lastname,' ',matname)","employee","employeeid = $t->employeeid_sender","","arr");
    				$e_sender = $e_sender_tmp[0];
    			}
    			if($t->employeeid_receiber!=null){
    				$e_receiver_tmp = $query->select("concat(firstname,' ',lastname,' ',matname)","employee","employeeid = $t->employeeid_receiber","","arr");
    				$e_receiver = $e_receiver_tmp[0];
    			}
    			$res=$res."<tr>
    					<td>".$t->model."</td>
    					<td>".$t->color."</td>
    					<td>".$t->size."</td>
    					<td>".utf8_encode($t->branch_origin)."</td>
    					<td>".$t->date_transition_down."</td>
    					<td>".utf8_encode($e_sender)."</td>
    					<td>".utf8_encode($e_transporter)."</td>";
    			
    			if($t->branch_destination_id == $branchid && $t->employeeid_order == $employeeid){
    				
    			}
    				
	    		if($t->employeeid_receiber != null){
	    			$res = $res."<td>".utf8_encode($e_receiver)."</td>";
	    		}else if($t->employeeid_sender == null || $t->employeeid_transporter == null){
	    			$res = $res."<td></td>";
	    		}else{
	    			$res = $res."<td><a href='#' class='receiveStock' idt='$t->transitionid'><span class='glyphicon glyphicon-download'></span> Recibir</a></td>";
	    		}
    			
	    		$res = $res."</tr>";
    		}
    		$miArray = array("respuesta"=>$res);
    		echo json_encode($miArray);
    	}else{
    		$miArray = array("error"=>"No existen transacciones en este momento.");
    		echo json_encode($miArray);
    	}
    	
    }
    
}else if($_GET){
    
}
?>