<?php

/**
 * Clase para el manejo de las columnas del grid
 *
 * @package    symfony
 * @subpackage widget
 * @author     Luis Hernández <luelher@cidesa.com.ve>
 * @version    SVN: $Id: $
 *
 */
class GridColumn
{
  CONST CENTER = 'center';
  CONST LEFT = 'left';
  CONST RIGHT = 'right';

  CONST TEXT = 't';
  CONST FLOAT = 'm';
  CONST DECIMAL = 'd';  
  CONST DATE = 'f';
  CONST COMBO = 'c';
  CONST TEXTAREA = 'a';
  CONST CHECK = 'k';


  private $title='';
  private $field='';
  private $type='t';
  private $is_sum=false;
  private $obj_sum='';
  private $js='';
  private $save = false;
  private $width = 0;
  private $readonly = false;

  private $catalogform = '';          // catalogo
  private $catalogclass = '';         // catalogo
  private $catalogobj = '';           // catalogo
  private $catalogparam = array();    // catalogo
  private $catalogmethod = array();    // catalogo

  private $nomfor = '';                // Formulario para el ajax
  private $idfuncion = -1;             // Algo para el ajax
  private $objmostrar = -1;            // Objeto a reemplazar (div)
  private $objcompletar= '';           // Otro parametro para el ajax
  private $funcion = '';               // Otro parametro para el ajax
  
  private $emtpy = false;              // Vacío, sin valor por defecto
  private $hide = false;               // Columna oculta
  private $comboelements = array();    // Elementos del combo
  private $checkbox = false;           // Valor por defecto del checkbox
  private $button = false;             // Si contiene un boton para otra funcionalidad
  private $buttonfunction = '';        // funcion js del boton
  private $default = '';               // Valor por defecto
//  private $catalogometodo = '';
  private $ajaxrow = false;            // Habilitar el Ajax al modificar cualquier celda de la fila
  private $ajaxcolumn = false;         // Habilitar el ajax al modificar cualquier celda de la columna
  private $ajaxgrid = false;           // Habilitar el ajax al modificar cualquier celda
//  private $ajaxadicionales = array();
//  private $anchogrid='900';

  /**
   * Estable el nombre de la cabecera de la columna
   *
   * @param $val (string) Nombre de la cabecera
   * @return void
   */
  public function setTitle($val){ // $titulos

      $this->title = $val;

    }


  /**
   * Estable el nombre del campo en la tabla que
   * contiene los datos del campo.
   *
   * @param $val (string) Nombre del Campo en la BD
   * @return void
   */
  public function setField($val){ // $campos
    $x = array();
    $x=split('_',$val);
    $i=0;
    $this->field="";
    while ($i<count($x)){
    	$y= $this->field;
        $this->field = $y.ucfirst(strtolower($x[$i]));
       $i++;
    }
  }

  /**
   * Estable el tipo de objeto que es la columna
   * ej.   TEXTO, MONTO o FECHA
   *
   * @param $val (string) Tipo de Objeto Columna::TEXTO
   * @return void
   */
  public function setType($val){ // $tipos
    $this->type = $val;
  }


  /**
   * Estable si la columna numérica debe ser totalizada,
   * y el objeto que contendrá el valor
   *
   * @param $val (bool) true/false
   * @param $obj Nombre del Objeto Html donde se colocara el resultado de la totalización (string)
   * @return void
   */
  public function setIssum($val,$obj=''){ // $totales
    $this->is_sum = $val;
    $this->obj_sum = $obj;
  }

  /**
   * Estable si la columna numérica debe ser totalizada,
   * y el objeto que contendrá el valor
   *
   * @param $obj Nombre del Objeto Html donde se colocara el resultado de la totalización (string)
   * @return void
   */
  public function setObjsum($obj=''){ // $totales
    $this->obj_sum = $obj;
  }


  /**
   * Estable el código JS que se colocará en cada objeto de la columna
   *
   * @param $val (string) Código JS
   * @return void
   */
  public function setJscript($val){ // $js
    $this->js = $val;
  }


