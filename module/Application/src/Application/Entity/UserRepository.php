<?php

namespace Application\Entity;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{

    public function getDevelopersList($client_id = 0)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->add('select', 'u')
                ->add('from', 'Application\Entity\User u')
                ->add('orderBy', 'u.name ASC')
                ->where('u.userType = 3');
        if (!empty($client_id))
        {
            $qb->join('u.clients', 'c')->andWhere('c.id = :id')->setParameter('id', $client_id);
        }
        $query = $qb->getQuery();
        $developers = $query->getResult();

        $data = array();
        foreach ($developers as $developer)
        {
            $data[$developer->getId()] = $developer->getName();
        }
        return $data;
    }

    public function getClientsList($client_id = null)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->add('select', 'u')
                ->add('from', 'Application\Entity\User u')
                ->add('orderBy', 'u.name ASC')
                ->where('u.userType = 2');
        if (!empty($client_id))
        {
            $qb->andWhere('u.id = :id')->setParameter('id', $client_id);
        }
        $query = $qb->getQuery();
        $clients = $query->getResult();

        $data = array();
        foreach ($clients as $client)
        {
            $data[$client->getId()] = $client->getName();
        }
        return $data;
    }

}

?>
