<?php
/*
 * Created on 23/02/2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php use_helper('Form','Tag','I18N') ?>
  <h2>Menú Principal</h2>
  <?php foreach($menu as $k => $m){ ?>
    <div class="post">
      <p><?php echo link_to($k,$m[0].'/'.$m[1]) ?></p>
    </div>
  <?php } ?>

<?php if($sf_user->isAuthenticated()): ?>
  <h2>Sesión</h2>
  <p><a href="#">Cerrar Sesión</a></p>
<?php else: ?>
  <h2>Iniciar Sesión</h2>
  <?php echo form_tag('index/login') ?>
    <?php echo __('Usuario') ?>
    <?php echo input_tag('login', '') ?>
    <?php echo __('Contraseña') ?>
    <?php echo input_password_tag('password', '') ?>
    <?php echo submit_tag('Iniciar') ?>
  </form>
<?php endif; ?>
