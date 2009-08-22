<?php

class Importar {

  const CREDITUM = 0;
  const LARANA = 1;


  protected $archivo='';
  private $data=array();
  private $metadata=array();
  private $experiencias=array();
  private $cliente_id=0;

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
        case Importar::LARANA:
          return $this->ConvertirLaRana();
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
    
    H::PrintR($cliente);print '---';

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
              
              H::PrintR($creditos);

//
//						try
//						{Ultima_Fecha = Convert.ToDateTime(DT.Rows[0].ItemArray[0].ToString());}
//						catch
//						{Ultima_Fecha = DateTime.Now;}
              if($creditos){
                $Ultima_Fecha = new DateTime($creditos->getFechaOperacion());
              }else{
                $Ultima_Fecha = new DateTime();
              }

              
//						
//						TimeSpan Actual = DateTime.Now.Subtract(Ultima_Fecha);
              $now = new DateTime();
              var_dump($Ultima_Fecha);
              $Actual = $now->diff($Ultima_Fecha); 
              
              print_r($Actual) ;exit();
              
//
  						if ($Actual.days >= 0)
  						{

//							// Se analizan todos los registros obtenidos
//							Registro Reg;
//							int ID_CLIENTE_PERSONA;

//							for (int i=0;i<Datos.Tables["CREDITOS"].Rows.Count;i++)
//							{

                if(count($this->experiencias)>0){
                  foreach($this->experiencias as $Reg){

    								if (substr($Reg->getCedula(), 0,1)=="J")
    								{
    									$ID_CLIENTE_PERSONA = VerificarJuridica(Reg,$this->cliente_id);
    								}
    								else
    								{
    									$ID_CLIENTE_PERSONA = VerificarNatural(Reg,$this->cliente_id);
    								}
    								if ($ID_CLIENTE_PERSONA!=-1)
    								{
    									if (!RevisarRegistro($Reg,$ID_CLIENTE_PERSONA))
    									{$Conta++;}
    								}
							    }
            	  }
  							ActualizarCliente(count($this->experiencias) - Conta,$this->cliente_id);
  							return $Conta;
      				}
      				else 
      				{
        				H::EscribirLog("El cliente " + $this->cliente_id + " ya fue procesado para este mes. " + date('d/m/Y'));
      	  			return -1;
      		  	}
        
    }else{
			// El Cliente no existe, no se procesan los datos
			H::EscribirLog("Error al procesar el codigo " + Codigo.ToString() + " a las " + date('d/m/Y'));
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
    $c->add(PersonasNaturalesPeer::RIF,$R->getCedula());
    $persona = PersonasNaturalesPeer::doSelectOne($c);
    
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
    try{
      $c = new Criteria();
      $c->add(ClientesConfPeer::ID_CLIENTE,$Cliente);
      $clientesconf = ClientesConfPeer::doSelectOne($c);
      if($clientesconf){
        $clientesconf->getSuma($clientesconf->getSuma() + $Cantidad);
        $clientesconf->save();
        
        $sql = "SELECT clientes.NOMBRE AS cliente, casas_comerciales.NOMBRE AS casacomercial ".
  						" FROM clientes LEFT JOIN casas_comerciales ON (clientes.ID_CASA_COMERCIAL = casas_comerciales.ID_CASA_COMERCIAL) ".
  						" WHERE clientes.ID_Cliente=".Cliente;
        
        if(H::BuscarDatos($sql,&$reg)){
          $NombreCliente=$reg[0]['clientes'].' - '.$reg[0]['casacomercial'];
        }else $NombreCliente='Cliente Desconocido - Casa Comercial Desconocida';
        
        $NombreCliente = str_pad($NombreCliente, 36,' ',STR_PAD_RIGHT);
        
        H::EscribirLog(Cantidad."		".Cliente."		".NombreCliente."	".date('d/m/Y'));
      }else{
        H::EscribirLog(Cantidad."		".Cliente."		"."No esta registrada como un cliente. ".str_pad('',36," ",STR_PAD_RIGHT)."	".date('d/m/Y'));
      }
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
      
    	if ($R.getFechaCancelacion()==date('d/m/Y',0)) $Estado=0;
  	  else $Estado=1;
      
      if($creditos){
  
        $creditos->setMonto($R->getMonto());
        $creditos->setPagoMes($R->getPagoMes());
        $creditos->setNumGiros($R->getNumeroGiros());
        $creditos->setEstado($Estado);
        if($Estado==0){
          // Existe pero NO esta cancelado
          $creditos->setFechaOperacion(date(Y-m-d));
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
          $creditos->setFechaOperacion(date(Y-m-d));
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
        $tokents = split("\t", $trama);
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
    

}
?>