<?php

class Importar {

  const CREDITUM = 0;
  const LARANA = 2;
  const CREDITUMCLIENTE = 1;


  protected $archivo='';
  private $data=array();
  private $metadata=array();
  private $experiencias=array();
  private $cliente_id=0;
  private $error='';

  function Importar($archivo='') {
    $this->archivo = $archivo;
  }

  public function getArchivo()
  {return $this->archivo;}

  public function setArchivo($val)
  {$this->archivo = $val;}

  public function Cargar($archivo='')
  {
    if($archivo!='') $this->setArchivo($archivo);

    return $this->loadDatosArchivos();

  }

  public function Convertir($tipo=Importar::CREDITUM)
  {
    if(count($this->metadata)>0){
      switch($tipo){
        case Importar::CREDITUM:
          return $this->ConvertirCreditum();
        case Importar::CREDITUMCLIENTE:
          return $this->ConvertirCreditumCliente();
        case Importar::LARANA:
          return $this->ConvertirCreditum();
      }
    }else return true;
  }
  
  public function Procesar()
  {

//			// 1- Revisar Casa Comercial
//			// 2- Revisar Cedulas de la informacion crediticia
//			// 3- Buscar si existe registro en la tabla clientes_personas
//			// 4- Verificar si el registro es nuevo, o ya existen en la BD
//
//			sql="SELECT clientes.NOMBRE FROM clientes WHERE clientes.ID_CLIENTE=" + Codigo.ToString();

    $c = new Criteria();
    $c->add(ClientesPeer::ID_CLIENTE,$this->cliente_id);
    $cliente = ClientesPeer::doSelectOne($c);

    $Conta=0;
    
		if ($cliente)
		{
    
        
//					  El cliente existe
//						sql= "SELECT MAX(creditos.FECHA_OPERACION)" +
//							" FROM clientes_personas" +
//							" INNER JOIN creditos ON (clientes_personas.ID_CLIENTE_PERSONA = creditos.ID_CLIENTE_PERSONA)" +
//							" WHERE clientes_personas.ID_CLIENTE = " + Codigo.ToString() +
//							" GROUP BY clientes_personas.ID_CLIENTE;";
//						BD.EjecutarQuery(CONN,OleConexion,sql,out DT);

              $c = new Criteria();
              //$c->clearSelectColumns()->addSelectColumn('MAX('.CreditosPeer::FECHA_OPERACION.')');
              $c->addJoin(CreditosPeer::ID_CLIENTE_PERSONA,ClientesPersonasPeer::ID_CLIENTE_PERSONA);
              $c->add(ClientesPersonasPeer::ID_CLIENTE,$cliente->getIdCliente());
              $c->addDescendingOrderByColumn(CreditosPeer::FECHA_OPERACION);
              
              $creditos = CreditosPeer::doSelectOne($c);
              
              //H::PrintR($creditos);

//
//						try
//						{Ultima_Fecha = Convert.ToDateTime(DT.Rows[0].ItemArray[0].ToString());}
//						catch
//						{Ultima_Fecha = DateTime.Now;}
              if($creditos){
                $Ultima_Fecha = strtotime($creditos->getFechaOperacion());
              }else{
                $Ultima_Fecha = strtotime(date('Y-m-d'));
              }

              $now = strtotime(date('Y-m-d'));
              $Actual = $now - $Ultima_Fecha; 
              $Actual = $Actual / (60 * 60 * 24); 

  						if (true)
  						{

                if(count($this->experiencias)>0){
                  $limit_mem='2048M';
                  ini_set("memory_limit",$limit_mem);
                  foreach($this->experiencias as $Reg){

    								if (substr($Reg->getCedula(), 0,1)=="J")
    								{
    									$ID_CLIENTE_PERSONA = $this->VerificarJuridica($Reg,$this->cliente_id);
    								}
    								else
    								{
    									$ID_CLIENTE_PERSONA = $this->VerificarNatural($Reg,$this->cliente_id);
    								}
                    
    								if ($ID_CLIENTE_PERSONA!=-1)
    								{
    									if (!$this->RevisarRegistro($Reg,$ID_CLIENTE_PERSONA))
    									{$Conta++;}
    								}
							    }
            	  }
  							$this->ActualizarCliente(count($this->experiencias) - $Conta,$this->cliente_id);
  							return $Conta;
      				}
      				else 
      				{
        				H::EscribirLog("El cliente ".$this->cliente_id." ya fue procesado para este mes. ".date('d/m/Y'));
                $this->error = "El cliente ".$this->cliente_id." ya fue procesado para este mes. ".date('d/m/Y');
      	  			return -1;
      		  	}
        
    }else{
			// El Cliente no existe, no se procesan los datos
			H::EscribirLog("Error al procesar el codigo ".$this->cliente_id." a las ".date('d/m/Y'));
      $this->error = "Error al procesar el codigo ".$this->cliente_id." a las ".date('d/m/Y');
			return -1;
		}

    
    return 0;
  }

