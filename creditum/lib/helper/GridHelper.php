<?php

function grid_tag($obj,$objelim = array())
{
  $anchogrid = '800';
  $name      = $obj["name"];
  $filas     = $obj["filas"];
  $filas_vacias=$obj["filas"];
  $cabeza     = $obj["cabeza"];
  $eliminar   = $obj["eliminar"];
  $titulos    = $obj["titulos"];
  $ancho      = $obj["ancho"];
  $anchogrid  = $obj["anchogrid"];
  $alignf     = $obj["alignf"];
  $alignt     = $obj["alignt"];
  $campos     = $obj["campos"];
  $catalogos  = $obj["catalogos"];
  $ajax       = $obj["ajax"];
  $montos     = $obj["montos"];
  $filatotal  = $obj["filatotal"];
  $totales    = $obj["totales"];
  $html       = $obj["html"];
  $js         = $obj["js"];
  $datos      = $obj["datos"];
  $vacia      = $obj["vacia"];
  $oculta     = $obj["oculta"];
  $cuantos2   = count($montos);
  $tiposobj   = $obj["tiposobj"];
  $combo      = $obj["combo"];
  $checkbox   = $obj["checkbox"];
  $boton      = $obj["boton"];
  $default    = $obj["default"];
  $funcionajax= $obj["funcionajax"];
  $jseliminar = $obj["jseliminar"];
  $ajaxfila   = $obj["ajaxfila"];
  $ajaxcolumna= $obj["ajaxcolumna"];
  $ajaxgrid   = $obj["ajaxgrid"];
  $ajaxadicionales = $obj["ajaxadicionales"];

  $private = array();
  $public = array();

  use_helper("sfExtjs2");

  echo '<div id="GridPanel'.$name.'"></div>';
  
  $sfExtjs2Plugin = new sfExtjs2Plugin(array('theme'=>'gray'), array('css' => '/sfExtjsThemePlugin/css/symfony-extjs.css'));

  $sfExtjs2Plugin->load();
  $sfExtjs2Plugin->begin();


  // **************************************
  // Application
  // **************************************

  //data
  $private['data'] = $sfExtjs2Plugin->asVar(convertData($datos,$campos,$tiposobj));


  // create the data store
  $private['ds'] = $sfExtjs2Plugin->SimpleStore(convertColumnsNames($campos));


  // create the columnModel
  $private['cm'] = $sfExtjs2Plugin->ColumnModel(convertColumnsTypes($sfExtjs2Plugin, $tiposobj,$titulos,$campos));

  // create the newrecord button
  $private['create'] = $sfExtjs2Plugin->createRecord(convertColumnsNewRecord($sfExtjs2Plugin, $tiposobj,$titulos,$campos));

  $opcionesgrid = array(
      'id'      => 'GridPanel'.$name,
      'title'   => $cabeza,
      'width'   => 650,
      'height'  => 300,
      'frame'   => true,
      'iconCls' => 'icon-grid',
      'cm'      => $sfExtjs2Plugin->asVar('cm'),
      'ds'      => $sfExtjs2Plugin->asVar('ds'),
    );
    
  $columnsDefaults = "";

  if($filas_vacias>0) $opcionesgrid['tbar'] = $sfExtjs2Plugin->asVar("[{
                                                  text: 'Nuevo Registro',
                                                  handler : function(){
                                                      var p = new create({".$columnsDefaults."});
                                                      gridPanel.stopEditing();
                                                      ds.insert(0, p);
                                                      gridPanel.startEditing(0, 0);
                                                  }
                                              }]");

  //create the gridPanel
  $private['gridPanel'] = $sfExtjs2Plugin->EditorGridPanel($opcionesgrid);

  $public['init'] = $sfExtjs2Plugin->asMethod("
    Ext.QuickTips.init();

    ds.loadData(data);

    gridPanel.render('GridPanel".$name."');
  ");

  $sfExtjs2Plugin->beginApplication(
    array(
      'name'    => 'App',

      'private' => $private,
      'public'  => $public
    )
  );
  $sfExtjs2Plugin->endApplication();
  $sfExtjs2Plugin->initApplication('App');
  $sfExtjs2Plugin->end();

}

