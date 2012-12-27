<?php

/**
 * ClientesPersonas form base class.
 *
 * @method ClientesPersonas getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseClientesPersonasForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ID_PERSONA'         => new sfWidgetFormInputText(),
      'ID_CLIENTE_PERSONA' => new sfWidgetFormInputHidden(),
      'ID_CLIENTE'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'ID_PERSONA'         => new sfValidatorString(array('max_length' => 15)),
      'ID_CLIENTE_PERSONA' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdClientePersona()), 'empty_value' => $this->getObject()->getIdClientePersona(), 'required' => false)),
      'ID_CLIENTE'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
    ));

    $this->widgetSchema->setNameFormat('clientes_personas[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ClientesPersonas';
  }


}