  private function VerificarJuridica($R,$codcli)
  {
    $c = new Criteria();
    $c->add(PersonasJuridicasPeer::RIF,$R->getCedula());
    $persona = PersonasJuridicasPeer::doSelectOne($c);
    
    if($persona){
      $c->add(ClientesPersonasPeer::ID_PERSONA,$R->getCedula());
      $c->add(ClientesPersonasPeer::ID_CLIENTE,$codcli);
      $clientespersonas = ClientesPersonasPeer::doSelectOne($c);
      if($clientespersonas) return $clientespersonas->getIdClientePersona();
      else{
        $clientes_personas = new ClientesPersonas();
        $clientes_personas->setIdPersona($R->getCedula());
        $clientes_personas->setIdCliente($codcli);
        $clientes_personas->save();
        
        return $clientes_personas->getIdClientePersona();
      }
    }else{
      $personas_juridicas = new PersonasJuridicas();
      $personas_juridicas->setRif($R->getCedula());
      $personas_juridicas->setNombre($R->getNombre());
      $personas_juridicas->setTelefono($R->getTelefono());

      $personas_juridicas->save();

      $clientes_personas = new ClientesPersonas();
      $clientes_personas->setIdPersona($R->getCedula());
      $clientes_personas->setIdCliente($codcli);

      $clientes_personas->save();
      
      return $clientes_personas->getIdClientePersona();

    }
    
  }

  private function VerificarNatural($R,$codcli)
  {
    $c = new Criteria();
    $c->add(PersonasNaturalesPeer::CEDULA,$R->getCedula());
    $persona = PersonasNaturalesPeer::doSelectOne($c);
    
    if($persona){
      $c = new Criteria();
      $c->add(ClientesPersonasPeer::ID_PERSONA,$R->getCedula());
      $c->add(ClientesPersonasPeer::ID_CLIENTE,$codcli);
      $clientespersonas = ClientesPersonasPeer::doSelectOne($c);
            
      if($clientespersonas) return $clientespersonas->getIdClientePersona();
      else{
        $clientes_personas = new ClientesPersonas();
        $clientes_personas->setIdPersona($R->getCedula());
        $clientes_personas->setIdCliente($codcli);
        $clientes_personas->save();
        
        return $clientes_personas->getIdClientePersona();
      }
    }else{
      $personas_naturales = new PersonasNaturales();
      $personas_naturales->setCedula($R->getCedula());
      $personas_naturales->setNombre($R->getNombre());
      $personas_naturales->setApellido($R->getApellido());
      $personas_naturales->setTelefono($R->getTelefono());

      $personas_naturales->save();

      $clientes_personas = new ClientesPersonas();
      $clientes_personas->setIdPersona($R->getCedula());
      $clientes_personas->setIdCliente($codcli);

      $clientes_personas->save();
      
      return $clientes_personas->getIdClientePersona();

    }
    
  }


