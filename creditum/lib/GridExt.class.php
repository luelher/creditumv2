<?php

class GridExt
{
  CONST COLUMN_WIDTH = 100;

  public function getGrid($opc)
  {
    $data = $opc->getData();
    $columns = $opc->getColumns();
  
    $private = array();
    $public = array();
  
    echo '<div id="GridPanel'.$opc->getName().'">
            <div id="grid'.$opc->getName().'">
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
    $private['data'] = $sfExtjs3Plugin->asVar($this->convertData($data,$columns));
  
    // create the columnModel
    $private['cm'] = $sfExtjs3Plugin->ColumnModel($this->convertColumnsTypes($sfExtjs3Plugin, $columns));
    
    $public['catalog'] = $sfExtjs3Plugin->asMethod($this->applyCatalogFunction($columns));
  
    // create the newrecord button
    $private['create'] = $sfExtjs3Plugin->RecordCreate($this->convertColumnsNewRecord($sfExtjs3Plugin, $columns));
    
    // create the data store
    $private['store'] = $sfExtjs3Plugin->ArrayStore($this->convertColumnsNames($columns));
    
    $private['ret'] = $sfExtjs3Plugin->asVar('store.loadData(data)');
    
    $opcionesgrid = array(
        'id'      => 'GridPanel'.$opc->getName(),
        'title'   => $opc->getTitle(),
        'width'   => 650,
        'height'  => 300,
        'frame'   => true,
        'iconCls' => 'icon-grid',
        'cm'      => $sfExtjs3Plugin->asVar('cm'),
        'renderTo' => 'grid'.$opc->getName(),
        'clicksToEdit' => 1,
        'store'   => $sfExtjs3Plugin->asVar('store'),
      );
  
    // Cargar los valors por defecto de los nuevos registros
    $columnsDefaults = $this->getDefaultValues($columns);
  
    if($opc->getRows()>0) $opcionesgrid['tbar'] = $sfExtjs3Plugin->asVar("
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
          Ext.MessageBox.confirm('Confirm', '¿Seguro que quieres hacer esto?', showResult);
      };    
  
      function showResult(btn){
          Ext.example.msg('Button Click', 'You clicked the {0} button', btn);
      };
  
  
  ";
  
    $sfExtjs3Plugin->end();
  
  }

  function applyCatalogFunction($columns)
  {
    foreach($columns as $i => $column)
    {
      $catalog = $column->getCatalog();
      if($catalog['class']!=""){
        $fnc = $catalog['method'];
        if($fnc!='') return "cm.config[$i].editor.onTriggerClick = $fnc;";
        else return "cm.config[$i].editor.onTriggerClick = null;";
      }
    }
  }

