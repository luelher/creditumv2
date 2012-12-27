<?php

/**
 * Usuarios form base class.
 *
 * @method Usuarios getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseUsuariosForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'CEDULA'       => new sfWidgetFormInputText(),
      'ID_CLIENTE'   => new sfWidgetFormInputText(),
      'PWD'          => new sfWidgetFormInputText(),
      'NOMBRE'       => new sfWidgetFormInputText(),
      'APELLIDO'     => new sfWidgetFormInputText(),
      'TELEFONO'     => new sfWidgetFormInputText(),
      'CELULAR'      => new sfWidgetFormInputText(),
      'NACIONALIDAD' => new sfWidgetFormInputText(),
      'ID_NIVEL'     => new sfWidgetFormInputText(),
      'FECHA'        => new sfWidgetFormDate(),
      'id'           => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'CEDULA'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'ID_CLIENTE'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'PWD'          => new sfValidatorString(array('max_length' => 50)),
      'NOMBRE'       => new sfValidatorString(array('max_length' => 20)),
      'APELLIDO'     => new sfValidatorString(array('max_length' => 20)),
      'TELEFONO'     => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'CELULAR'      => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'NACIONALIDAD' => new sfValidatorString(array('required' => false)),
      'ID_NIVEL'     => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'FECHA'        => new sfValidatorDate(array('required' => false)),
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuarios[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Usuarios';
  }


}
