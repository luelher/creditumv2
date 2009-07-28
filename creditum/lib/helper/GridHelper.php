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

  echo '<div id="GridPanel'.$name.'">
          <div id="grid'.$name.'">
          </div>
        </div>';
  
  $sfExtjs3Plugin = new sfExtjs3Plugin(array('theme'=>'gray'), array('css' => 'symfony-extjs.css'));


  $sfExtjs3Plugin->load();
  $sfExtjs3Plugin->begin();

  echo "
function formatDate(value){
    return value ? value.dateFormat('d/m/Y') : '';
}
";

  // **************************************
  // Application
  // **************************************
  
  //data
  $private['data'] = $sfExtjs3Plugin->asVar(convertData($datos,$campos,$tiposobj));

  // create the columnModel
  $private['cm'] = $sfExtjs3Plugin->ColumnModel(convertColumnsTypes($sfExtjs3Plugin, $tiposobj, $titulos, $campos, $catalogos));

  // create the newrecord button
  $private['create'] = $sfExtjs3Plugin->RecordCreate(convertColumnsNewRecord($sfExtjs3Plugin, $tiposobj, $titulos, $campos));
  
  // create the data store
  $private['store'] = $sfExtjs3Plugin->ArrayStore(convertColumnsNames($campos, $tiposobj));
  
  $private['ret'] = $sfExtjs3Plugin->asVar('store.loadData(data)');
  
  $opcionesgrid = array(
      'id'      => 'GridPanel'.$name,
      'title'   => $cabeza,
      'width'   => 650,
      'height'  => 300,
      'frame'   => true,
      'iconCls' => 'icon-grid',
      'cm'      => $sfExtjs3Plugin->asVar('cm'),
      'renderTo' => 'grid'.$name,
      'clicksToEdit' => 1,
      'store'   => $sfExtjs3Plugin->asVar('store'),
    );

  // Cargar los valors por defecto de los nuevos registros
  $columnsDefaults = getDefaultValues($default, $tiposobj, $campos);

  if($filas_vacias>0) $opcionesgrid['tbar'] = $sfExtjs3Plugin->asVar("
  [{
    text: 'Nuevo Registro',
    handler : function(){
      var Newfile = gridPanel.getStore().recordType;
      var p = new Newfile({".$columnsDefaults."});
      gridPanel.stopEditing();
      store.insert(0, p);
      gridPanel.startEditing(0, 0);
    }
  }]");

  //create the gridPanel
  $private['gridPanel'] = $sfExtjs3Plugin->EditorGridPanel($opcionesgrid);

  $public['init'] = $sfExtjs3Plugin->asMethod("
    Ext.QuickTips.init();

    gridPanel.on('afteredit', function(e) {
        afterEdit(e);
    });
    
    gridPanel.syncSize(); 

  ");

  $sfExtjs3Plugin->beginApplication(
    array(
      'name'    => 'App',

      'private' => $private,
      'public'  => $public
    )
  );

  $sfExtjs3Plugin->endApplication();
  $sfExtjs3Plugin->initApplication('App');
  print "
  function afterEdit(e) {
        Ext.MessageBox.confirm('Confirm', 'Are you sure you want to do that?', showResult);
    };    

    function showResult(btn){
        Ext.example.msg('Button Click', 'You clicked the {0} button', btn);
    };


";

  $sfExtjs3Plugin->end();

}

function convertColumnsTypes($sfExtjs3Plugin, $tipoobj,$titulos,$campos,$catalogos)
{

  /*$userStore = $sfExtjs3Plugin->SimpleStore(array(
      'fields' => array("'val'", "'name'"),
      'data' => $sfExtjs3Plugin->asVar("[
      ['val1', 'Valor 1' ],
    ['val2', 'Valor 2'],
    ['val3', 'Valor 3'],
    ]"),
  ));*/

  $columns = array();
  $columns['parameters'] = array();
  $ii=0;
  foreach($tipoobj as $i => $t)
  {
    if($catalogos[$ii][0]!=""){
      $colum = $sfExtjs3Plugin->asAnonymousClass(array('header' => $titulos[$i], 'width' => 100,  'sortable' => true, 'dataIndex' => $campos[$i], 'editor'  => $sfExtjs3Plugin->TriggerField(array('allowBlank' => false))));      
    }else{
      
      switch ($t){
        case 'f':   //Fecha
          $colum = $sfExtjs3Plugin->asAnonymousClass(array('header' => $titulos[$i], 'width' => 100,  'sortable' => true, 'dataIndex' => $campos[$i], 'renderer' => 'formatDate', 'editor'  => $sfExtjs3Plugin->DateField(array('allowBlank' => false, 'format' => 'd/m/y'))));
          break;
        case 't':   //texto
          $colum = $sfExtjs3Plugin->asAnonymousClass(array('header' => $titulos[$i], 'width' => 100,  'sortable' => true, 'dataIndex' => $campos[$i], 'editor'  => $sfExtjs3Plugin->TextField(array('allowBlank' => false))));
          break;
        case 'a':   //texto area
          $colum = $sfExtjs3Plugin->asAnonymousClass(array('header' => $titulos[$i], 'width' => 100,  'sortable' => true, 'dataIndex' => $campos[$i], 'editor'  => $sfExtjs3Plugin->TextArea(array('allowBlank' => false))));
          break;
        case 'c':   //Combo
          $colum = $sfExtjs3Plugin->asAnonymousClass(array('header' => $titulos[$i], 'width' => 80, 'sortable' => true, 'dataIndex' => $campos[$i], 'editor'  => $sfExtjs3Plugin->ComboBox(array('typeAhead' => true, 'triggerAction' => 'all', 'lazyRender' => true, 'store' => $userStore, 'displayField' => 'name', 'valueField' => 'val', 'editable' => false, 'emptyText' => 'Seleccione un Valor', 'mode' => 'local'))));
          break;
        case 'k':   //check
          $colum = $sfExtjs3Plugin->asAnonymousClass(array('header' => $titulos[$i], 'width' => 40,  'sortable' => true, 'dataIndex' => $campos[$i], 'editor'  => $sfExtjs3Plugin->CheckBox(array())));
          break;
        case 'm':   //Monto Float
          $colum = $sfExtjs3Plugin->asAnonymousClass(array('header' => $titulos[$i], 'width' => 80, 'sortable' => true, 'dataIndex' => $campos[$i], 'editor'  => $sfExtjs3Plugin->NumberField(array('allowBlank' => false,  'allowNegative' => false,'maxValue' => 999999999, 'allowDecimals' => true,  'decimalSeparator' => ','))));
          break;
        case 'd':   //Monto Decimal
          $colum = $sfExtjs3Plugin->asAnonymousClass(array('header' => $titulos[$i], 'width' => 80, 'sortable' => true, 'dataIndex' => $campos[$i], 'editor'  => $sfExtjs3Plugin->NumberField(array('allowBlank' => false,  'allowNegative' => false,'maxValue' => 999999999, 'allowDecimals' => false))));
      }
      
    }
    $columns['parameters'][] = $colum;
    $ii++;
  }

  /*
  array
    (
      'parameters' => array
      (
        $sfExtjs3Plugin->asAnonymousClass(array('header' => 'City', 'width' => 200,  'sortable' => true, 'dataIndex' => 'city', 'editor'  => $sfExtjs3Plugin->TextField(array('allowBlank' => false)))),
        $sfExtjs3Plugin->asAnonymousClass(array('header' => 'Country', 'width' => 120, 'sortable' => true, 'dataIndex' => 'country',     'editor'  => $sfExtjs3Plugin->TextField(array('allowBlank' => false)))),
        $sfExtjs3Plugin->asAnonymousClass(array('header' => 'Numero', 'width' => 80, 'sortable' => true, 'dataIndex' => 'numero',     'editor'  => $sfExtjs3Plugin->NumberField(array('allowBlank' => false,  'allowNegative' => false,'maxValue' => 100, 'allowDecimals' => true,  'decimalSeparator' => ',')))),
        $sfExtjs3Plugin->asAnonymousClass(array('header' => 'Combo', 'width' => 80, 'sortable' => true, 'dataIndex' => 'Combo',     'editor'  => $sfExtjs3Plugin->ComboBox(array('typeAhead' => true, 'triggerAction' => 'all', 'lazyRender' => true, 'store' => $userStore, 'displayField' => 'userName', 'valueField' => 'userId', 'editable' => false, 'emptyText' => 'Select a user', 'mode' => 'local')))),
      )
    )
  */

  return $columns;
}

function convertColumnsNewRecord($sfExtjs3Plugin, $tipoobj,$titulos,$campos)
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
        $type = 'string';
        break;
      case 'k':   //check
        $type = 'boolean';
        break;
      case 'm':   //Monto Float
        $type = 'float';
        break;
      case 'd':   //Monto Decimal
        $type = 'int';
    }
    $columns['parameters'][] = $colum = $sfExtjs3Plugin->asAnonymousClass(array('name' => $titulos[$i], 'type' => $type, 'mapping' => $campos[$i]));
  }

  return $columns;
  /*
  array(
      'parameters' => array
      (
        $sfExtjs3Plugin->asAnonymousClass(array('name' => 'city', 'type' => 'string')),
        $sfExtjs3Plugin->asAnonymousClass(array('name' => 'country', 'type' => 'string')),
        $sfExtjs3Plugin->asAnonymousClass(array('name' => 'numero', 'type' => 'float')),
        $sfExtjs3Plugin->asAnonymousClass(array('name' => 'Combo')),
      )
    )
  */
}

