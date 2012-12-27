<?php

/**
 * Creditos form base class.
 *
 * @method Creditos getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseCreditosForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ID'                 => new sfWidgetFormInputHidden(),
      'ID_CLIENTE_PERSONA' => new sfWidgetFormInputText(),
      'FACTURA'            => new sfWidgetFormInputText(),
      'FECHA_COMPRA'       => new sfWidgetFormDate(),
      'FECHA_OPERACION'    => new sfWidgetFormDate(),
      'MONTO'              => new sfWidgetFormInputText(),
      'PAGO_MES'           => new sfWidgetFormInputText(),
      'NUM_GIROS'          => new sfWidgetFormInputText(),
      'EXPERIENCIA'        => new sfWidgetFormInputText(),
      'ESTADO'             => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'ID'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'ID_CLIENTE_PERSONA' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'FACTURA'            => new sfValidatorString(array('max_length' => 20)),
      'FECHA_COMPRA'       => new sfValidatorDate(),
      'FECHA_OPERACION'    => new sfValidatorDate(),
      'MONTO'              => new sfValidatorNumber(),
      'PAGO_MES'           => new sfValidatorNumber(),
      'NUM_GIROS'          => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'EXPERIENCIA'        => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'ESTADO'             => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Creditos', 'column' => array('ID')))
    );

    $this->widgetSchema->setNameFormat('creditos[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Creditos';
  }


}
