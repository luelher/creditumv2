<?php

/**
 * Clientes form base class.
 *
 * @method Clientes getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseClientesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ID_CLIENTE'        => new sfWidgetFormInputHidden(),
      'ID_CASA_COMERCIAL' => new sfWidgetFormInputText(),
      'NOMBRE'            => new sfWidgetFormInputText(),
      'RIF'               => new sfWidgetFormInputText(),
      'NIT'               => new sfWidgetFormInputText(),
      'DIRECCION'         => new sfWidgetFormInputText(),
      'TELEFONO'          => new sfWidgetFormInputText(),
      'FAX'               => new sfWidgetFormInputText(),
      'CELULAR'           => new sfWidgetFormInputText(),
      'EMAIL'             => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'ID_CLIENTE'        => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdCliente()), 'empty_value' => $this->getObject()->getIdCliente(), 'required' => false)),
      'ID_CASA_COMERCIAL' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'NOMBRE'            => new sfValidatorString(array('max_length' => 30)),
      'RIF'               => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'NIT'               => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'DIRECCION'         => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'TELEFONO'          => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'FAX'               => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'CELULAR'           => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'EMAIL'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Clientes', 'column' => array('ID_CLIENTE')))
    );

    $this->widgetSchema->setNameFormat('clientes[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Clientes';
  }


}