  private function ActualizarCliente($Cantidad, $Cliente)
  {
    $log = array();
    try{
      $c = new Criteria();
      $c->add(ClientesConfPeer::ID_CLIENTE,$Cliente);
      $clientesconf = ClientesConfPeer::doSelectOne($c);

      $log['id_cliente'] = $Cliente;

      if($clientesconf){
        $clientesconf->getSuma($clientesconf->getSuma() + $Cantidad);
        
        $clientesconf->save();
        
        $sql = "SELECT clientes.NOMBRE AS cliente, casas_comerciales.NOMBRE AS casacomercial ".
  						" FROM clientes LEFT JOIN casas_comerciales ON (clientes.ID_CASA_COMERCIAL = casas_comerciales.ID_CASA_COMERCIAL) ".
  						" WHERE clientes.ID_Cliente=".Cliente;
        
        if(H::BuscarDatos($sql,$reg)){
          $NombreCliente=$reg[0]['clientes'].' - '.$reg[0]['casacomercial'];
        }else $NombreCliente='Cliente Desconocido - Casa Comercial Desconocida';
        
        $NombreCliente = str_pad($NombreCliente, 36,' ',STR_PAD_RIGHT);
        $log['cliente'] = $NombreCliente;

        
        H::EscribirLog($Cantidad."		".$Cliente."		".$NombreCliente."	".date('d/m/Y'));
        $this->error = $Cantidad."		".$Cliente."		".$NombreCliente."	".date('d/m/Y');
        $log['cantidad'] = $Cantidad;
        $log['fecha'] = date('d/m/Y');
      }else{
        H::EscribirLog($Cantidad."		".$Cliente."		"."No esta registrada como un cliente. ".str_pad('',36," ",STR_PAD_RIGHT)."	".date('d/m/Y'));
        $this->error = $Cantidad."		".$Cliente."		"."No esta registrada como un cliente. ".str_pad('',36," ",STR_PAD_RIGHT)."	".date('d/m/Y');
        $log['cantidad'] = $Cantidad;
        $log['fecha'] = date('d/m/Y');      
      }
      $this->addImportarLog($log);
      return true;
    }catch(Exception $ex){
      return false;
    }
  }

  private function RevisarRegistro($R, $ID_CLI_PER)
  {
    try{
      $c = new Criteria();
      $c->add(CreditosPeer::ID_CLIENTE_PERSONA,$ID_CLI_PER);
      $c->add(CreditosPeer::FACTURA,$R->getFactura());
      $c->add(CreditosPeer::FECHA_COMPRA,$R->getFechaCompra());
      $creditos = CreditosPeer::doSelectOne($c);
      
    	if ($R->getFechaCancelacion()==date('Y-m-d',strtotime('2001-01-01')) || date('Y',strtotime($R->getFechaCancelacion())) < 2002 ) $Estado=0;
  	  else $Estado=1;
      
      if($creditos){
  
        $creditos->setMonto($R->getMonto());
        $creditos->setPagoMes($R->getPagoMes());
        $creditos->setFechaCompra($R->getFechaCompra());
        $creditos->setNumGiros($R->getNumeroGiros());
        $creditos->setEstado($Estado);
        if($Estado==0){
          // Existe pero NO esta cancelado
          $creditos->setFechaOperacion(date('Y-m-d'));
        }else{
          // Existe y esta cancelado
          $creditos->setFechaOperacion($R->getFechaCancelacion());
        }
  
        if($R->getExperiencia()>$creditos->getExperiencia()){
          $creditos->setExperiencia($R->getExperiencia());
        }
        
        $creditos->save();
      }else{
        
        $creditos = new Creditos();
  
        $creditos->setIdClientePersona($ID_CLI_PER);
        $creditos->setFactura($R->getFactura());
        $creditos->setFechaCompra($R->getFechaCompra());
        $creditos->setMonto($R->getMonto());
        $creditos->setPagoMes($R->getPagoMes());
        $creditos->setNumGiros($R->getNumeroGiros());
        if($Estado==0){
          // Existe pero NO esta cancelado
          $creditos->setFechaOperacion(date('Y-m-d'));
        }else{
          // Existe y esta cancelado
          $creditos->setFechaOperacion($R->getFechaCancelacion());
        }
        $creditos->setExperiencia($R->getExperiencia());
        
        $creditos->save();
      }
      return true;
    }catch(Exception $ex){
      return false;
    }

  }

