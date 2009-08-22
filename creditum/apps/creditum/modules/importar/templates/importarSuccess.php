<?php
/*
 * Created on 23/02/2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>

<?php include_partial('archivo', array('formulario' => $formulario)) ?>
<?php if($result==-1) { ?>
<p><?php echo 'Ha ocurrido un error al intentar importar los datos del archivo. Se guardará el archivo que intento importar y se envirá al personal técnico de Creditum para que sea analizado' ?></p>
<p><?php echo 'Error: '.$error ?></p>
<?php }else{ ?>
<p><?php $data--; echo ($data).' Lineas Cargadas del archivo '.$archivo->getOriginalName(); ?></p>
<p><?php echo $convertido.' Lineas Importadas '?></p>  
<?php } ?>

