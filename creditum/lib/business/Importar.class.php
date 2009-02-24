<?php

class Importar {

  const CREDITUM = 0;
  const LARANA = 1;


  protected $archivo='';
  private $data=array();
  private $metadata=array();

  function Importar($archivo='') {
    $this->archivo = $archivo;
  }

  function getArchivo()
  {return $this->archivo;}

  function setArchivo($val)
  {$this->archivo = $val;}

  function Cargar($archivo='')
  {
    if($archivo!='') $this->setArchivo($archivo);

    return $this->loadDatosArchivos();

  }

  function Convertir($tipo=Importar::CREDITUM)
  {
    if(count($this->data)){
      switch($tipo){
        case Importar::CREDITUM:
          $this->ConvertirCreditum();
        case Importar::LARANA:
          $this->ConvertirLaRana();
      }
      $this->save();
    }else return true;
  }

  private function loadDatosArchivos()
  {
    $this->data = file($this->archivo);
    if(count($this->data)>0) return true;
    else return false;
  }

  public function getData()
  {
    return $this->data;
  }

  private function save()
  {
    return true;
  }

}
?>