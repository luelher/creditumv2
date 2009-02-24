<?php
/*
 * Created on 23/02/2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php use_helper('Tag') ?>

<?php $module = $sf_request->getParameter('module','principal'); ?>
<ul>
  <li class="<?php if($module=='principal' || $module=='index') echo 'current_page_item' ?>"><?php echo link_to('Principal','principal/index') ?></li>
  <li class="<?php if($module=='quienessomos') echo 'current_page_item' ?>"><?php echo link_to('¿Quienes Somos?','quienessomos/index') ?></li>
  <li class="<?php if($module=='servicios') echo 'current_page_item' ?>"><?php echo link_to('Servicios','servicios/index') ?></li>
  <li class="<?php if($module=='contactos') echo 'current_page_item' ?>"><?php echo link_to('Contactos','contactos/index') ?></li>
  <li class="<?php if($module=='ayuda') echo 'current_page_item' ?>"><?php echo link_to('Ayuda','ayuda/index') ?></li>
</ul>
