<?php

/**
 * PersonasNaturales form base class.
 *
 * @method PersonasNaturales getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePersonasNaturalesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'CEDULA'       => new sfWidgetFormInputHidden(),
      'NOMBRE'       => new sfWidgetFormInputText(),
      'APELLIDO'     => new sfWidgetFormInputText(),
      'TELEFONO'     => new sfWidgetFormInputText(),
      'CELULAR'      => new sfWidgetFormInputText(),
      'PROFESION'    => new sfWidgetFormInputText(),
      'NACIONALIDAD' => new sfWidgetFormInputText(),
      'FECHA_NAC'    => new sfWidgetFormDate(),
      'SEXO'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'CEDULA'       => new sfValidatorChoice(array('choices' => array($this->getObject()->getCedula()), 'empty_value' => $this->getObject()->getCedula(), 'required' => false)),
      'NOMBRE'       => new sfValidatorString(array('max_length' => 30)),
      'APELLIDO'     => new sfValidatorString(array('max_length' => 30)),
      'TELEFONO'     => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'CELULAR'      => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'PROFESION'    => new sfValidatorString(array('max_length' => 16, 'required' => false)),
      'NACIONALIDAD' => new sfValidatorString(array('required' => false)),
      'FECHA_NAC'    => new sfValidatorDate(array('required' => false)),
      'SEXO'         => new sfValidatorString(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'PersonasNaturales', 'column' => array('CEDULA')))
    );

    $this->widgetSchema->setNameFormat('personas_naturales[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PersonasNaturales';
  }


}
