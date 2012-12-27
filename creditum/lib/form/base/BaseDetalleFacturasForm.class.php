<?php

/**
 * DetalleFacturas form base class.
 *
 * @method DetalleFacturas getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseDetalleFacturasForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ID_FACTURA'     => new sfWidgetFormInputText(),
      'CEDULA_USUARIO' => new sfWidgetFormInputText(),
      'ID_PERSONA'     => new sfWidgetFormInputText(),
      'FECHA_HORA'     => new sfWidgetFormDateTime(),
      'STATUS'         => new sfWidgetFormInputText(),
      'id'             => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'ID_FACTURA'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'CEDULA_USUARIO' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'ID_PERSONA'     => new sfValidatorString(array('max_length' => 15)),
      'FECHA_HORA'     => new sfValidatorDateTime(),
      'STATUS'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('detalle_facturas[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'DetalleFacturas';
  }


}