  /**
   * Estable si los objetos de la columa deben ser guardados
   *
   * @param $val (bool) true/false
   * @return void
   */
  public function setSave($val){ // $grabar
    $this->save = (bool)$val;
  }

  /**
   * Estable si los objetos de la columna tendrán un catálogo
   * para busqueda rápida de datos
   *
   * @param $clase (string) Nombre de la tabla/clase de donde se genera el catalogo
   * @param $form (string) Objeto html form donde estan los objetos a actualizar por el catálogo
   * @param $objadic (string) Objeto donde se colcorá la información adicional del catálogo
   * @return void
   */
  public function setCatalog($clase,$form,$objs,$metodo = '',$param = array()){

    $this->catalogform = $form;
    $this->catalogclass = $clase;
    $this->catalogobj = $objs;
    $this->catalogmethod = $metodo;
    $this->catalogparam = $param;

  }

  /**
   * Establece el uso de Ajax para toda la fila
   *
   * @return void
   */
  public function setAjaxrow($val){

    $this->ajaxrow = (bool)$val;

  }


  /**
   * Establece el uso de Ajax para toda la columna
   *
   * @return void
   */
  public function setAjaxcolumn($val){

    $this->ajaxcolumn = (bool)$val;

  }

  /**
   * Establece el uso de Ajax para toda la columna
   *
   * @return void
   */
  public function setAjaxgrid($val){

    $this->ajaxgrid = (bool)$val;

  }


  /**
   * Establece si al objeto se le coloca al inicio el valor que trae el objeto
   *
   * @param $val (bool) Estado de los objetos de la columna
   * @return void
   */
  public function setEmtpy($val=false){

    $this->emtpy = $val;

  }

  /**
   * Establece si va a ser una columna oculta o no
   *
   * @param $val (bool) Estado de los objetos de la columna
   * @return void
   */
  public function setHide($val=false){

    $this->hide = $val;

  }

  /**
   * Establece las opciones que va a contener el combo
   *
   * @param $val Arreglo de opciones del COmbo
   * @return void
   */
  public function setComboelements($val){

    if(is_array($val)) $this->comboelements = $val;
    else $this->comboelements = array();

  }

  /**
   * Establece las opciones que va a contener el combo
   *
   * @param $val Arreglo de opciones del COmbo
   * @return void
   */
  public function setCheckbox($val){

    $this->checkbox = $val;

  }

  /**
   * Establece si la celda va a contener un boton.
   * Este botón estará enlazado al contenido de la
   * variable $enlaceboton
   *
   * @param $val Arreglo de opciones del COmbo
   * @return void
   */
  public function setButton($val){

    $this->boton = $val;

  }

  /**
   * Establece el enlace que va a contener el botón
   *
   * @param $val string con enlace a usar en e nuevo botón
   * @return void
   */
  public function setButtonfunction($val){

    $this->buttonfunction = $val;

  }

  /**
   * Establece el valor por defecto a colcoar en las filas nuevas
   *
   * @param $val string con el valor por defecto
   * @return void
   */
  public function setDefault($val){

    $this->default = $val;

  }

  /**
   * Establece el valor por defecto del ancho de la columna
   *
   * @param $val string con el valor por defecto
   * @return void
   */
  public function setWidth($val){

    $this->width = $val;

  }

  /**
   * Establece si la columna es de solo lectura
   *
   * @param $val string con el valor por defecto
   * @return void
   */
  public function setReadonly($val){

    $this->readonly = (bool)$val;

  }

   /**
    * Constructor de la columna
    *
    * @param $val (string) Título de la columna
    * @return void
    */
  public function GridColumn($name){ // Constructor ****************
    self::setTitle($name);

    }


  /**
   * Obtiene el Título de la columna
   *
   * @return string
   */
  public function getTitle(){ // $titulos
      return $this->title;
  }


