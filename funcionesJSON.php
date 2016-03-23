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
    			$transacciones = $query->select("stockid","transition_shoe_log","stockid = $stock->id","and employeeid_receiber is null","obj");
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
    								$stocks = $query->select("s.stockid as id, shoe.price as price, m.title as model, c.title as color, z.size as size, ds.detail_sale_id as id_detail",
    										"detail_sale ds
											join detail_stock s on ds.stockid = s.stockid
											join shoe on s.shoeid = shoe.shoeid
											join model m on m.modelid = shoe.modelid
											join sizes z on z.sizesid = shoe.sizesid
											join color c on c.colorid = shoe.colorid",
    										"s.stockid = $stockid ","and ds.saleid = $venta->saleid", "obj");
    									
    								if(count($stocks)==1){
    									foreach ($stocks as $stock){
    										$miArray = array("error"=>null,"model"=>$stock->model,"color"=>$stock->color,"size"=>$stock->size,"price"=>$stock->price,"saleid"=>$venta->saleid,"stockid"=>$stock->id,"id_detail"=>$stock->id_detail);
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
    					$stocks = $query->select("s.stockid as id, shoe.price as price, m.title as model, c.title as color, z.size as size, ds.detail_sale_id as id_detail",
    										"detail_sale ds
											join detail_stock s on ds.stockid = s.stockid
											join shoe on s.shoeid = shoe.shoeid
											join model m on m.modelid = shoe.modelid
											join sizes z on z.sizesid = shoe.sizesid
											join color c on c.colorid = shoe.colorid",
    										"s.stockid = $stockid ","and ds.saleid = $saleid", "obj");
    		
    					if(count($stocks)==1){
    						foreach ($stocks as $stock){
    							$miArray = array("error"=>null,"model"=>$stock->model,"color"=>$stock->color,"size"=>$stock->size,"price"=>$stock->price,"saleid"=>$saleid,"stockid"=>$stock->id,"id_detail"=>$stock->id_detail);
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
    		$shoes = $query->select("shoe.price as price, m.title as model, c.title as color, z.size as size, cd.discountid, cd.monto",
    							"detail_sale ds
								join detail_stock s on ds.stockid = s.stockid
								join shoe on s.shoeid = shoe.shoeid
								join model m on m.modelid = shoe.modelid
								join sizes z on z.sizesid = shoe.sizesid
								join color c on c.colorid = shoe.colorid
    							left join cash_discount cd on cd.discountid = ds.discountid",
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
    				
    				if($shoe->discountid!=null){
    					$descuento = ($shoe->price)-($shoe->monto);
    					$res = $res."<td>".number_format($descuento, 2, '.', '')."</td>";
    					$total = $total + $descuento;
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
    	if($detailSaleId!=0){
    		if($query->update("detail_sale","discountid = $discountid", "detail_sale_id = $detailSaleId","")){
    			$montoArr = $query->select("monto","cash_discount","discountid = $discountid","","arr");
    			$miArray = array("error"=>null, "monto"=>$montoArr[0]);
    			echo json_encode($miArray);
    		}else{
    			$miArray = array("error"=>"No se pudo aplicar el descuento. Favor de solicitar al administrador.");
    			echo json_encode($miArray);
    		}
    	}else{
    		$miArray = array("error"=>"Los valores para el descuento son incorrectos. Favor de solicitar al administrador.");
    		echo json_encode($miArray);
    	}
    }else if($_POST["getDiscount"]){
    	$detailSaleId = $_POST["detailSaleId"];
    	
    	$query = new Query();
    	$values = $query->select("ds.detail_sale_id, ds.saleid, ds.stockid, d.discountid, d.monto, d.description, d.date_expiration, d.type, d.acumulated",
    							"detail_sale ds left join cash_discount d on ds.discountid = d.discountid","ds.detail_sale_id = $detailSaleId","","obj");
    	if(count($values)==1){
    		foreach ($values as $v){
    			$miArray = array("error"=>null,"detail_sale_id"=>$v->detail_sale_id,"discountid"=>$v->discountid,"monto"=>$v->monto); 	
    			echo json_encode($miArray);
    		}
    	}else{
    		$miArray = array("error"=>"Los valores para el descuento son incorrectos. Favor de llamar a su administrador.");
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
    	$branchid = getBranchId();
    	$employeeid = getUsuId();
    	$res = "";
    	
    	$query = new Query();
    	$transaccionesArr = $query->select("transitionid, t.date_transition_down, employeeid_sender, 
    									t.date_transition_up, employeeid_transporter, employeeid_receiber,
    									concat(eo.firstname,' ',eo.lastname,' ',eo.matname) as employee_order, employeeid_order, 
    									concat(bo.name,' ',bo.address) as branch_origin, branch_origin_id,
    									concat(bd.name,' ',bd.address) as branch_destination, branch_destination_id,
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
				"branch_origin_id = $branchid or branch_destination_id = $branchid",
    			"order by t.date_transition_down desc","obj");
    	
    	if(count($transaccionesArr)>0){
    		$res = $res.'<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
    		foreach ((array) $transaccionesArr as $t){
    			
    			$e_transporter = "Sin confirmar";
    			$e_sender = "Sin confirmar";
    			$e_receiver = "Sin confirmar";
    			if($t->employeeid_transporter!=null){
    				$e_transporter_tmp = $query->select("concat(firstname,' ',lastname,' ',matname)","employee","employeeid = $t->employeeid_transporter","","arr");
    				$e_transporter = utf8_encode($e_transporter_tmp[0]);
    			}
    			if($t->employeeid_sender!=null){
    				$e_sender_tmp = $query->select("concat(firstname,' ',lastname,' ',matname)","employee","employeeid = $t->employeeid_sender","","arr");
    				$e_sender = utf8_encode($e_sender_tmp[0]);
    			}
    			if($t->employeeid_receiber!=null){
    				$e_receiver_tmp = $query->select("concat(firstname,' ',lastname,' ',matname)","employee","employeeid = $t->employeeid_receiber","","arr");
    				$e_receiver = utf8_encode($e_receiver_tmp[0]);
    			}
    			
    			$res = $res.'<div class="panel panel-default"><div class="panel-heading" role="tab" id="heading'.$t->transitionid.'">';
    			$res = $res.'<h4 class="panel-title"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$t->transitionid.'" aria-expanded="true" aria-controls="collapse'.$t->transitionid.'">';
    			
    			$res = $res.'Transacción No: <span class="label label-primary">'.$t->transitionid.'</span>&nbsp;&nbsp;&nbsp;&nbsp;Producto [<b>Modelo:</b> '.$t->model.' <b>Color:</b> '.$t->color.' <b>Talla:</b> '.$t->size.']';
    			
    			$res = $res.'</a></h4></div>';
    			
    			$res = $res.'<div id="collapse'.$t->transitionid.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading'.$t->transitionid.'">';
    			$res = $res.'<div class="panel-body">
    					<div class="col-md-12">
    						<div class="col-md-2" id="servicesIcon">
    							<div class="media services"><div class="pull-left"><i class="icon-home icon-smd"></i></div>
    								<div class="media-body">
    									'.utf8_encode($t->branch_origin).'
    								</div>
    							</div>
    						</div>
    						<div class="col-md-8">
    							<div class="progress">';
    								if($t->employeeid_receiber != null){
    									$res = $res.
    									'<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
    										<span class="sr-only">100% Complete (success)</span>
  										</div>';
    								}else if($t->employeeid_transporter != null){
    									$res = $res.
    									'<div class="progress-bar progress-bar-primary progress-bar-striped active" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
    										<span class="sr-only">80% Complete (success)</span>
  										</div>';
    								}else if($t->employeeid_sender != null){
    									$res = $res.
    									'<div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
    										<span class="sr-only">50% Complete (success)</span>
  										</div>';
    								}else{
    									$res = $res.
    									'<div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
    										<span class="sr-only">20% Complete (success)</span>
  										</div>';
    								}
    									
								$res = $res.
								'</div>
    							<div class="pull-center">
    								<table class="table">
    									<tbody>
    										<tr>
    											<td><ul class="list-inline"><li>Producto [<b>Modelo: </b>'.$t->model.' <b>Color: </b>'.$t->color.' <b>Talla: </b>'.$t->size.']</li></ul></td>
    											<td><ul class="list-inline"><li><b>Fecha: </b>'.$t->date_transition_down.'</td>
    										</tr>
    									</tbody>
									</table>
    							</div>
    						</div>
    						<div class="col-md-2" id="servicesIcon">
    							<div class="media services"><div class="pull-right"><i class="icon-home icon-smd"></i></div>
    								<div class="media-body">
    									'.utf8_encode($t->branch_destination).'
    								</div>
    							</div>
    						</div>
    					</div>
    					
						<div class="col-md-12">
							<table class="table">
    							<thead>
    								<tr>
    									<th>Petición</th>
    									<th>Envío</th>
    									<th>Transporte</th>
    									<th>Recibo</th>
    								</tr>
    							</thead>
    							<tbody>
    								<tr>
    									<td><p><span class="glyphicon glyphicon-user"></span> '.utf8_encode($t->employee_order).'</p></td>';
		    			
		    			if($t->branch_destination_id == $branchid){
		    				
		    				if($t->employeeid_receiber == null && $t->employeeid_transporter != null){
		    					$res = $res.
		    					'<td><p><span class="glyphicon glyphicon-user"></span> '.$e_sender.'</p></td>
	    						<td><p><span class="glyphicon glyphicon-user"></span> '.$e_transporter.'</p></td>
	    						<td><p><a href="#" class="receiveStock" idt="'.$t->transitionid.'"><span class="glyphicon glyphicon-download"></span> Recibir</a></p></td>';
		    				}else{
		    					$res = $res.
		    					'<td><p><span class="glyphicon glyphicon-user"></span> '.$e_sender.'</p></td>
	    						<td><p><span class="glyphicon glyphicon-user"></span> '.$e_transporter.'</p></td>
	    						<td><p><span class="glyphicon glyphicon-user"></span> '.$e_receiver.'</p></td>';
		    				}
		    				
		    			}else if($t->branch_origin_id == $branchid){
		    				if($t->employeeid_sender == null){
				    			$res = $res.
				    			'<td><p><a href="#" class="doSendShoe" idt="'.$t->transitionid.'"><span class="glyphicon glyphicon-download"></span> Transportar</a></p></td>
	    						<td><p><span class="glyphicon glyphicon-user"></span> '.$e_transporter.'</p></td>
	    						<td><p><span class="glyphicon glyphicon-user"></span> '.$e_receiver.'</p></td>';
		    				}else if($t->employeeid_transporter == null){
		    					$res = $res.
		    					'<td><p><span class="glyphicon glyphicon-user"></span> '.$e_sender.'</p></td>
	    						<td><p><a href="#" class="doTransition" idt="'.$t->transitionid.'"><span class="glyphicon glyphicon-download"></span> Transportar</a></p></td>
	    						<td><p><span class="glyphicon glyphicon-user"></span> '.$e_receiver.'</p></td>';
		    				}else{
		    					$res = $res.
		    					'<td><p><span class="glyphicon glyphicon-user"></span> '.$e_sender.'</p></td>
	    						<td><p><span class="glyphicon glyphicon-user"></span> '.$e_transporter.'</p></td>
	    						<td><p><span class="glyphicon glyphicon-user"></span> '.$e_receiver.'</p></td>';
		    				}
		    			}
    			
    				$res = $res.'</tr></tbody></table></div>';
    			
    			$res = $res.'</div></div></div>';
    			
    		}
    		$res = $res.'</div>';
    		
    		$miArray = array("respuesta"=>$res);
    		echo json_encode($miArray);
    	}else{
    		$miArray = array("error"=>"No existen transacciones en este momento.");
    		echo json_encode($miArray);
    	}
    	
    }else if($_POST["saveNewUser"]){
    	$usu_pass = $_POST["usu_pass"];
    	$employee_select = $_POST["employee_select"];
    	$usu_email = $_POST["usu_email"];
    	$usu_pass=$usu_pass."#dolancy100291#";
    	$query = new Query();
    	
    	if($query->insert("user_credentials", "email, password, employeeid, status","'".sha1(limpiaEmail($usu_email))."', '".sha1(__($usu_pass))."', $employee_select, 0","")){
    		$employee = $query->select("concat(firstname,' ',lastname) as name, email, phone, address, type_employee","employee","employeeid = $employee_select", "", "obj");
    		if(count($employee)==1){
    			foreach ($employee as $e){
    				$tipo = "";
    				if($em->type_employee == 0) $tipo="Vendedor";
    				else if($em->type_employee == 1) $tipo = "Gerente";
    				else if($em->type_employee == 2) $tipo = "Director";
    				
    				$activo = "<span class='glyphicon glyphicon-ok-circle'></span> Activo";
    				$action = "<a href='#'><span class='glyphicon glyphicon-pencil'></span> Editar</a> | <a href='#'><span class='glyphicon glyphicon-trash'></span> Desactivar</a>";
    				
    				$miArray = array("error"=>null, "tipo"=>$tipo, "activo"=>$activo, "name"=>utf8_encode($em->name), "address"=>utf8_encode($em->address), "email"=>$em->email, "phone"=>$em->phone, "accion"=>$action);
    				echo json_encode($miArray);
    			}
    		}else{
    			$miArray = array("error"=>"Error al insertar usuario.");
    			echo json_encode($miArray);
    		}
    	}else{
    		$miArray = array("error"=>"Error al insertar usuario.");
    		echo json_encode($miArray);
    	}
    		
    }else if($_POST["getShoeProperties"]){
    	$stockid=$_POST["stockid"];
    	
    	$query = new Query();
    	$shoe = $query->select("shoe.colorid, shoe.modelid, shoe.sizesid",
    			"detail_stock s join shoe on s.shoeid = shoe.shoeid","s.stockid = $stockid","","arr");
    	if($shoe==null){
    		$miArray = array("error"=>"El producto no existe.");
    		echo json_encode($miArray);
    	}else{
    		$miArray = array("error"=>null, "colorid"=>$shoe[0], "modelid"=>$shoe[1], "sizesid"=>$shoe[2]);
    		echo json_encode($miArray);
    	}
    }else if($_POST["sendShoe"]){
    	$transactionid = $_POST["transactionid"];
    	$employeeid_sender = $_POST["employeeid_sender"];
    	$branchid = getBranchId();
    	
    	$query = new Query();
    	$em = $query->select("employeeid","employee","employeeid = $employeeid_sender","and branchid = $branchid","arr");
    	$tr = $query->select("transitionid","transition_shoe_log","transitionid = $transactionid","","arr");
    	if($em!=null && $tr!=null){
    		if($query->update("transition_shoe_log", "employeeid_sender = $employeeid_sender", "transitionid = $transactionid", "")){
    			$miArray = array("error"=>null);
    			echo json_encode($miArray);
    		}else{
    			$miArray = array("error"=>"La transacción no ha podido ser modificada.");
    			echo json_encode($miArray);
    		}
    	}else{
    		$miArray = array("error"=>"Los datos no son correctos, verifique sus datos.");
    		echo json_encode($miArray);
    	}
    	
    }else if($_POST["trasportShoe"]){
    	$transactionid = $_POST["transactionid"];
    	$employeeid_sender = $_POST["employeeid_sender"];
    	
    	$query = new Query();
    	$em = $query->select("employeeid","employee","employeeid = $employeeid_sender","","arr");
    	$tr = $query->select("transitionid","transition_shoe_log","transitionid = $transactionid","","arr");
    	if($em!=null && $tr!=null){
    		if($query->update("transition_shoe_log", "employeeid_transporter = $employeeid_sender", "transitionid = $transactionid", "")){
    			$miArray = array("error"=>null);
    			echo json_encode($miArray);
    		}else{
    			$miArray = array("error"=>"La transacción no ha podido ser modificada.");
    			echo json_encode($miArray);
    		}
    	}else{
    		$miArray = array("error"=>"La transacción o el empleado no existen.");
    		echo json_encode($miArray);
    	}
    	
    }else if($_POST["receiveShoe"]){
    	$transactionid = $_POST["transactionid"];
    	$employeeid_sender = $_POST["employeeid_sender"];
    	
    	$query = new Query();
    	$em = $query->select("employeeid","employee","employeeid = $employeeid_sender","","arr");
    	$tr = $query->select("transitionid, branch_destination_id, stockid","transition_shoe_log","transitionid = $transactionid","","arr");
    	if($em!=null && $tr!=null){
    		if($query->update("transition_shoe_log", "employeeid_receiber = $employeeid_sender", "transitionid = $transactionid", "") &&
    				$query->update("detail_stock", "branchid = $tr[1], date_stock_up = NOW()","stockid = $tr[2]","")){
    			$miArray = array("error"=>null);
    			echo json_encode($miArray);
    		}else{
    			$miArray = array("error"=>"La transacción no ha podido ser modificada.");
    			echo json_encode($miArray);
    		}
    	}else{
    		$miArray = array("error"=>"La transacción o el empleado no existen.");
    		echo json_encode($miArray);
    	}
    	
    }
    
}else if($_GET){
    
}
?>