  function convertColumnsTypes($sfExtjs3Plugin, $col)
  {
    $columns = array();
    $columns['parameters'] = array();
    $ii=0;
    foreach($col as $i => $column)
    {
      $width = $column->getWidth()==0 ? self::COLUMN_WIDTH : $column->getWidth();
      $catalog = $column->getCatalog();

      if($catalog['class']!=""){
        $colum = $sfExtjs3Plugin->asAnonymousClass(array('header' => $column->getTitle(), 'width' => $width,  'sortable' => true, 'dataIndex' => $column->getField(), 'editor'  => $sfExtjs3Plugin->TriggerField(array('allowBlank' => false, 'readOnly' => $column->getReadonly()))));
      }else{
        switch ($column->getType()){
          case GridColumn::DATE:   //Fecha
            $colum = $sfExtjs3Plugin->asAnonymousClass(array('header' => $column->getTitle(), 'width' => $width ,  'sortable' => true, 'dataIndex' => $column->getField(), 'renderer' => 'formatDate', 'editor'  => $sfExtjs3Plugin->DateField(array('allowBlank' => false, 'format' => 'd/m/y', 'readOnly' => $column->getReadonly()))));
            break;
          case GridColumn::TEXT:   //texto
            $colum = $sfExtjs3Plugin->asAnonymousClass(array('header' => $column->getTitle(), 'width' => $width ,  'sortable' => true, 'dataIndex' => $column->getField(), 'editor'  => $sfExtjs3Plugin->TextField(array('allowBlank' => false, 'readOnly' => $column->getReadonly()))));
            break;
          case GridColumn::TEXTAREA:   //texto area
            $colum = $sfExtjs3Plugin->asAnonymousClass(array('header' => $column->getTitle(), 'width' => $width ,  'sortable' => true, 'dataIndex' => $column->getField(), 'editor'  => $sfExtjs3Plugin->TextArea(array('allowBlank' => false))));
            break;
          case GridColumn::COMBO:   //Combo
            $colum = $sfExtjs3Plugin->asAnonymousClass(array('header' => $column->getTitle(), 'width' => $width , 'sortable' => true, 'dataIndex' => $column->getField(), 'editor'  => $sfExtjs3Plugin->ComboBox(array('typeAhead' => true, 'triggerAction' => 'all', 'lazyRender' => true, 'store' => $column->getComboelements(), 'displayField' => 'name', 'valueField' => 'val', 'editable' => false, 'emptyText' => 'Seleccione un Valor', 'mode' => 'local', 'readOnly' => $column->getReadonly()))));
            break;
          case GridColumn::CHECK:   //check
            $colum = $sfExtjs3Plugin->asAnonymousClass(array('header' => $column->getTitle(), 'width' => $width ,  'sortable' => true, 'dataIndex' => $column->getField(), 'editor'  => $sfExtjs3Plugin->CheckBox(array('readOnly' => $column->getReadonly()))));
            break;
          case GridColumn::FLOAT:   //Monto Float
            $colum = $sfExtjs3Plugin->asAnonymousClass(array('header' => $column->getTitle(), 'width' => $width , 'sortable' => true, 'dataIndex' => $column->getField(), 'editor'  => $sfExtjs3Plugin->NumberField(array('allowBlank' => false,  'allowNegative' => false,'maxValue' => 999999999, 'allowDecimals' => true,  'decimalSeparator' => ',', 'readOnly' => $column->getReadonly()))));
            break;
          case GridColumn::DECIMAL:   //Monto Decimal
            $colum = $sfExtjs3Plugin->asAnonymousClass(array('header' => $column->getTitle(), 'width' => $width , 'sortable' => true, 'dataIndex' => $column->getField(), 'editor'  => $sfExtjs3Plugin->NumberField(array('allowBlank' => false,  'allowNegative' => false,'maxValue' => 999999999, 'allowDecimals' => false, 'readOnly' => $column->getReadonly()))));
        }
        
      }
      $columns['parameters'][] = $colum;
      $ii++;
    }
    
    return $columns;
  }


  public function convertColumnsNewRecord($sfExtjs3Plugin, $cols)
  {
  
    $columns = array();
    $columns['parameters'] = array();
    foreach($cols as $i => $column)
    {
      switch ($column->getType()){
        case GridColumn::DATE:   //Fecha
          $type = 'date';
          break;
        case GridColumn::TEXT:   //texto
          $type = 'string';
          break;
        case GridColumn::TEXTAREA:   //texto area
          $type = 'string';
          break;
        case GridColumn::COMBO:   //Combo
          $type = 'string';
          break;
        case GridColumn::CHECK:   //check
          $type = 'boolean';
          break;
        case GridColumn::FLOAT:   //Monto Float
          $type = 'float';
          break;
        case GridColumn::DECIMAL:   //Monto Decimal
          $type = 'int';
      }
      $columns['parameters'][] = $colum = $sfExtjs3Plugin->asAnonymousClass(array('name' => $column->getTitle(), 'type' => $type, 'mapping' => $column->getField()));
    }
  
    return $columns;
  }

  
  public function convertColumnsNames($cols)
  {
    $columns = array();
    $columns['fields'] = array();
    foreach($cols as $i => $column)
    {
      switch ($column->getType()){
        case GridColumn::DATE:   //Fecha
          $type = 'date';
          break;
        case GridColumn::TEXT:   //texto
          $type = 'string';
          break;
        case GridColumn::TEXTAREA:   //texto area
          $type = 'string';
          break;
        case GridColumn::COMBO:   //Combo
          $type = 'string';
          break;
        case GridColumn::CHECK:   //check
          $type = 'boolean';
          break;
        case GridColumn::FLOAT:   //Monto Float
          $type = 'float';
          break;
        case GridColumn::DECIMAL:   //Monto Decimal
          $type = 'int';
      }
      if($type == 'date') $columns['fields'][] = array('name' => $column->getField(), 'type' => $type, 'dateFormat' => 'Y-m-d');
      else $columns['fields'][] = array('name' => $column->getField(), 'type' => $type);
    }

    return $columns;
  
  }
  