function convertColumnsNames($campos,$tipoobj)
{
  $columns = array();
  $columns['fields'] = array();
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
        $type = 'string';
        break;
      case 'k':   //check
        $type = 'boolean';
        break;
      case 'm':   //Monto Float
        $type = 'float';
        break;
      case 'd':   //Monto Decimal
        $type = 'int';
    }
    if($type == 'date') $columns['fields'][] = array('name' => $campos[$i], 'type' => $type, 'dateFormat' => 'Y-m-d');
    else $columns['fields'][] = array('name' => $campos[$i], 'type' => $type);
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
  $dataoutput = "[
  ";
  foreach($data as $i => $d)
  {
    $dataoutput .= "[";
    foreach($campos as $j => $campo)
    {
      if (trim($campo)!="") {
        if(!is_array($d)){
          $metodo = 'get'.$campo;
          switch ($tiposobj[$j]){
            case 'f':
              $get = $d->$metodo('Y-m-d');
              break;
            case 'd':
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
              case 'd':
                $get = '0';
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
          $dataoutput .= "'".$get."'";
          break;
        case 'm':   //Monto
        case 'd':   //Monto
          $dataoutput .= "".$get."";
      }
      if(count($tiposobj)!=($j+1)) $dataoutput .= ",";
    }
    $dataoutput .= "],
";
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

function getDefaultValues($default, $tipoobj, $campos)
{
  $defaultvalues = "";
  $defval = "";
  $constdefault = array('f' => '', 't' => '', 'a' => '', 'c' => '', 'k' => false, 'm' => 0.0, 'd' => 0);
  
  // city: 'Nueva Ciudad',
  // country: 'Nuevo País',
  // numero: 100,
  // combo: ''  

  foreach($campos as $j => $campo)
  {
    if($default[$j]!="") $defval = $default[$j];
    else $defval = $constdefault[$tipoobj[$j]];
    
    $defaultvalues .= $campo.": ";
    if($tipoobj[$j]=="f" || $tipoobj[$j]=="t" || $tipoobj[$j]=="a" || $tipoobj[$j]=="c") 
    {$defaultvalues .= "'".$defval."'";}
    else
    {$defaultvalues .= $defval;}
    $defaultvalues .= ",";
  }  
  
  return $defaultvalues;
  
}


?>





