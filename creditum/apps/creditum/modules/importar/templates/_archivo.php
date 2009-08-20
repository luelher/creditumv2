<?php
/*
 * Created on 23/02/2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
  <?php use_helper("Grid"); ?>
  <div class="formulario">
    <form action="<?php echo url_for('importar/importar') ?>" method="POST" enctype="multipart/form-data" >
      <ul class="">
        <?php echo $formulario ?>
        <li>
          <input type="submit" value="Cargar Archivo" />
        </li>
      </ul>
    </form>
  </div>