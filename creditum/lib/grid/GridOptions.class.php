<?php

/**
 * Clase para el manejo de las Opciones del Grid
 *
 * @package    Siga
 * @subpackage lib
 * @author     Grupo Desarrollo Cidesa <desarrollo@cidesa.com.ve>
 * @version    SVN: $Id: $
 * @copyright  Copyright 2007, Cidesa C.A.
 *
 */
class GridOptions
{
  public $columns = array();
  private $delete = true;
  private $title = 'Título';
  private $name = 'a';
  private $width = 1000;
  private $rows = 10;
  private $classname ='';
  private $jsdelete = '';
  
  public $data = array();

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
      $this->colums[] = new GridColumn($obj);

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
    if($obj instanceof GridColumn){
      $this->columns[] = $obj;
    }
  }

  /**
   * Establece si se coloca el icono de eliminar en cada fila
   *
   * @param $val (bool) true/false
   * @param $function (string) nombre de la función a ajecutar en cada botón eliminar
   * @return bool
   */
  public function setDelete($val, $jsdelete = ''){

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
  public function setName($val){
    $this->name = $val;
  }

  /**
   * Establece el Nro de filas adicionales para insertar
   * nuevos datos en el grid. Por defecto 15
   *
   * @param $val (int) Cantidad de fila nuevas
   * @return bool
   */
  public function setRows($val){

    $this->rows=$val;

  }

  /**
   * Establece la tabla de la cual se traen los datos del grid
   *
   * @param $val (string) Nombre de la Tabla/Clase
   * @return bool
   */
  public function setClassname($val){

    $this->classname = ucfirst(strtolower($val));

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
  
  /**
   * Estable los datos a mostrar en el grid
   *
   * @param $arr (array) Arreglo con los objetos/datos a mostrar en el grid
   * @return bool
   */
  public function setData($arr){

    $this->data = $arr;

  }
  
  
  
  /**
   * Establece si se coloca el icono de eliminar en cada fila
   *
   * @return bool
   */
  public function getDelete(){

    return $this->delete = $val;
    
  }

  /**
   * Establece el título del Grid
   *
   * @return string
   */
  public function getTitle(){
    return $this->title;
  }

/**
   * Establece el prefijo de las cajas de textos
   *
   * @param $val (string) prefijo de las cajas de textos
   * @return string
   */
  public function getName(){
    return $this->name;
  }

  /**
   * Establece el Nro de filas adicionales para insertar
   * nuevos datos en el grid. Por defecto 15
   *
   * @return int
   */
  public function getRows(){

    return $this->rows;

  }


  /**
   * Estable el ancho total del Grid
   *
   * @return int
   */
  public function getWidth(){

    return $this->width;

  }

  /**
   * retorna los objetos/datos a mostrar en el grid
   *
   * @return array
   */
  public function getData(){

    return $this->data;

  }

  /**
   * retorna el nombre de la clase base del grid
   *
   * @return array
   */
  public function getClassname(){

    return $this->classname;

  }


  /**
   * retorna el nombre de la clase base del grid
   *
   * @return array
   */
  public function getColumns(){

    return $this->columns;

  }


}



?>
