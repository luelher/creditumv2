<?php

/**
 * Direcciones form base class.
 *
 * @method Direcciones getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseDireccionesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ID_PERSONA' => new sfWidgetFormInputHidden(),
      'DIRECCION'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'ID_PERSONA' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdPersona()), 'empty_value' => $this->getObject()->getIdPersona(), 'required' => false)),
      'DIRECCION'  => new sfValidatorString(array('max_length' => 50)),
    ));

    $this->widgetSchema->setNameFormat('direcciones[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Direcciones';
  }


}
