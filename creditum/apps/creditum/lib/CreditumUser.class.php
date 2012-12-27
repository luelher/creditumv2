<?php

class CreditumUser extends sfGuardSecurityUser
{

  public static function checkPasswordCreditum($username, $password, $user)
  {
    $c = new Criteria();
    $c->add(UsuariosPeer::PWD,UsuariosPeer::PWD."=password('$password')", Criteria::CUSTOM);
    $c->add(UsuariosPeer::CEDULA,$username);
    $usuario = UsuariosPeer::doSelectOne($c);

    //return true;
    return $usuario ? true : false;
  }


  public function updateSfGuardUsersOnCreditum()
  {
    $creditum_users = UsuariosPeer::doSelect(new Criteria());
    $updates = 0;

    foreach ($creditum_users as $user) {
      $c = new Criteria();
      $c->add(sfGuardUserPeer::USERNAME, $user->getCedula());
      $guard_user = sfGuardUserPeer::doSelectOne($c);

      if(!$guard_user){
        $new_guard_user = new sfGuardUser();
        $new_guard_user->setUsername($user->getCedula());
        $new_guard_user->setPassword('creditum123');
        $new_guard_user->save();
        $updates++;
      }
    }
    return $updates;
  }

}
