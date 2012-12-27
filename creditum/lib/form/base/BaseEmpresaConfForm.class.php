<?php

/**
 * EmpresaConf form base class.
 *
 * @method EmpresaConf getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseEmpresaConfForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ID_CLIENTE'     => new sfWidgetFormInputText(),
      'WEB'            => new sfWidgetFormInputText(),
      'PRECIO_OK1'     => new sfWidgetFormInputText(),
      'PRECIO_OK2'     => new sfWidgetFormInputText(),
      'PRECIO_OK3'     => new sfWidgetFormInputText(),
      'PRECIO_OK4'     => new sfWidgetFormInputText(),
      'PRECIO_FALLIDA' => new sfWidgetFormInputText(),
      'id'             => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'ID_CLIENTE'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'WEB'            => new sfValidatorString(array('max_length' => 50)),
      'PRECIO_OK1'     => new sfValidatorNumber(),
      'PRECIO_OK2'     => new sfValidatorNumber(),
      'PRECIO_OK3'     => new sfValidatorNumber(),
      'PRECIO_OK4'     => new sfValidatorNumber(),
      'PRECIO_FALLIDA' => new sfValidatorNumber(),
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('empresa_conf[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EmpresaConf';
  }


}
