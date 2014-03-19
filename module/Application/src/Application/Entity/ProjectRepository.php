<?php

namespace Application\Entity;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

use Doctrine\ORM\EntityRepository;

class ProjectRepository extends EntityRepository
{

    public function getProjectList($client_id = null)
    {
	$qb = $this->_em->createQueryBuilder();
	$qb->add('select', 'p')
		->add('from', 'Application\Entity\Project p')
		->where('p.status = 1')
		->add('orderBy', 'p.id DESC');

	if ($client_id != null)
	{
	    $qb->join('p.client', 'c')->andWhere('c.id = :client_id')->setParameter('client_id', $client_id);
	}

	$query = $qb->getQuery();
	$projects = $query->getResult();

	$data = array();
	foreach ($projects as $project)
	{
	    $data[$project->getId()] = $project->getTitle();
	}
	return $data;
    }

    public function findDevelopersByProject($project_id = null)
    {
	$project = $this->find($project_id);
	$developers = $project->getDevelopers();
	$data = array();
	foreach ($developers as $developer)
	{
	    $data[$developer->getId()] = $developer->getName() . '(' . $developer->getUsername() . ')';
	}
	return $data;
    }

}

?>
