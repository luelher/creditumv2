<?php

class indexComponents extends sfComponents
{
  public function executeMenu()
  {
    // TODO: Cargar esta data de la base de datos para cada tipo de usuario
    $this->menu = array('principal' => array('principal','index'), '¿quienes somos?' => array('quienessomos','index'),'servicios' => array('servicios','index'),'contactos' => array('contactos','index'),'ayuda' => array('ayuda','index'), 'importar' => array('importar','index'));

  }

  public function executeInfo()
  {

  }

  public function executePrincipal()
  {

  }

}
?>