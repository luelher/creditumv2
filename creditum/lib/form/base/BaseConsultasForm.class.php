<?php

/**
 * Consultas form base class.
 *
 * @method Consultas getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseConsultasForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'CEDULA_USUARIO' => new sfWidgetFormInputText(),
      'ID_CLIENTE'     => new sfWidgetFormInputText(),
      'ID_PERSONA'     => new sfWidgetFormInputText(),
      'FECHA_HORA'     => new sfWidgetFormDateTime(),
      'id'             => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'CEDULA_USUARIO' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'ID_CLIENTE'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'ID_PERSONA'     => new sfValidatorString(array('max_length' => 15)),
      'FECHA_HORA'     => new sfValidatorDateTime(),
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('consultas[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Consultas';
  }


}
