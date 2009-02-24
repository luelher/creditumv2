<?php use_helper('Number','Date','Partial') ?>


<h1 class="title"><?php echo __('Importar Información Crediticia'); ?></h1>
<div class="entry">
  <p><?php echo __('Este módulo le permitirá cargar la información crediticia de sus clientes al sistema Creditum para que este disponible para usted y los demás agregados') ?></p>
  <p>Seleccione el archivo con la información a importar a Creditum.net</p>

  <?php include_partial('archivo', array('formulario' => $formulario)) ?>

</div>
