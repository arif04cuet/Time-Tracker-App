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

class AjaxController extends \Application\Controller\BaseController
{

    protected $_em = null;

    public function getEntityManager()
    {
	if ($this->_em == null)
	{
	    $this->_em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
	}
	return $this->_em;
    }

    public function getEntityColumnValues($entity, $em, $desiredColums = array('*'))
    {
	$values = array();
	foreach ($desiredColums as $column)
	{
	    if (property_exists($entity, $column))
	    {
		$getter = 'get' . $column;
		$value = $entity->$getter();
		switch ($column)
		{
		    case 'client':
			$value = $value->getName();
			break;
		}
		if ($column == 'id' and $entity instanceof \Application\Entity\TimeSlot)
		    $value = $entity->getCheckbox();
		if ($column == 'memu' and $entity instanceof \Application\Entity\TimeSlot)
		    $value = $entity->getMemoName();
		$values[] = $value;
	    }
	    else
	    {
		$route = $_GET['route'];
		$url = $this->url()->fromRoute($route, array('action' => $column, 'id' => $entity->getId()));
		$values[] = '<a class="' . $column . '" href="' . $url . '">' . ucfirst($column) . '</a>';
	    }
	}
	return $values;
    }

    public function indexAction()
    {

    }

    public function userListAction()
    {

	$request = $this->getRequest();
//	if ($request->isXmlHttpRequest())
//	{
	$aColumns = array('id', 'username', 'name', 'email', 'edit', 'status');
	$seachColums = array('username');
	$iDisplayStart = 0;
	$iDisplayLength = 10;

	//limiting result
	if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1')
	{
	    $iDisplayStart = (int) $_GET['iDisplayStart'];
	    $iDisplayLength = (int) $_GET['iDisplayLength'];
	}
	//serching result
	$parameter = array('username' => '%');
	if (isset($_GET['sSearch']) && $_GET['sSearch'] != "")
	{
	    for ($i = 0; $i < count($seachColums); $i++)
	    {
		$parameter["$seachColums[$i]"] = $_GET['sSearch'] . '%';
	    }
	}
	//pr($parameter);
	$list = $this->getEntityManager()->getRepository('Application\Entity\User');
	$qb = $list->createQueryBuilder('u');
	$qb->where(
			$qb->expr()->like('u.username', ':username')
		)
		->addOrderBy('u.username', 'desc')
		->setParameters($parameter)
		->setFirstResult($iDisplayStart)
		->setMaxResults($iDisplayLength);

	$client = $_GET['client'];
	$userType = $_GET['userType'];
	if (!empty($userType))
	{
	    $qb->andWhere('u.userType = :userType')->setParameter('userType', $userType);
	}
	if (!empty($client) and $userType == 3)
	{
	    $qb->join('u.clients', 'c')->andWhere('c.id = :id')->setParameter('id', $client);
	}
	elseif (!empty($client) and $userType == 2)
	{
	    $qb->andWhere('u.id = :id')->setParameter('id', $client);
	}
	$query = $qb->getQuery();
	/* pr(array(
	  'sql' => $query->getSQL(),
	  'result' => $query->getResult()
	  ));
	  exit;
	 */
	$list = $query->getResult();
	$iTotal = count($list);
	$output = array(
	    "sEcho" => (int) isset($_GET['sEcho']) ? $_GET['sEcho'] : 0,
	    "iTotalRecords" => $iTotal,
	    "iTotalDisplayRecords" => $iDisplayLength,
	    "aaData" => array()
	);
	foreach ($list as $developer)
	{
	    $output['aaData'][] = $this->getEntityColumnValues($developer, $this->getEntityManager(), $aColumns);
	}
	echo json_encode($output);
	exit;
	//}
	exit;
    }

