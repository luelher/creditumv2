<?php 

  $sfExtjs3Plugin = new sfExtjs3Plugin(array('theme'=>'gray'), array('css' => 'symfony-extjs.css'));

  $sfExtjs3Plugin->load();

?>

  <div id="grid">
      <div id="GridPanela">
          <div id="grida">
          </div>

        </div>
<script type='text/javascript'>

// sfExtjs3Helper: v1.0
Ext.BLANK_IMAGE_URL = '/sfExtjs3Plugin/extjs/resources/images/default/s.gif';

function formatDate(value){
    return value ? value.dateFormat('d/m/Y') : '';
}

// application: App
var App = function () { 

var data = 
[
  ['1','100000330004534','2000-06-10','2002-09-15',622624,34590,18,21,1],
  ['2','1000003','2008-05-20','2008-07-20',23456,7890,12,20,20]
];

var cm = new Ext.grid.ColumnModel (
[
  {
    header: 'Cedula',
    width: 100,
    sortable: true,
    dataIndex: 'IdClientePersona',
    editor: new Ext.form.TriggerField ({
      allowBlank: false
    })
  },
  {
    header: 'Factura',
    width: 100,
    sortable: true,
    dataIndex: 'Factura',
    editor: new Ext.form.TextField ({
      allowBlank: false
    })
  },
  {
    header: 'Fecha Compra',
    width: 100,
    sortable: true,
    dataIndex: 'FechaCompra',
    editor: new Ext.form.DateField ({
      allowBlank: false,
      format: 'd/m/y'
    }),
    renderer: formatDate,
  },
  {
    header: 'Fecha Operacion',
    width: 100,
    sortable: true,
    dataIndex: 'FechaOperacion',
    editor: new Ext.form.DateField ({
      allowBlank: false,
      format: 'd/m/y'
    }),
    renderer: formatDate,
  },
  {
    header: 'Monto',
    width: 80,
    sortable: true,
    dataIndex: 'Monto',
    editor: new Ext.form.NumberField ({
      allowBlank: false,
      allowNegative: false,
      maxValue: 999999999,
      allowDecimals: true,
      decimalSeparator: ','
    })
  },
  {
    header: 'Pago Mensual',
    width: 80,
    sortable: true,
    dataIndex: 'PagoMes',
    editor: new Ext.form.NumberField ({
      allowBlank: false,
      allowNegative: false,
      maxValue: 999999999,
      allowDecimals: true,
      decimalSeparator: ','
    })
  },
  {
    header: 'Numero de Giros',
    width: 80,
    sortable: true,
    dataIndex: 'NumGiros',
    editor: new Ext.form.NumberField ({
      allowBlank: false,
      allowNegative: false,
      maxValue: 999999999,
      allowDecimals: false
    })
  },
  {
    header: 'Experiencia',
    width: 80,
    sortable: true,
    dataIndex: 'Experiencia',
    editor: new Ext.form.NumberField ({
      allowBlank: false,
      allowNegative: false,
      maxValue: 999999999,
      allowDecimals: false
    })
  },
  {
    header: 'Estado',
    width: 80,
    sortable: true,
    dataIndex: 'Estado',
    editor: new Ext.form.NumberField ({
      allowBlank: false,
      allowNegative: false,
      maxValue: 999999999,
      allowDecimals: true,
      decimalSeparator: ','
    })
  }
]);


var create = new Ext.data.Record.create ([
  {
    name: 'Cedula',
    type: 'string',
    mapping: 'IdClientePersona'
  },
  {
    name: 'Factura',
    type: 'string',
    mapping: 'Factura'
  },
  {
    name: 'Fecha Compra',
    type: 'date',
    mapping: 'FechaCompra'
  },
  {
    name: 'Fecha Operacion',
    type: 'date',
    mapping: 'fechaOperacion'
  },
  {
    name: 'Monto',
    type: 'float',
    mapping: 'Monto'
  },
  {
    name: 'Pago Mensual',
    type: 'float',
    mapping: 'PagoMes'
  },
  {
    name: 'Numero de Giros',
    type: 'int',
    mapping: 'MunGiros'
  },
  {
    name: 'Experiencia',
    type: 'int',
    mapping: 'Experiencia'
  },
  {
    name: 'Estado',
    type: 'float',
    mapping: 'Estado'
  }
]);

/*
var store = new Ext.data.Store ({
  reader: new Ext.data.ArrayReader({ idIndex: 0 }, create),
  recordType: create,
  data: data
});
*/

var rt = 
{
  fields: 
    [
      { name: 'IdClientePersona', type: 'int' },
      { name: 'Factura', type: 'string' },
      { name: 'FechaCompra', type: 'date', dateFormat: 'Y-m-d' },
      { name: 'FechaOperacion', type: 'date', dateFormat: 'Y-m-d' },
      { name: 'Monto', type: 'float' },
      { name: 'PagoMes', type: 'float' },
      { name: 'NumGiros', type: 'int' },
      { name: 'Experiencia', type: 'int' },
      { name: 'Estado', type: 'int' }
    ]
};

var store = new Ext.data.ArrayStore (rt);

store.loadData(data);

var gridPanel = new Ext.grid.EditorGridPanel ({
  id: 'GridPanela',
  title: 'Información a Importar',
  width: 650,
  height: 300,
  frame: true,
  iconCls: 'icon-grid',
  cm: cm,
  renderTo: 'grida',
  clicksToEdit: 1,
  store: store,
  tbar: [{
          text: 'Nuevo Registro',
          handler : function(){
              var Newfile = gridPanel.getStore().recordType;
              var p = new Newfile({
                IdClientePersona: '',
                Factura: '',
                FechaCompra: '',
                FechaOperacion: '',
                Monto: 0,
                PagoMes: 0,
                NumGiros: 0,
                Experiencia: 0,
                Estado: 0,
              });
              gridPanel.stopEditing();
              store.insert(0, p);
              gridPanel.startEditing(0, 0);
          }
        }]
});


return {
 init: function () { 
    Ext.QuickTips.init();

    gridPanel.on('afteredit', function(e) {
        afterEdit(e);
    });
    
    gridPanel.syncSize(); 

   } 

}}();

Ext.onReady(App.init, App);

function afterEdit(e) {
      Ext.MessageBox.confirm('Confirm', 'Are you sure you want to do that?', showResult);
};    

function showResult(btn){
    Ext.example.msg('Button Click', 'You clicked the {0} button', btn);
};



</script>
  </div>
