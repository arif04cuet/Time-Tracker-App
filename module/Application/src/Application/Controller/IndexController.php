<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\addUser as loginForm;

class IndexController extends \Application\Controller\BaseController
{

    public function indexAction()
    {
        return "ok";
        exit;
        $this->getCurrentUserId();
    }

    public function loginAction()
    {
        $msg = '';
        $form = new loginForm();
        $form->get('submit')->setValue('Login');
        $request = $this->getRequest();
        if ($request->isPost())
        {
            $data = $request->getPost();
            $form->setData($data);
            // If you used another name for the authentication service, change it here
            $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
            $adapter = $authService->getAdapter();
            $adapter->setIdentityValue($data['username']);
            $adapter->setCredentialValue($data['password']);
            $authResult = $authService->authenticate();

            if ($authResult->isValid())
            {
                return $this->redirect()->toRoute('home');
            }
            $msg = 'Login failed.invalid creadential provided';
        }
        return new ViewModel(array(
                    'form' => $form,
                    'error' => $msg
                ));
    }

    public function logoutAction()
    {
        $this->getAuthService()->clearIdentity();
        return $this->redirect()->toRoute('login');
    }

}

