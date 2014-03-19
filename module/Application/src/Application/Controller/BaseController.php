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

class BaseController extends AbstractActionController
{

    protected $_authService = null;
    protected $_em = null;

    public function getAuthService()
    {
        if ($this->_authService == null)
        {
            $this->setAuthService($this->getServiceLocator()->get('Zend\Authentication\AuthenticationService'));
        }

        return $this->_authService;
    }

    public function setAuthService($authService)
    {
        $this->_authService = $authService;
    }

    public function getEntityManager()
    {
        if ($this->_em == null)
        {
            $this->_em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->_em;
    }

    public function getCurrentUserId()
    {
        $id = $this->getAuthService()->getIdentity()->getId();

        return ($id == 1) ? 0 : $id;
    }

}

