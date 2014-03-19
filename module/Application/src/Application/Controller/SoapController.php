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
use Zend\Soap\Server;
use Zend\Soap\Autodiscover;
use Zend\Soap\Server\DocumentLiteralWrapper;
use Application\Service\Tracker as SoapClass;

class SoapController extends \Application\Controller\BaseController
{

    protected $_authService = null;

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

    public function indexAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setTerminal(0);
        $serverUrl = 'http://time-tracker.com/soap.xml';
        if (isset($_GET['wsdl']))
        {
            //this is new:
            $soapAutoDiscover = new AutoDiscover();
            $soapAutoDiscover->setBindingStyle(array('style' => 'document'));
            $soapAutoDiscover->setOperationBodyStyle(array('use' => 'literal'));
            $soapAutoDiscover->setClass('\Application\Service\Tracker');
            $soapAutoDiscover->setUri($serverUrl);
            $wsdl = $soapAutoDiscover->generate();
            $wsdl = $wsdl->toDomDocument();
            //so this is:
            header("Content-Type: text/xml");
            echo $wsdl->saveXML();
            exit;
        }
        else
        {
            $soap = new Server($serverUrl . '?wsdl');
            //drop this:
            //$soap->setClass('SoapClass');
            //and instead, add this:
            $soap->setObject(new DocumentLiteralWrapper(new \Application\Service\Tracker()));
            $soap->handle();
        }
        exit;
    }

    public function clientAction()
    {
        $result = new ViewModel();
        $result->setTerminal(true);
        $result->setVariables(array('items' => 'items'));
        return $result;
    }

}

