<?php


  header('Access-Control-Allow-Origin: *');
  header("Access-Control-Allow-Credentials: true");
  header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
  header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
  header("Content-Type: application/json; charset=utf-8");

  include "library/config.php";
  include "library/config2.php";
  //include "http://apk-pedidos.us-east-1.elasticbeanstalk.com/server_api/library/config.php";
  $postjson = json_decode(file_get_contents('php://input'), true);
  $today    = date('Y-m-d');



  if($postjson['aksi']=='add'){

  	  $query = mysqli_query($mysqli, "INSERT INTO SeguimientoTrabajos2 SET
  		strNombreNegocio = '$postjson[strNombreNegocio]',
  		subject = '$postjson[subject]', 
      jobid	= '$postjson[jobid]',
      SicotraAsignada = '$postjson[SicotraAsignada]',
      idEstatusMotor = '$postjson[idEstatusMotor]'
    ");
    
    

  	$idcust = mysqli_insert_id($mysqli);

  	if($query) $result = json_encode(array('success'=>true, 'idMotorAsig'=>$idcust));
  	else $result = json_encode(array('success'=>false));

  	echo $result;

  }

  elseif($postjson['aksi']=='getdata'){
    $data = array();
    
    $query = mysqli_query($mysqli, "SELECT * FROM 
    pl_estatusmotor t2, seguimientotrabajos t1
    where t1.idEstatusMotor = t2.idEstatusMotor 
    and t1.SicotraAsignada = '$postjson[username]' and 
    (t1.idEstatusMotor ='1' or t1.idEstatusMotor ='3') and t1.fechaAtencion = current_date() /*las del dia de hoy o +1*/
    and t1.intLoteEjecucion in (select max(intLoteEjecucion) 
    from seguimientotrabajos)
    ORDER BY t1.idMotorAsig asc LIMIT $postjson[start],$postjson[limit]");



  	while($row = mysqli_fetch_array($query)){
      
      //array_push

  		$data[] = array(
  			'idMotorAsig' => utf8_encode($row['idMotorAsig']),
  			'strNombreNegocio' => utf8_encode($row['strNombreNegocio']),
  			'subject' => utf8_encode($row['subject']),
        'horaInicioOrden' => utf8_encode($row['horaInicioOrden']),
        'jobid' => utf8_encode($row['jobid']),
        'SicotraAsignada' => utf8_encode($row['SicotraAsignada']),
        'idEstatusMotor' => utf8_encode($row['idEstatusMotor']),
        'Secuencia' => utf8_encode($row['Secuencia']),
        'strEstatusMotor' => utf8_encode($row['strEstatusMotor'])

  		);
    }
  
    
    if($query) $result = json_encode(array('success'=>true, 'result'=>$data));
    else $result = json_encode(array('success'=>false));

    echo $result;

  }



  elseif($postjson['aksi']=='getdataDetails'){

    $query2 = "SELECT * FROM delivery_dish.ordenes as od
    inner join delivery_dish.objetivos as ob on ob.idOrden = od.idOrden
    inner join delivery_dish.food_deliverys as f on f.idOrden = od.idOrden
    where ob.tipo ='Pick' and ob.idOrden='$postjson[jobid]'
    LIMIT $postjson[start]";
    

    $result = $mysqli2->query($query2);

    //var_dump ($result);
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $data2[] = array(
          'idOrden' => utf8_encode($row['idOrden']),
          'calle' => utf8_encode($row['calle']),
          'exterior' => utf8_encode($row['exterior']),
          'interior' => utf8_encode($row['interior']),
          'colonia' => utf8_encode($row['colonia']),
          'delegacion' => utf8_encode($row['delegacion']),
          'nombre' => utf8_encode($row['nombre']),
          'apellidos' => utf8_encode($row['apellidos']),
          'telefonoMovil' => utf8_encode($row['telefonoMovil']),
          'formaPago' => utf8_encode($row['formaPago']),
          'total' => utf8_encode($row['total']),
          'cambio' => utf8_encode($row['cambio']),
          'dimension' => utf8_encode($row['dimension']),
          'numeroPedido' => utf8_encode($row['numeroPedido']),
          'detallePedido' => utf8_encode($row['detallePedido']),
          'orden' => utf8_encode($row['orden'])

          

        );
      }
    } else {
      echo "0 results";
    }
    
    $mysqli2->close();
    
    
        if($query2) $result = json_encode(array('success'=>true, 'result'=>$data2));
        else $result = json_encode(array('success'=>false));
    
        echo $result;
    
  }







  elseif($postjson['aksi']=='getdataDetailsDelivery'){

    $query2 = "SELECT * FROM delivery_dish.ordenes as od
    inner join delivery_dish.objetivos as ob on ob.idOrden = od.idOrden
    inner join delivery_dish.food_deliverys as f on f.idOrden = od.idOrden
    where ob.tipo ='Delivery' and ob.idOrden='$postjson[jobid]'
    LIMIT $postjson[start]";
    
    
    $result = $mysqli2->query($query2);

    //var_dump ($result);
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $data2[] = array(
          'idOrden' => utf8_encode($row['idOrden']),
          'calle' => utf8_encode($row['calle']),
          'exterior' => utf8_encode($row['exterior']),
          'interior' => utf8_encode($row['interior']),
          'colonia' => utf8_encode($row['colonia']),
          'delegacion' => utf8_encode($row['delegacion']),
          'nombre' => utf8_encode($row['nombre']),
          'apellidos' => utf8_encode($row['apellidos']),
          'telefonoMovil' => utf8_encode($row['telefonoMovil']),
          'formaPago' => utf8_encode($row['formaPago']),
          'total' => utf8_encode($row['total']),
          'cambio' => utf8_encode($row['cambio']),
          'dimension' => utf8_encode($row['dimension']),
          'numeroPedido' => utf8_encode($row['numeroPedido']),
          'detallePedido' => utf8_encode($row['detallePedido']),
          'orden' => utf8_encode($row['orden'])


        );
      }
    } else {
      echo "0 results";
    }
    
    $mysqli2->close();
    
    
        if($query2) $result = json_encode(array('success'=>true, 'result'=>$data2));
        else $result = json_encode(array('success'=>false));
    
        echo $result;
    
  }






  elseif($postjson['aksi']=='getOrden'){

    $query2 = "SELECT * FROM delivery_dish.ordenes as od
    inner join delivery_dish.objetivos as ob on ob.idOrden = od.idOrden
    inner join delivery_dish.food_deliverys as f on f.idOrden = od.idOrden
    where ob.tipo ='Delivery' and ob.idOrden='$postjson[jobid]'
    LIMIT $postjson[start]";
    
    $result = $mysqli2->query($query2);
    //var_dump ($result);
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $data2[] = array(
          'orden' => utf8_encode($row['orden'])
        );
      }
    } else {
      $data2 = "0 results";
    }
    $mysqli2->close();

        if($query2) $result = json_encode(array('success'=>true, 'result'=> $data2));
        else $result = json_encode(array('success'=>false));
    
        echo $result;
    
  }



  







  



  elseif($postjson['aksi']=='update'){

    if($postjson['idEstatusMotor']!='4'){

    
  	$query = mysqli_query($mysqli, "UPDATE seguimientotrabajos SET 
  		strNombreNegocio = '$postjson[strNombreNegocio]',
  		subject = '$postjson[subject]',
      jobid = '$postjson[jobid]',
      SicotraAsignada = '$postjson[SicotraAsignada]',
      idEstatusMotor = '$postjson[idEstatusMotor]' WHERE idMotorAsig = '$postjson[idMotorAsig]'");


  	if($query) $result = json_encode(array('success'=>true, 'result'=>'success'));
  	else $result = json_encode(array('success'=>false, 'result'=>'error'));

  	echo $result;
    }
    else{
      $query = mysqli_query($mysqli, "UPDATE `seguimientotrabajos` SET idEstatusMotor = '4' WHERE idMotorAsig in(
        select idMotorAsig from `seguimientotrabajos` where jobid='$postjson[jobid]' and SicotraAsignada='$postjson[SicotraAsignada]' 
        and intLoteEjecucion in (select max(intLoteEjecucion) from seguimientotrabajos))");

  	if($query) $result = json_encode(array('success'=>true, 'result'=>'success'));
  	else $result = json_encode(array('success'=>false, 'result'=>'error'));
    
    echo $result;

  }
  }
  




  elseif($postjson['aksi']=='delete'){
  	$query = mysqli_query($mysqli, "DELETE FROM seguimientotrabajos WHERE idMotorAsig='$postjson[idMotorAsig]'");

  	if($query) $result = json_encode(array('success'=>true, 'result'=>'success'));
  	else $result = json_encode(array('success'=>false, 'result'=>'error'));

  	echo $result;

  }

  elseif($postjson['aksi']=="login"){
    $password = md5($postjson['password']);
    $query = mysqli_query($mysqli, "SELECT * FROM master_user t1, pl_cuadrilla t2
    where t1.username = t2.intCuadrilla
    and t1.username='$postjson[username]'
    AND password='$password'");
    $check = mysqli_num_rows($query);

    if($check>0){
      $data = mysqli_fetch_array($query);
      $datauser = array(
        'user_id' => $data['user_id'],
        'username' => $data['username'],
        'password' => $data['password'],
        'strNombreCuadrilla' => $data['strNombreCuadrilla']
      );

      if($data['status']=='y'){
        $result = json_encode(array('success'=>true, 'result'=>$datauser));
      }else{
        $result = json_encode(array('success'=>false, 'msg'=>'Account Inactive')); 
      }

    }else{
      $result = json_encode(array('success'=>false, 'msg'=>'Unregister Account'));
    }

    echo $result;
  }

  elseif($postjson['aksi']=="register"){
    $password = md5($postjson['password']);
    $query = mysqli_query($mysqli, "INSERT INTO master_user SET
      username = '$postjson[username]',
      password = '$password',
      status   = 'y'
    ");

    if($query) $result = json_encode(array('success'=>true));
    else $result = json_encode(array('success'=>false, 'msg'=>'error, please try again'));

    echo $result;
  }


?>