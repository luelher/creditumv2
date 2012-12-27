<?php

/**
 * PersonasJuridicas form base class.
 *
 * @method PersonasJuridicas getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePersonasJuridicasForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'RIF'       => new sfWidgetFormInputHidden(),
      'NIT'       => new sfWidgetFormInputText(),
      'NOMBRE'    => new sfWidgetFormInputText(),
      'TELEFONO'  => new sfWidgetFormInputText(),
      'DIRECCION' => new sfWidgetFormInputText(),
      'FAX'       => new sfWidgetFormInputText(),
      'EMAIL'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'RIF'       => new sfValidatorChoice(array('choices' => array($this->getObject()->getRif()), 'empty_value' => $this->getObject()->getRif(), 'required' => false)),
      'NIT'       => new sfValidatorString(array('max_length' => 10)),
      'NOMBRE'    => new sfValidatorString(array('max_length' => 30)),
      'TELEFONO'  => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'DIRECCION' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'FAX'       => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'EMAIL'     => new sfValidatorString(array('max_length' => 30, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('personas_juridicas[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PersonasJuridicas';
  }


}
