<?php

class indexComponents extends sfComponents
{
  public function executeMenu($request)
  {
    // TODO: Cargar esta data de la base de datos para cada tipo de usuario
    //$this->menu = array('principal' => array('principal','index'), '¿quienes somos?' => array('quienessomos','index'),'servicios' => array('servicios','index'),'contactos' => array('contactos','index'),'ayuda' => array('ayuda','index'));
    $this->menu = array('escritorio' => array('escritorio','index'));
    $this->menu_auth = array('importar experiencias' => array('importar','index'), 'agregar experiencias' => array('creditos','index'));

    $user = $this->getUser();
    if ($user->isAuthenticated())
    {
      //return $this->redirect('@homepage');
    }

    if ($request->isXmlHttpRequest())
    {
      $this->getResponse()->setHeaderOnly(true);
      $this->getResponse()->setStatusCode(401);

      return sfView::NONE;
    }

    $class = sfConfig::get('app_sf_guard_plugin_signin_form', 'sfGuardFormSignin');
    $this->form = new $class();

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('signin'));
      if ($this->form->isValid())
      {
        $values = $this->form->getValues();
        $this->getUser()->signin($values['user'], array_key_exists('remember', $values) ? $values['remember'] : false);

        // always redirect to a URL set in app.yml
        // or to the referer
        // or to the homepage
        $signinUrl = sfConfig::get('app_sf_guard_plugin_success_signin_url', $user->getReferer('@homepage'));

        return $this->redirect($signinUrl);
      }
    }
    else
    {
      // if we have been forwarded, then the referer is the current URL
      // if not, this is the referer of the current request
      $user->setReferer($this->getContext()->getActionStack()->getSize() > 1 ? $request->getUri() : $request->getReferer());

      $module = sfConfig::get('sf_login_module');
      if ($this->getModuleName() != $module)
      {
        //return $this->redirect($module.'/'.sfConfig::get('sf_login_action'));
      }

      $this->getResponse()->setStatusCode(401);
    }

  }

  public function executeInfo()
  {
    $user = $this->getUser();
    if ($user->isAuthenticated()){
      $this->nomusu = $user->getGuardUser()->getUserName();
    }else $this->nomusu = 'Usuario No Autenticado';

  }

  public function executePrincipal()
  {

  }

}
?>