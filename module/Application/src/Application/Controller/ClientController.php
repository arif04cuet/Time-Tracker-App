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
use Application\Form\addUser;
use Application\Form\addUserValidator;
use Application\Entity\User;

class ClientController extends \Application\Controller\BaseController
{

    public function redirectTo($action = 'list')
    {
        return $this->redirect()->toRoute('client', array(
            'action' => $action
        ));
    }

    public function indexAction()
    {

    }

    public function addAction()
    {
        $form = new addUser();
        //add developer
        $client_id = 0;
        $developers = $this->getEntityManager()->getRepository('Application\Entity\User')->getDevelopersList($client_id);
        $form->get('developers')->setValueOptions($developers);
        $request = $this->getRequest();

        if ($request->isPost()) {

            $formValidator = new addUserValidator();
            $form->setInputFilter($formValidator->getInputFilter());
            $form->setData($request->getPost());
            $form->setValidationGroup('name', 'username', 'password', 'password_verify');
            $criteria = array(
                'username' => $request->getPost('username'),
                'userType' => 2,
                'status' => 1
            );
            $userExist = $this->getEntityManager()->getRepository('Application\Entity\User')->findOneBy($criteria);
            $error = 0;
            if (count($userExist) > 0) {

                $form->setMessages(array(
                    'username' => array(
                        'exist' => 'Client already exist with this username,try another one please')
                ));
                $error = 1;
            }
            if ($form->isValid() and !$error) {
                $client = new User();
                $client->setUserType(2);
                $client->setAccessType(1);
                $client->setName($request->getPost('name'));
                $client->setEmail($request->getPost('email'));
                $client->setUsername($request->getPost('username'));
                $client->setPassword($request->getPost('password'));
                $client->setStatus($request->getPost('status'));
                $developers = $request->getPost('developers');
                if (count($developers) > 0) {
                    foreach ($developers as $devId) {
                        $dev = $this->getEntityManager()->getRepository('Application\Entity\User')->find($devId);
                        if ($dev instanceof \Application\Entity\User)
                            $client->addDeveloper($dev);
                    }
                }
                $this->getEntityManager()->persist($client);
                $this->getEntityManager()->flush();
                $this->flashMessenger()->addMessage('Client has been saved successfully');
                return $this->redirectTo();
            }
        }
        return array(
            'form' => $form,
            'flashMessages' => $this->flashMessenger()->getMessages()
        );
    }

    public function editAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if (!$id) {
            $this->redirectTo();
        }
        $request = $this->getRequest();
        $form = new addUser();
        //add developer
        $client_id = 0;
        $developers = $this->getEntityManager()->getRepository('Application\Entity\User')->getDevelopersList($client_id);
        $form->get('developers')->setValueOptions($developers);

        $form->get('submit')->setAttribute('value', 'Edit');
        $form->get('password')->setAttribute('required', '');
        $form->get('password_verify')->setAttribute('required', '');
        $form->get('username')->setAttribute('readonly', 'readonly');
        $client = $this->getEntityManager()->getRepository('Application\Entity\User')->find($id);
        $values = array();
        foreach ($client->getDevelopers() as $dev)
            $values[] = $dev->getId();

        $form->bind($client);
        $form->get('developers')->setValue($values);

        if ($request->isPost()) {

            $formValidator = new addUserValidator();
            $form->setInputFilter($formValidator->getInputFilter());
            $form->setData($request->getPost());
            $form->setValidationGroup('name', 'email', 'password', 'password_verify');

            if ($form->isValid()) {
                $client->setName($request->getPost('name'));
                $client->setEmail($request->getPost('email'));
                $client->setStatus($request->getPost('status'));
                if ($request->getPost('password'))
                    $client->setPassword($request->getPost('password'));
                $client->getDevelopers()->clear();
                $developers = $request->getPost('developers');
                if (count($developers) > 0) {
                    foreach ($developers as $devId) {
                        $dev = $this->getEntityManager()->getRepository('Application\Entity\User')->find($devId);
                        if ($dev instanceof \Application\Entity\User)
                            $client->addDeveloper($dev);
                    }
                }
                $this->getEntityManager()->flush();
                $this->flashMessenger()->addMessage('Client has been updated successfully');
                return $this->redirectTo();
            }
        }
        return array(
            'form' => $form,
            'flashMessages' => $this->flashMessenger()->getMessages()
        );
    }

    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if (!$id) {
            $this->redirectTo();
        }
        $em = $this->getEntityManager();
        $model = $em->find('Application\Entity\User', $id);
        if ($model) {
            $em->remove($model);
            $em->flush();
            $this->flashMessenger()->addMessage('User has been deleted successfully');
        } else
            $this->flashMessenger()->addMessage('Problem has been occured.can not deleted,error');

        $this->redirectTo();
    }

    public function listAction()
    {
        //add datatable resource
        $renderer = $this->serviceLocator->get('Zend\View\Renderer\RendererInterface');
        $renderer->headScript()->appendFile($renderer->basePath('/DataTables/media/js/jquery.dataTables.min.js'));
        $renderer->headLink()->prependStylesheet($renderer->basePath('/DataTables/media/css/jquery.dataTables.css'));

        $request = $this->getRequest();
        if ($request->isPost()) {

        }
        return new ViewModel(array(
            'client' => $this->getCurrentUserId(),
            'flashMessages' => $this->flashMessenger()->getMessages()
        ));
    }

}

