<?php

/**
 * CasasComerciales form base class.
 *
 * @method CasasComerciales getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseCasasComercialesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ID_CASA_COMERCIAL' => new sfWidgetFormInputHidden(),
      'NOMBRE'            => new sfWidgetFormInputText(),
      'RIF'               => new sfWidgetFormInputText(),
      'NIT'               => new sfWidgetFormInputText(),
      'UBICACION'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'ID_CASA_COMERCIAL' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdCasaComercial()), 'empty_value' => $this->getObject()->getIdCasaComercial(), 'required' => false)),
      'NOMBRE'            => new sfValidatorString(array('max_length' => 60)),
      'RIF'               => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'NIT'               => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'UBICACION'         => new sfValidatorString(array('max_length' => 100, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('casas_comerciales[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CasasComerciales';
  }


}
