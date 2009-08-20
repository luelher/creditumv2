<?php

class Importar {

  const CREDITUM = 0;
  const LARANA = 1;


  protected $archivo='';
  private $data=array();
  private $metadata=array();
  private $experiencias=array();

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
    if(count($this->experiencias)>0){
      foreach($this->experiencias as $exp){
        
      }
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

}
?>