<?php

class indexComponents extends sfComponents
{
  public function executeMenu()
  {
    // TODO: Cargar esta data de la base de datos para cada tipo de usuario
    $this->menu = array('Importar' => array('importar','index'), 'Opción 2' => array('modulo','accion'), 'Opción 3' => array('modulo','accion'));

  }

  public function executeInfo()
  {

  }

  public function executePrincipal()
  {

  }

}
?>