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

		if ($cliente)
		{

    
      if(count($this->experiencias)>0){
        foreach($this->experiencias as $exp){
        
//					// El cliente existe
//						sql= "SELECT MAX(creditos.FECHA_OPERACION)" +
//							" FROM clientes_personas" +
//							" INNER JOIN creditos ON (clientes_personas.ID_CLIENTE_PERSONA = creditos.ID_CLIENTE_PERSONA)" +
//							" WHERE clientes_personas.ID_CLIENTE = " + Codigo.ToString() +
//							" GROUP BY clientes_personas.ID_CLIENTE;";
//						BD.EjecutarQuery(CONN,OleConexion,sql,out DT);
//
//						try
//						{Ultima_Fecha = Convert.ToDateTime(DT.Rows[0].ItemArray[0].ToString());}
//						catch
//						{Ultima_Fecha = DateTime.Now;}
//						
//						TimeSpan Actual = DateTime.Now.Subtract(Ultima_Fecha);
//
//						if (Actual.Days >= 0)
//						{
//							// Se analizan todos los registros obtenidos
//							Registro Reg;
//							int ID_CLIENTE_PERSONA;
//							for (int i=0;i<Datos.Tables["CREDITOS"].Rows.Count;i++)
//							{
//								Reg = new Registro(Datos.Tables["CREDITOS"].Rows[i]);
//								if (Reg.ID_CLIENTE.ToUpper().Substring(0,1)=="J")
//								{
//									ID_CLIENTE_PERSONA = VerificarJuridica(Reg);
//								}
//								else
//								{
//									ID_CLIENTE_PERSONA = VerificarNatural(Reg);
//								}
//								if (ID_CLIENTE_PERSONA!=-1)
//								{
//									if (!RevisarRegistro(Reg,ID_CLIENTE_PERSONA))
//									{Conta++;}
//								}
//							}
//							ActualizarCliente(Datos.Tables["CREDITOS"].Rows.Count - Conta,Codigo);
//							OleConexion.Close();
//							return Conta;
//						}
//						else 
//						{
//							EscribirLog("El cliente " + Codigo.ToString() + " ya fue procesado para este mes. " + DateTime.Now.Date.ToString());
//							return -1;
//						}
  			}
        
      }
        
    }else{
			// El Cliente no existe, no se procesan los datos
			H::EscribirLog("Error al procesar el codigo " + Codigo.ToString() + " a las " + DateTime.Now.Date.ToString());
			return -1;
		}

    
    return 0;
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
        $exp = new Experiencia();
        $exp->setMetadata($meta);
        $exp->Hidratar($tokents);
        $this->experiencias[] = $exp;
      }
    }
    return count($this->$experiencias);
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