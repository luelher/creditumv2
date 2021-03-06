<?php

/**
 * importar actions.
 *
 * @package    sf_sandbox
 * @subpackage importar
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class importarActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {

    $this->formulario = new FormImportar();
    $reg = array();
    //$this->obj = Herramientas::getGridConfig('grid_importar',$reg);


    if ($request->isMethod('post'))
      $this->formulario->bind($request->getParameter('importar'), $request->getFiles('importar'));

  }
  
  public function executeImportar(sfWebRequest $request)
  {
    $this->formulario = new FormImportar();

    if ($request->isMethod('post'))
    {
      $this->formulario->bind($request->getParameter('importar'), $request->getFiles('importar'));

      if ($this->formulario->isValid())
      {
        $this->archivo = $this->formulario->getValue('archivo');
        $this->tipo = $this->formulario->getValue('tipo');
        $this->cliente = $this->formulario->getValue('cliente');

        $archivo = $this->archivo->getTempName();

        $importar = new Importar();
        $importar->setArchivo($archivo);
        $importar->setClienteId($this->cliente);

        $importar->Cargar();
        
        $this->data = $importar->Registros();
        
        $this->convertido = $importar->Convertir($this->tipo);

        $this->result = $importar->Procesar();
        $this->error = $importar->getError();

      }else {
        $this->forward('importar', 'index');
      }
    }else{
    }
  
  }
  
  
}
