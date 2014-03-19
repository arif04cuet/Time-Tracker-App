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

class WorkController extends \Application\Controller\BaseController
{

    public function indexAction()
    {

    }

    public function deleteAction()
    {
	$request = $this->getRequest();
	if ($request->isPost())
	{
	    $qb = $this->getEntityManager()
		    ->createQueryBuilder()
		    ->select('t')
		    ->from("Application\Entity\TimeSlot", 't')
		    ->where("t.id IN (:ids)")
		    ->setParameter('ids', implode(',', $request->getPost('del')));

	    $query = $qb->getQuery();
	    $list = $query->getResult();
	    foreach ($list as $item)
		$this->getEntityManager()->remove($item);
	    $this->getEntityManager()->flush();
	    $count = count($list);
	    $msg = "Total $count record has been deleted successfully";
	    $this->flashMessenger()->addMessage($msg);
	    return $this->redirectTo();
	    exit;
	}
    }

    public function diaryAction()
    {

	//add datatable resource
	$renderer = $this->serviceLocator->get('Zend\View\Renderer\RendererInterface');
	$renderer->headScript()->appendFile($renderer->basePath('/DataTables/media/js/jquery.dataTables.min.js'));
	$renderer->headLink()->prependStylesheet($renderer->basePath('/DataTables/media/css/jquery.dataTables.css'));


	$request = $this->getRequest();
	$data = array();
	$form = new \Application\Form\Diary();
	$client_id = $this->getCurrentUserId();
	$clients = $this->getEntityManager()->getRepository('Application\Entity\User')->getClientsList($client_id);
	$clients[''] = 'Select One';
	$form->get('client')->setValueOptions($clients)->setValue('');
	if ($_GET)
	{
	    $postData = $request->getQuery();
	    $projects = $this->getEntityManager()->getRepository('Application\Entity\Project')->getProjectList($postData['client']);
	    $form->get('project')->setValueOptions($projects);
	    $developers = $this->getEntityManager()->getRepository('Application\Entity\Project')->findDevelopersByProject($postData['project']);
	    $form->get('developer')->setValueOptions($developers);
	    $form->bind($postData);

	    //get data from post
	    $projectId = $postData['project'];
	    $developerId = $postData['developer'];
	    $data['fromDate'] = $postData['from'];
	    $data['toDate'] = $postData['to'];
	    $data['projectId'] = $projectId;
	    $data['developerId'] = $developerId;

	    if (isset($postData['delete']))
	    {
		//fetch data from database
		$qb = $this->getEntityManager()
			->createQueryBuilder()
			->select('t')
			->from("Application\Entity\TimeSlot", 't')
			->join("t.memu", 'm')
			->join("m.project", 'p')
			->where('p.id = :projectId')
			->setParameter('projectId', $projectId)
			->join("m.developer", 'd')
			->andWhere('d.id = :devId')
			->setParameter('devId', $developerId);


		if (isset($_GET['fromDate']) and $_GET['fromDate'])
		{
		    $fromDate = new \DateTime(date("Y-m-d", strtotime($_GET['fromDate'])));
		    $qb->andWhere('t.startTime >= :startTime')->setParameter('startTime', $fromDate);
		}
		if (isset($_GET['toDate']) and $_GET['toDate'])
		{
		    $toDate = new \DateTime(date("Y-m-d", strtotime($_GET['toDate'])));
		    $qb->andWhere('t.endTime <= :endTime')->setParameter('endTime', $toDate);
		}
		//$qb->delete("Application\Entity\TimeSlot", 't');
		$query = $qb->getQuery();
		$list = $query->getResult();
		foreach ($list as $item)
		    $this->getEntityManager()->remove($item);
		$this->getEntityManager()->flush();
		$count = count($list);
		$msg = "Total $count record has been deleted successfully";
		$this->flashMessenger()->addMessage($msg);
		return $this->redirectTo();
		exit;
	    }
	}

	return array(
	    'form' => $form,
	    'data' => $data,
	    'flashMessages' => $this->flashMessenger()->getMessages()
	);
    }

    public function redirectTo($action = 'diary')
    {
	return $this->redirect()->toRoute('work', array(
		    'action' => $action
		));
    }

}

