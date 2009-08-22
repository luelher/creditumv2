<?php

class FormImportar extends sfForm {

    protected $tipos = array('Generica de Creditum');

    protected $clientes = array(44 => 'LA RANA CA. PRINCIPAL', 173 => 'Agencia Royal 33 C.A.', 236 => 'Comercial San Jose', 249 => 'Josanca 19', 250 => 'Josanca 21', 4 => 'Josanca Acarigua' );

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
