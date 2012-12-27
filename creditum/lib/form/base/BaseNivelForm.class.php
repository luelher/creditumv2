<?php

/**
 * Nivel form base class.
 *
 * @method Nivel getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseNivelForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ID_NIVEL'    => new sfWidgetFormInputHidden(),
      'DESCRIPCION' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'ID_NIVEL'    => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdNivel()), 'empty_value' => $this->getObject()->getIdNivel(), 'required' => false)),
      'DESCRIPCION' => new sfValidatorString(array('max_length' => 50)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Nivel', 'column' => array('ID_NIVEL')))
    );

    $this->widgetSchema->setNameFormat('nivel[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Nivel';
  }


}
