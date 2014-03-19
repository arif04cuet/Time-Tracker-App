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
use Application\Form\ProjectValidator;

class ProjectController extends \Application\Controller\BaseController
{

    protected $_form = null;

    public function getForm()
    {
	if ($this->_form == null)
	    $this->_form = new \Application\Form\Project();

	return $this->_form;
    }

    public function redirectTo($action = 'list')
    {
	return $this->redirect()->toRoute('project', array(
		    'action' => $action
		));
    }

    public function indexAction()
    {

    }

    public function addAction()
    {
	$form = $this->getForm();
	$request = $this->getRequest();

	//client list
	$client_id = $this->getCurrentUserId();
	$clients = $this->getEntityManager()->getRepository('Application\Entity\User')->getClientsList($client_id);
	$clients[''] = 'Select One';

	$form->get('client')->setValueOptions($clients)->setValue('');
	if ($request->isPost())
	{
	    $project = new \Application\Entity\Project();
	    $client = $this->getEntityManager()->getRepository('Application\Entity\User')->find($request->getPost('client'));
	    if ($client instanceof \Application\Entity\User)
		$project->setClient($client);

	    $project->setTitle($request->getPost('title'));
	    $project->setStatus($request->getPost('status'));
	    $project->setStartingDate(new \DateTime("now"));
	    $developers = $request->getPost('developers');
	    if (count($developers) > 0)
	    {
		foreach ($developers as $devId)
		{
		    $dev = $this->getEntityManager()->getRepository('Application\Entity\User')->find($devId);
		    if ($dev instanceof \Application\Entity\User)
			$project->addDeveloper($dev);
		}
	    }

	    $this->getEntityManager()->persist($project);

	    $this->getEntityManager()->flush();

	    $this->flashMessenger()->addMessage('Project has been saved successfully');

	    return $this->redirectTo();
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
	$form = $this->getForm();
	$request = $this->getRequest();

	$project = $this->getEntityManager()->getRepository('Application\Entity\Project')->find($id);

	//client list
	$client_id = $this->getCurrentUserId();
	$clients = $this->getEntityManager()->getRepository('Application\Entity\User')->getClientsList($client_id);
	$clients[''] = 'Select One';
	$form->get('client')->setValueOptions($clients)->setValue($project->getClient()->getId());
	$form->bind($project);
	$form->get('client')->setValue($project->getClient()->getId());
	if ($request->isPost())
	{
	    $client = $this->getEntityManager()->getRepository('Application\Entity\User')->find($request->getPost('client'));
	    if ($client instanceof \Application\Entity\User)
		$project->setClient($client);

	    $project->setTitle($request->getPost('title'));
	    $project->setStatus($request->getPost('status'));
	    //$project->setStartingDate(new \DateTime("now"));
	    $project->getDevelopers()->clear();
	    $developers = $request->getPost('developers');
	    if (count($developers) > 0)
	    {
		foreach ($developers as $devId)
		{
		    $dev = $this->getEntityManager()->getRepository('Application\Entity\User')->find($devId);
		    if ($dev instanceof \Application\Entity\User)
			$project->addDeveloper($dev);
		}
	    }

	    $this->getEntityManager()->flush();
	    $this->flashMessenger()->addMessage('Project has been saved successfully');
	    return $this->redirectTo();
	}
	return array(
	    'form' => $form,
	    'flashMessages' => $this->flashMessenger()->getMessages()
	);
    }

    public function closeAction()
    {
	$id = (int) $this->params()->fromRoute('id', 0);
	if (!$id)
	{
	    $this->redirectTo();
	}
	$em = $this->getEntityManager();
	$model = $em->find('Application\Entity\Project', $id);
	if ($model)
	{
	    $model->setStatus(0);
	    $model->setClosingDate(new \DateTime("now"));
	    $em->flush();
	    $this->flashMessenger()->addMessage('Project has been closed successfully');
	}
	else
	    $this->flashMessenger()->addMessage('Project does not exist,error');

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

