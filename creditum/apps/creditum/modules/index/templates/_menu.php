<?php
/*
 * Created on 23/02/2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php use_helper('Tag','I18N') ?>
<?php if($sf_user->isAuthenticated()): ?>
  <h2>Menú Principal</h2>
  <?php foreach($menu as $k => $m) : ?>
    <div class="post">
      <p><?php echo link_to($k,$m[0].'/'.$m[1]) ?></p>
    </div>
  <?php endforeach; ?>

  <?php if($sf_user->isAuthenticated()): ?>
    <?php foreach($menu_auth as $k => $m) : ?>
      <div class="post">
        <p><?php echo link_to($k,$m[0].'/'.$m[1]) ?></p>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
<?php endif; ?>
  <?php if($sf_user->isAuthenticated()): ?>
    <h2>Sesión</h2>
    <p><a href="<?php echo url_for('@sf_guard_signout') ?>">Cerrar Sesión</a></p>
  <?php else: ?>
    <h2>Iniciar Sesión</h2>
    <form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
    <table>
      <?php echo $form ?>
    </table>

    <input type="submit" value="sign in" />
    </form>
  <?php endif; ?>