function convertColumnsTypes($sfExtjs2Plugin, $tipoobj,$titulos,$campos)
{

  /*$userStore = $sfExtjs2Plugin->SimpleStore(array(
      'fields' => array("'val'", "'name'"),
      'data' => $sfExtjs2Plugin->asVar("[
      ['val1', 'Valor 1' ],
    ['val2', 'Valor 2'],
    ['val3', 'Valor 3'],
    ]"),
  ));*/


  $columns = array();
  $columns['parameters'] = array();
  foreach($tipoobj as $i => $t)
  {
    switch ($t){
      case 'f':   //Fecha
        $colum = $sfExtjs2Plugin->asAnonymousClass(array('header' => $titulos[$i], 'width' => 100,  'sortable' => true, 'dataIndex' => $campos[$i], 'editor'  => $sfExtjs2Plugin->DateField(array('allowBlank' => false))));
        break;
      case 't':   //texto
        $colum = $sfExtjs2Plugin->asAnonymousClass(array('header' => $titulos[$i], 'width' => 100,  'sortable' => true, 'dataIndex' => $campos[$i], 'editor'  => $sfExtjs2Plugin->TextField(array('allowBlank' => false))));
        break;
      case 'a':   //texto area
        $colum = $sfExtjs2Plugin->asAnonymousClass(array('header' => $titulos[$i], 'width' => 100,  'sortable' => true, 'dataIndex' => $campos[$i], 'editor'  => $sfExtjs2Plugin->TextArea(array('allowBlank' => false))));
        break;
      case 'c':   //Combo
        $colum = $sfExtjs2Plugin->asAnonymousClass(array('header' => $titulos[$i], 'width' => 80, 'sortable' => true, 'dataIndex' => $campos[$i], 'editor'  => $sfExtjs2Plugin->ComboBox(array('typeAhead' => true, 'triggerAction' => 'all', 'lazyRender' => true, 'store' => $userStore, 'displayField' => 'name', 'valueField' => 'val', 'editable' => false, 'emptyText' => 'Seleccione un Valor', 'mode' => 'local'))));
        break;
      case 'k':   //check
        $colum = $sfExtjs2Plugin->asAnonymousClass(array('header' => $titulos[$i], 'width' => 40,  'sortable' => true, 'dataIndex' => $campos[$i], 'editor'  => $sfExtjs2Plugin->CheckBox(array())));
        break;
      case 'm':   //Monto Float
        $colum = $sfExtjs2Plugin->asAnonymousClass(array('header' => $titulos[$i], 'width' => 80, 'sortable' => true, 'dataIndex' => $campos[$i], 'editor'  => $sfExtjs2Plugin->NumberField(array('allowBlank' => false,  'allowNegative' => false,'maxValue' => 999999999, 'allowDecimals' => true,  'decimalSeparator' => ','))));
        break;
      case 'd':   //Monto Decimal
        $colum = $sfExtjs2Plugin->asAnonymousClass(array('header' => $titulos[$i], 'width' => 80, 'sortable' => true, 'dataIndex' => $campos[$i], 'editor'  => $sfExtjs2Plugin->NumberField(array('allowBlank' => false,  'allowNegative' => false,'maxValue' => 999999999, 'allowDecimals' => false))));
    }
    $columns['parameters'][] = $colum;
  }

  /*
  array
    (
      'parameters' => array
      (
        $sfExtjs2Plugin->asAnonymousClass(array('header' => 'City', 'width' => 200,  'sortable' => true, 'dataIndex' => 'city', 'editor'  => $sfExtjs2Plugin->TextField(array('allowBlank' => false)))),
        $sfExtjs2Plugin->asAnonymousClass(array('header' => 'Country', 'width' => 120, 'sortable' => true, 'dataIndex' => 'country',     'editor'  => $sfExtjs2Plugin->TextField(array('allowBlank' => false)))),
        $sfExtjs2Plugin->asAnonymousClass(array('header' => 'Numero', 'width' => 80, 'sortable' => true, 'dataIndex' => 'numero',     'editor'  => $sfExtjs2Plugin->NumberField(array('allowBlank' => false,  'allowNegative' => false,'maxValue' => 100, 'allowDecimals' => true,  'decimalSeparator' => ',')))),
        $sfExtjs2Plugin->asAnonymousClass(array('header' => 'Combo', 'width' => 80, 'sortable' => true, 'dataIndex' => 'Combo',     'editor'  => $sfExtjs2Plugin->ComboBox(array('typeAhead' => true, 'triggerAction' => 'all', 'lazyRender' => true, 'store' => $userStore, 'displayField' => 'userName', 'valueField' => 'userId', 'editable' => false, 'emptyText' => 'Select a user', 'mode' => 'local')))),
      )
    )
  */

  return $columns;
}

