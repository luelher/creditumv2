<?php

/**
 * Facturas form base class.
 *
 * @method Facturas getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseFacturasForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ID_FACTURA'     => new sfWidgetFormInputHidden(),
      'ID_CLIENTE'     => new sfWidgetFormInputText(),
      'FECHA_DESDE'    => new sfWidgetFormDate(),
      'FECHA_HASTA'    => new sfWidgetFormDate(),
      'PRECIO_OK'      => new sfWidgetFormInputText(),
      'PRECIO_FALLIDA' => new sfWidgetFormInputText(),
      'VALIDAS'        => new sfWidgetFormInputText(),
      'TOTALV'         => new sfWidgetFormInputText(),
      'FALLIDAS'       => new sfWidgetFormInputText(),
      'TOTALF'         => new sfWidgetFormInputText(),
      'DESCUENTO'      => new sfWidgetFormInputText(),
      'TOTALD'         => new sfWidgetFormInputText(),
      'TOTAL'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'ID_FACTURA'     => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdFactura()), 'empty_value' => $this->getObject()->getIdFactura(), 'required' => false)),
      'ID_CLIENTE'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'FECHA_DESDE'    => new sfValidatorDate(),
      'FECHA_HASTA'    => new sfValidatorDate(),
      'PRECIO_OK'      => new sfValidatorNumber(),
      'PRECIO_FALLIDA' => new sfValidatorNumber(),
      'VALIDAS'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'TOTALV'         => new sfValidatorNumber(),
      'FALLIDAS'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'TOTALF'         => new sfValidatorNumber(),
      'DESCUENTO'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'TOTALD'         => new sfValidatorNumber(),
      'TOTAL'          => new sfValidatorNumber(),
    ));

    $this->widgetSchema->setNameFormat('facturas[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Facturas';
  }


}