  /**
   * Obtiene el nombre del campo en la tabla a la que hace referencia
   *
   * @return string
   */
  public function getField(){ // $campos
    return $this->field;
  }

  /**
   * Obtiene el tipo de objeto que contendra la columna
   *
   * @return string
   */
  public function getType(){ // $tipos
    return $this->type;
  }

  /**
   * Indica si la columan debe ser totalizada
   *
   * @return bool
   */
  public function getIssum(){ // $totales
    return $this->is_sum;
  }

  /**
   * Obtiene el Objeto donde se colcará el resultado de la totalización de la columna
   *
   * @return string
   */
  public function getObjsum(){ // $totales
    return $this->obj_sum;
  }

  /**
   * Obtiene el código JavaScript que se insertará en los objetos de la columna
   *
   * @return string
   */
  public function getJscript(){ // $js
    return $this->js;
  }

  /**
   * Indica si los objetos de la columan deben tomados en cuenta para
   * ser guardados en la base de datos.
   *
   * @return bool
   */
  public function getSave(){ // $grabar
    return $this->save;
  }

  /**
   * Obtiene La codificación para insertar una busqueda por catálogo
   * en los objetos de la columna
   *
   * @param $pos (int) Posicion de la columna donde se colocará el dato adicional
   * @return string
   */
  public function getCatalog($pos=0){ // $grabar

    $arr = array();

    $arr['class'] = $this->catalogclass;
    $arr['form'] = $this->catalogform;
    $arr['method'] = $this->catalogmethod;
    $arr['objs'] = array();
    $arr['params'] = $this->catalogparam;

    if(is_array($this->catalogobj)){
      $arr['objs'][$this->getField()] = $pos;
      foreach($this->catalogobj as $index => $obj){
        $arr['objs'][$index] = $obj;

      }
    }else $arr['objs'][$this->getField()] = $this->catalogobj;

    return $arr;
  }

  /**
   * Identifica si se hace un llamado ajax de toda la fila
   *
   * @return string
   */
  public function getAjaxrow(){

    return $this->ajaxrow;

  }

  /**
   * Identifica si se hace un llamado ajax de toda la columna
   *
   * @return string
   */
  public function getAjaxcolumn(){

    return $this->ajaxcolumn;

  }

  /**
   * Identifica si se hace un llamado ajax de todo el grid
   *
   * @return string
   */
  public function getAjaxgrid(){

    return $this->ajaxgrid;

  }

  /**
   * obtiene si la columna esta o no vacia al iniciar
   *
   * @return string
   */
  public function getEmpty(){

    return $this->empty;

  }

/**
   * obtiene si la columna esta o no oculta
   *
   * @return string
   */
  public function getHide(){

    return $this->hide;

  }

  /**
   * Obtiene las opciones que va a contener el combo
   *
   * @return void
   */
  public function getComboelements(){

    return $this->comboelements;

  }

  /**
   * Obtiene las opciones que va a contener el combo
   *
   * @return void
   */
  public function getCheckbox(){

    return $this->checkbox;

  }


  /**
   * Verifica si la columna contiene o no un botón
   *
   * @return void
   */
  public function getButton(){

    return $this->button;

  }

  /**
   * Verifica si la columna contiene o no un botón
   *
   * @return void
   */
  public function getButtonfunction(){

    return $this->buttonfunction;

  }

  /**
   * Retorna el valor por defecto para las filas nuevas
   *
   * @return void
   */
  public function getDefault(){

    return $this->default;

  }

  /**
   * Retorna el valor por defecto para el grid
   *
   * @return void
   */
  public function getWidth(){

    return $this->width;

  }

  /**
   * Establece si la columna es de solo lectura
   *
   * @param $val string con el valor por defecto
   * @return void
   */
  public function getReadonly(){

    return $this->readonly;

  }
  
  /**
   * Devuelve si al objeto se le coloca al inicio el valor que trae el objeto
   *
   * @return bool
   */
  public function getEmtpy(){

    return $this->emtpy;

  }
  


}

?>