function convertColumnsNewRecord($sfExtjs2Plugin, $tipoobj,$titulos,$campos)
{

  $columns = array();
  $columns['parameters'] = array();
  foreach($tipoobj as $i => $t)
  {
    switch ($t){
      case 'f':   //Fecha
        $type = 'date';
        break;
      case 't':   //texto
        $type = 'string';
        break;
      case 'a':   //texto area
        $type = 'string';
        break;
      case 'c':   //Combo
        $type = '';
        break;
      case 'k':   //check
        $type = 'boolean';
        break;
      case 'm':   //Monto Float
        $type = 'float';
        break;
      case 'd':   //Monto Decimal
        $type = 'decimal';
    }
    $columns['parameters'][] = $colum = $sfExtjs2Plugin->asAnonymousClass(array('name' => $titulos[$i], 'type' => 80));
  }

  return $columns;
  /*
  array(
      'parameters' => array
      (
        $sfExtjs2Plugin->asAnonymousClass(array('name' => 'city', 'type' => 'string')),
        $sfExtjs2Plugin->asAnonymousClass(array('name' => 'country', 'type' => 'string')),
        $sfExtjs2Plugin->asAnonymousClass(array('name' => 'numero', 'type' => 'float')),
        $sfExtjs2Plugin->asAnonymousClass(array('name' => 'Combo')),
      )
    )
  */
}

function convertColumnsNames($campos)
{
  $columns = array();
  $columns['fields'] = array();
  foreach($campos as $t)
  {
    $columns['fields'][] = array('name' => $t);
  }
  /*
  array(
      'fields' => array (
        array('name' => 'city'),
        array('name' => 'country'),
        array('name' => 'numero'),
        array('name' => 'Combo'),
      )
    )
  */

  return $columns;

}

function convertData($data,$campos,$tiposobj)
{
  $dataoutput = "[";
  foreach($data as $i => $d)
  {
    $dataoutput = "[";
    foreach($campos as $j => $campo)
    {
      if (trim($campo)!="") {
        if(!is_array($d)){
          $metodo = 'get'.$campo;
          switch ($tiposobj[$j]){
            case 'f':
              $get = $d->$metodo('Y-m-d');
              break;
            case 'm':
              $get = $d->$metodo(true);
              break;
            default:
              $get = $d->$metodo();
          } // switch
          $getid = $d->getId();
        }else{
          if(array_key_exists(strtolower($campo),$d)) $get = $d[strtolower($campo)];
          else {
            switch ($tiposobj[$j]){
              case 'f':
                $get = date('Y-m-d');
                break;
              case 'm':
                $get = '0,00';
                break;
              default:
                $get = 'No encontrado';
            }
          }
          $getid = $d['id'];
        }
      }
      else
      {
        $get="";
        if(!is_array($d)){
          $getid = $d->getId();
        }else{
          $getid = $d['id'];
        }
      }
      switch ($tiposobj[$j]){
        case 'f':   //Fecha
        case 't':   //texto
        case 'a':   //texto
        case 'c':   //Combo
        case 'k':   //check
          $dataoutput .= "['".$get."']";
          break;
        case 'm':   //Monto
          $dataoutput .= "[".$get."]";
      }
      if(count($tiposobj)!=($j+1)) $dataoutput .= ",";
    }
    $dataoutput .= "]";
    if(count($data)!=($i+1)) $dataoutput .= ",";
  }

  $dataoutput .= "]";

/*
  $dd = "[
  [['the Netherlands'], ['Hola'], [12.5], ['DDD']],
  [['the Netherlands'], ['Mundo'], [12.5], ['FFF']],
  [['France'], ['A dormir'], [12.5], ['XXX']],
  ]";
*/
  return $dataoutput;
}

?>



<?php















//$sfExtjs2Plugin->asAnonymousClass(array('parameters' => array(
//                        $sfExtjs2Plugin->asAnonymousClass(
//                        array(
//                                'text' => 'Nuevo Registro',
//                                'handler' => $sfExtjs2Plugin->asMethod("var p = new create({
//                                                                        city: 'Nueva Ciudad',
//                                                                        country: 'Nuevo País',
//                                                                        numero: 100,
//                                                                        combo: ''
//                                                                      });
//                                                                      gridPanel.stopEditing();
//                                                                      //store.insert(0, p);
//                                                                      gridPanel.startEditing(0, 0);
//                                                                     "
//                                                                    )
//                              )
//                                                          )
//                                                                              )
//                                                  )
//                                                  )



?>






