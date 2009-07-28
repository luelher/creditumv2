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
    $this->obj = Herramientas::getConfigGrid('grid_importar',$reg);


    if ($request->isMethod('post'))
      $this->formulario->bind($request->getParameter('importar'), $request->getFiles('importar'));

  }
  
  public function executePrueba()
  {    
  }

  public function executeImportar(sfWebRequest $request)
  {
    $this->formulario = new FormImportar();

    $reg = array(new Creditos(),new Creditos(), new Creditos());
    $this->obj = Herramientas::getConfigGrid('grid_importar',$reg);


    if ($request->isMethod('post'))
    {
      $this->formulario->bind($request->getParameter('importar'), $request->getFiles('importar'));

      if ($this->formulario->isValid())
      {
        $this->archivo = $this->formulario->getValue('archivo');
        $this->tipo = $this->formulario->getValue('tipo');

        $archivo = $this->archivo->getTempName();

        $importar = new Importar();
        $importar->setArchivo($archivo);

        if($importar->Cargar()){
          $this->data = $importar->getData();
        }else $this->data = array();

        if(count($this->data)>0){
          $importar->getData();
        }

      }else {
        $this->forward('importar', 'index');
      }
    }else{
    }





  }
}
