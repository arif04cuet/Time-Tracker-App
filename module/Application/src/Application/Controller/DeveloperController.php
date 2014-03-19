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

class DeveloperController extends \Application\Controller\BaseController
{

    public function redirectTo($action = 'list')
    {
	return $this->redirect()->toRoute('developer', array(
		    'action' => $action
		));
    }

    public function indexAction()
    {

    }

    public function addAction()
    {
	$form = new addUser();
	$request = $this->getRequest();

	if ($request->isPost())
	{

	    $formValidator = new addUserValidator();
	    $form->setInputFilter($formValidator->getInputFilter());
	    $form->setData($request->getPost());
	    $form->setValidationGroup('name', 'username', 'password', 'password_verify');
	    $criteria = array(
		'username' => $request->getPost('username'),
		'userType' => 3,
		'status' => 1
	    );
	    $userExist = $this->getEntityManager()->getRepository('Application\Entity\User')->findOneBy($criteria);
	    $error = 0;
	    if (count($userExist) > 0)
	    {

		$form->setMessages(array(
		    'username' => array(
			'exist' => 'Developer already exist with this username,try another one please')
		));
		$error = 1;
	    }
	    if ($form->isValid() and !$error)
	    {
		$user = new User();
		$user->setUserType(3);
		$user->setAccessType(2);
		$user->setName($request->getPost('name'));
		$user->setEmail($request->getPost('email'));
		$user->setUsername($request->getPost('username'));
		$user->setPassword($request->getPost('password'));
		$user->setStatus($request->getPost('status'));
		$this->getEntityManager()->persist($user);
		$this->getEntityManager()->flush();
		$this->flashMessenger()->addMessage('Data has been saved successfully');
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
	$id = (int) $this->params()->fromRoute('id', 0);
	if (!$id)
	{
	    $this->redirectTo();
	}
	$request = $this->getRequest();
	$form = new addUser();
	$form->get('submit')->setAttribute('value', 'Edit');
	$form->get('password')->setAttribute('required', '');
	$form->get('password_verify')->setAttribute('required', '');
	$form->get('username')->setAttribute('readonly', 'readonly');
	$user = $this->getEntityManager()->getRepository('Application\Entity\User')->find($id);
	$form->bind($user);

	if ($request->isPost())
	{

	    $formValidator = new addUserValidator();
	    $form->setInputFilter($formValidator->getInputFilter());
	    $form->setData($request->getPost());
	    $form->setValidationGroup('name', 'username');

	    if ($form->isValid())
	    {
		$user->setUserType(3);
		$user->setAccessType(2);
		$user->setName($request->getPost('name'));
		$user->setEmail($request->getPost('email'));
		$user->setStatus($request->getPost('status'));
		//$user->setUsername($request->getPost('username'));
		if ($request->getPost('password'))
		    $user->setPassword($request->getPost('password'));

		$this->getEntityManager()->flush();
		$this->flashMessenger()->addMessage('Data has been updated successfully');
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
	$id = (int) $this->params()->fromRoute('id', 0);
	if (!$id)
	{
	    $this->redirectTo();
	}
	$em = $this->getEntityManager();
	$model = $em->find('Application\Entity\User', $id);
	if ($model)
	{
	    $em->remove($model);
	    $em->flush();
	    $this->flashMessenger()->addMessage('User has been deleted successfully');
	}
	else
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
	if ($request->isPost())
	{

	}
	return new ViewModel(array(
		    'client' => $this->getCurrentUserId(),
		    'flashMessages' => $this->flashMessenger()->getMessages()
		));
    }

}

