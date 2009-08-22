<?php

class FormImportar extends sfForm {

    protected $tipos = array('Generica de Creditum');
    
    protected $clientes = array(44 => 'LA RANA CA. PRINCIPAL');

    public function configure(){
      $this->setWidgets(array(
        'cliente'    => new sfWidgetFormSelect(array('choices' => $this->clientes)),
        'tipo'    => new sfWidgetFormSelect(array('choices' => $this->tipos)),
        'archivo'    => new sfWidgetFormInputFile(),
      ));
      $this->widgetSchema->setFormFormatterName('list');

      $this->widgetSchema->setNameFormat('importar[%s]');

      $this->setValidators(array(
        'archivo' => new sfValidatorFile(array('required'=>'true')),
        'tipo' => new sfValidatorString(array('required'=>'true')),
        'cliente' => new sfValidatorString(array('required'=>'true')),
      ));


    }
}
?>