    //for project/list
    public function projectListAction()
    {

	$request = $this->getRequest();
	//if ($request->isXmlHttpRequest())
	//{
	$aColumns = array('id', 'title', 'startingDate', 'client', 'status', 'edit');
	$seachColums = array('title');
	$iDisplayStart = 0;
	$iDisplayLength = 10;

	//limiting result
	if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1')
	{
	    $iDisplayStart = (int) $_GET['iDisplayStart'];
	    $iDisplayLength = (int) $_GET['iDisplayLength'];
	}
	//serching result
	$parameter = array('title' => '%');
	if (isset($_GET['sSearch']) && $_GET['sSearch'] != "")
	{
	    for ($i = 0; $i < count($seachColums); $i++)
	    {
		$parameter["$seachColums[$i]"] = $_GET['sSearch'] . '%';
	    }
	}
	//pr($parameter);
	$list = $this->getEntityManager()->getRepository('Application\Entity\Project');
	$qb = $list->createQueryBuilder('p');
	$qb->where(
			$qb->expr()->like('p.title', ':title')
		)
		->addOrderBy('p.status', 'desc')
		->addOrderBy('p.title', 'desc')
		->setParameters($parameter)
		->setFirstResult($iDisplayStart)
		->setMaxResults($iDisplayLength);

	$client = $_GET['client'];
	if (!empty($client))
	{
	    $qb->join('p.client', 'c')->andWhere('c.id = :id')->setParameter('id', $client);
	}

	$query = $qb->getQuery();
//        pr(array(
//            'sql' => $query->getSQL(),
//            'result' => $query->getResult()
//        ));
//        exit;

	$list = $query->getResult();
	$iTotal = count($list);
	$output = array(
	    "sEcho" => (int) isset($_GET['sEcho']) ? $_GET['sEcho'] : 0,
	    "iTotalRecords" => $iTotal,
	    "iTotalDisplayRecords" => $iDisplayLength,
	    "aaData" => array()
	);
	foreach ($list as $developer)
	{
	    $output['aaData'][] = $this->getEntityColumnValues($developer, $this->getEntityManager(), $aColumns);
	}
	echo json_encode($output);
	exit;
	//}
	exit;
    }

    //for project/add/edit
    public function developerListAction()
    {
	$request = $this->getRequest();
//	if ($request->isXmlHttpRequest())
//	{
	$form = new \Application\Form\Project();
	$clientId = $request->getPost('client');
	$developers = $this->getEntityManager()->getRepository('Application\Entity\User')->getDevelopersList($clientId);
	$form->get('developers')->setValueOptions($developers);

	$projectId = $request->getPost('project_id');
	if (!empty($projectId))
	{
	    $project = $this->getEntityManager()->getRepository('Application\Entity\Project')->find($projectId);
	    $values = array();
	    foreach ($project->getDevelopers() as $dev)
		$values[] = $dev->getId();
	    $form->get('developers')->setValue($values);
	}
	$view = new ViewModel();
	$view->setTerminal(true);
	$view->setTemplate('application/project/ajax/developer-list.phtml');
	$view->setVariables(array('form' => $form));
	return $view;
	//}
	exit;
    }

    public function getDiaryAction()
    {
	$request = $this->getRequest();
//	if ($request->isXmlHttpRequest())
//	{
	$form = new \Application\Form\Diary();
	$clientId = $request->getPost('client');
	$projectId = $request->getPost('project');
	$client_id = $this->getCurrentUserId();
	$clients = $this->getEntityManager()->getRepository('Application\Entity\User')->getClientsList($client_id);
	$form->get('client')->setValueOptions($clients)->setValue($clientId);

	$projects = $this->getEntityManager()->getRepository('Application\Entity\Project')->getProjectList($clientId);
	$projects[''] = "Select One";
	$form->get('project')->setValueOptions($projects)->setValue('');
	if ($projectId)
	{
	    $form->get('project')->setValue($projectId);
	    $developers = $this->getEntityManager()->getRepository('Application\Entity\Project')->findDevelopersByProject($projectId);
	    $form->get('developer')->setValueOptions($developers);
	}
	$view = new ViewModel();
	$view->setTerminal(true);
	$view->setTemplate('application/work/ajax/diary.phtml');
	$view->setVariables(array('form' => $form));
	return $view;
//	}
	exit;
    }

    public function getDiaryImagesAction()
    {
	$request = $this->getRequest();
	$aColumns = array('id', 'memu', 'startTime', 'endTime', 'image');
	$iDisplayStart = 0;
	$iDisplayLength = 10;
	$projectId = $_GET['projectId'];
	$developerId = $_GET['developerId'];

	//limiting result
	if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1')
	{
	    $iDisplayStart = (int) $_GET['iDisplayStart'];
	    $iDisplayLength = (int) $_GET['iDisplayLength'];
	}
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
	$query = $qb->getQuery();
	$list = $query->getResult();
	$iTotal = count($list);

	$qb->setFirstResult($iDisplayStart)->setMaxResults($iDisplayLength);
	$query = $qb->getQuery();
	$list = $query->getResult();


	$output = array(
	    "sEcho" => (int) isset($_GET['sEcho']) ? $_GET['sEcho'] : 0,
	    "iTotalRecords" => $iTotal,
	    "iTotalDisplayRecords" => $iDisplayLength,
	    "aaData" => array()
	);
	foreach ($list as $timeSlot)
	{
	    $output['aaData'][] = $this->getEntityColumnValues($timeSlot, $this->getEntityManager(), $aColumns);
	}
	echo json_encode($output);
	exit;
    }

}