  public function convertData($data,$columns)
  {
    $dataoutput = "[
    ";
    foreach($data as $i => $d)
    {
      $dataoutput .= "[";
      foreach($columns as $j => $column)
      {
        if (trim($column->getField())!="") {
          if(!is_array($d)){                  // Si es un objeto
            $metodo = 'get'.$column->getField();
            switch ($column->getType()){
              case GridColumn::TEXT:
                $get = $d->$metodo('Y-m-d');
                break;
              case GridColumn::DECIMAL:
              case GridColumn::FLOAT:
                $get = $d->$metodo(true);
                break;
              default:
                $get = $d->$metodo();
            } // switch
            $getid = $d->getId();
          }else{                              // Si es un arreglo
            if(array_key_exists(strtolower($column->getField()),$d)) $get = $d[strtolower($column->getField())];
            else {
              switch ($column->getType()){
                case GridColumn::DATE:
                  $get = date('Y-m-d');
                  break;
                case GridColumn::FLOAT:
                  $get = '0,00';
                  break;
                case GridColumn::DECIMAL:
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
          case GridColumn::DATE:   //Fecha
          case GridColumn::TEXT:   //texto
          case GridColumn::TEXTAREA:   //texto
          case GridColumn::COMBO:   //Combo
          case GridColumn::CHECK:   //check
            $dataoutput .= "'".$get."'";
            break;
          case GridColumn::FLOAT:   //Monto
          case GridColumn::DECIMAL:   //Monto
            $dataoutput .= "".$get."";
        }
        if(count($tiposobj)!=($j+1)) $dataoutput .= ",";
      }
      $dataoutput .= "],
  ";
      if(count($data)!=($i+1)) $dataoutput .= ",";
    }
  
    $dataoutput .= "]";
  
    return $dataoutput;
  }
  
  public function getDefaultValues($columns)
  {
    $defaultvalues = "";
    $defval = "";
    $constdefault = array(GridColumn::DATE => '', GridColumn::TEXT => '', GridColumn::TEXTAREA => '', GridColumn::COMBO => '', GridColumn::CHECK => false, GridColumn::FLOAT => 0.0, GridColumn::DECIMAL => 0);
    
    foreach($columns as $j => $column)
    {
      $val = $column->getDefault();
      $type = $column->getType();
      if($val!="") $defval = $val;
      else $defval = $constdefault[$column->getType()];
      
      $defaultvalues .= $column->getField().": ";
      if($type==GridColumn::DATE || $type==GridColumn::TEXT || $type==GridColumn::TEXTAREA || $type==GridColumn::COMBO)
      {
        if($column->getEmtpy()) $defval = '';
        $defaultvalues .= "'".$defval."'";
      }
      else
      {
        if($column->getEmtpy()) $defval = 0;
        $defaultvalues .= $defval;
      }
      $defaultvalues .= ",";
    }  
    
    return $defaultvalues;
    
  }
  
}

?>
