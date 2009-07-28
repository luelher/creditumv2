<?php

/**
 * WidgetForm para crear un grid de datos con lsa librerias ext.
 *
 * @package    symfony
 * @subpackage widget
 * @author     Luis Eloy Hernández Torrealba <luelher@gmail.com>
 * @version    SVN: $Id: $
 *
 */


class sfWidgetFormExtEditorGridPanel extends sfWidgetForm
{
  public $colums = array();
  private $eliminar = true;
  private $titulo = 'Título';
  private $name = 'a';
  private $ancho = 1000;
  private $filas = 10;
  private $htmltotalfilas = '';
  private $tabla ='';
  private $jseliminar ='';

  
  /**
   * Constructor.
   *
   * Available options:
   *
   *  * type: The widget type (text by default)
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->setOption('is_hidden', false);
    
  }

  /**
   * @param  string $name        The element name
   * @param  string $value       The value displayed in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    return $this->renderGrid();
  }

  /**
   * Crea una nueva columna dentro del objeto de opciones
   * Esta columna contiene los datos de configuracion
   * Cada columna nueva contiene informacion predeterminada
   *
   * @param $name Titulo de la nueva columna
   * @return bool
   */
  public function newColumn($name='')
  {
      $this->colums[] = new Column($obj);

  }

  /**
   * Crea una nueva columna dentro del objeto de opciones
   * Esta columna contiene los datos de configuracion
   * Cada columna nueva contiene informacion predeterminada
   *
   * @param $obj Objeto Columna
   * @return bool
   */
  public function addColumn($obj)
  {
    if($obj instanceof Column){
      $this->colums[] = $obj;
    }
  }

  /**
   * Establece si se coloca el icono de eliminar en cada fila
   *
   * @param $val (bool) true/false
   * @param $function (string) nombre de la función a ajecutar en cada botón eliminar
   * @return bool
   */
  public function setDeleteRow($val, $jsdelete = ''){

    if(is_bool($val)){
      $this->delete = $val;
    }
    $this->jsdelete = $jsdelete;

  }

  /**
   * Establece el título del Grid
   *
   * @param $val (string) Título del Grid
   * @return bool
   */
  public function setTitle($val){
    $this->title = $val;
  }

/**
   * Establece el prefijo de las cajas de textos
   *
   * @param $val (string) prefijo de las cajas de textos
   * @return bool
   */
  public function setGridId($val){
    $this->gridId = $val;
  }

  /**
   * Establece el Nro de filas adicionales para insertar
   * nuevos datos en el grid. Por defecto 15
   *
   * @param $val (int) Cantidad de fila nuevas
   * @return bool
   */
  public function setDefaultRows($val){

    $this->defaultRows=$val;

  }

  /**
   * Establece la tabla de la cual se traen los datos del grid
   *
   * @param $val (string) Nombre de la Tabla/Clase
   * @return bool
   */
  public function setDataClass($val){

    $this->dataClass = ucfirst(strtolower($val));

  }

  /**
   * Estable el ancho total del Grid
   *
   * @param $val (string) Nombre de la Tabla/Clase
   * @return bool
   */
  public function setWidth($val){

    $this->width = (int)$val;

  }

  private function rendergrid()
  {
    
  }

}

?>