<?php

/**
 * ClientesConf form base class.
 *
 * @method ClientesConf getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseClientesConfForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ID_CLIENTE' => new sfWidgetFormInputHidden(),
      'DESCUENTO'  => new sfWidgetFormInputText(),
      'CONSULTAS'  => new sfWidgetFormInputText(),
      'APORTES'    => new sfWidgetFormInputText(),
      'FECHA_INI'  => new sfWidgetFormDate(),
      'STATUS'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'ID_CLIENTE' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdCliente()), 'empty_value' => $this->getObject()->getIdCliente(), 'required' => false)),
      'DESCUENTO'  => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'CONSULTAS'  => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'APORTES'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'FECHA_INI'  => new sfValidatorDate(),
      'STATUS'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
    ));

    $this->widgetSchema->setNameFormat('clientes_conf[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ClientesConf';
  }


}