  private function loadDatosArchivos()
  {
    $this->metadata = file($this->archivo);
    if(count($this->metadata)>0) return true;
    else return false;
  }

  public function getExperiencias()
  {
    return $this->experiencias;
  }

  private function save()
  {
    // Guardar en la base de datos
    return true;
  }
  
  private function ConvertirCreditum()
  {
    //print_r($this->metadata);
    if(count($this->metadata)>0){
      foreach($this->metadata as $meta){
        $trama = $meta;
        $tokents = explode("\t", $trama);
        //print_r($tokents);
        if(count($tokents)>4){
          $exp = new Experiencia();
          $exp->setMetadata($meta);
          $exp->Hidratar($tokents);
          $this->experiencias[] = $exp;
        }
      }
    }
    return count($this->experiencias);
  }
  
  private function ConvertirCreditumCliente()
  {
    $xml = implode($this->metadata);

    $crxml = simplexml_load_string($xml);

    if(count($crxml->CREDITOS)>0){
      foreach($crxml->CREDITOS as $meta){

        // print '<pre>';print_r(json_encode($meta));exit;
        // [ID_CLIENTE] => 1265247
        // [NOMBRE] => Raul Jose 
        // [APELLIDO] => Abarca Arrieta 
        // [FACTURA] => 3793
        // [FECHA_COMPRA] => 2001-07-23T00:00:00.0000000-04:30
        // [MONTO] => 513.88
        // [PAGO_MES] => 102.78
        // [NUM_GIROS] => 5
        // [FECHA_CANCELACION] => 2002-01-14T00:00:00.0000000-04:30
        // [EXPERIENCIA] => 3

        $tokents = array(
            $meta->ID_CLIENTE, 
            $meta->NOMBRE, 
            $meta->APELLIDO, 
            '', '', '', 
            $meta->FACTURA, 
            date('d/m/Y',strtotime($meta->FECHA_COMPRA)), 
            $meta->MONTO, 
            $meta->PAGO_MES, 
            $meta->NUM_GIROS, 
            date('d/m/Y',strtotime($meta->FECHA_CANCELACION)), 
            $meta->EXPERIENCIA
            );
        if(count($tokents)>4){
          $exp = new Experiencia();
          $exp->setMetadata(json_encode($meta));
          $exp->Hidratar($tokents);
          $this->experiencias[] = $exp;
        }
      }
    }
    return count($this->experiencias);
  }

  private function ConvertirLaRana()
  {
    return 0;
  }
  
  public function Registros()
  {
    return count($this->metadata);
  }
  
  public function setClienteId($value)
  {
    $this->cliente_id = $value;
  }
  
  public function getClienteId()
  {
    return $this->cliente_id;
  }
    
  public function getError()
  {
    return $this->error;
  }

  public function addImportarLog($arr)
  {
    $filename = 'import_log.yml';

    if (is_writable($filename)) {

        if (!$handle = fopen($filename, 'a')) {
             echo "Cannot open file ($filename)";
             exit;
        }

        if (fwrite($handle, '  '.date('dmyHi').":\n") === FALSE) {
            echo "Cannot write to file ($filename)";
            exit;
        }

        foreach ($arr as $key => $info){
          if (fwrite($handle, '    '.$key.': '.$info."\n") === FALSE) {
              echo "Cannot write to file ($filename)";
              exit;
          }          
        }

        fclose($handle);

    } else {
        echo "The file $filename is not writable";
    }

  }

}
?>