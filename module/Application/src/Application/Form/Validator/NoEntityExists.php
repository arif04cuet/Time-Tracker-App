<?php

namespace Application\Validator\Doctrine;

use Zend\Validator\AbstractValidator;
use Doctrine\ORM\EntityManager;

class NoEntityExists extends AbstractValidator
{

    const ENTITY_FOUND = 'entityFound';

    protected $messageTemplates = array();

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @param string
     */
    protected $query;

    /**
     * Determines if empty values (null, empty string) will <b>NOT</b> be included in the check.
     * Defaults to true
     * @var bool
     */
    protected $ignoreEmpty = true;

    /**
     * Dummy to catch messages with PoEdit...
     * @param string $msg
     * @return string
     */
    public function translate($msg)
    {
        return $msg;
    }

    /**
     * @return the $ignoreEmpty
     */
    public function getIgnoreEmpty()
    {
        return $this->ignoreEmpty;
    }

    /**
     * @param boolean $ignoreEmpty
     */
    public function setIgnoreEmpty($ignoreEmpty)
    {
        $this->ignoreEmpty = $ignoreEmpty;
        return $this;
    }

    /**
     *
     * @param unknown_type $entityManager
     * @param unknown_type $query
     */
    public function __construct($entityManager = null, $query = null, $options = null)
    {
        if (null !== $entityManager)
            $this->setEntityManager($entityManager);
        if (null !== $query)
            $this->setQuery($query);

        // Init messages
        $this->messageTemplates[self::ENTITY_FOUND] = $this->translate('There is already an entity with this value.');

        return parent::__construct($options);
    }

    /**
     *
     * @param EntityManager $entityManager
     * @return \Application\Validator\Doctrine\NoEntityExists
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     * @return the $query
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param field_type $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\Validator\ValidatorInterface::isValid()
     * @throws Exception\RuntimeException() in case EntityManager or query is missing
     */
    public function isValid($value)
    {
        // Fetch entityManager
        $em = $this->getEntityManager();

        if (null === $em)
            throw new Exception\RuntimeException(__METHOD__ . ' There is no entityManager set.');

        // Fetch query
        $query = $this->getQuery();

        if (null === $query)
            throw new Exception\RuntimeException(__METHOD__ . ' There is no query set.');

        // Ignore empty values?
        if ((null === $value || '' === $value) && $this->getIgnoreEmpty())
            return true;

        $queryObj = $em->createQuery($query)->setMaxResults(1);

        $entitiesFound = !!count($queryObj->execute(array(':value' => $value)));

        // Set Error message
        if ($entitiesFound)
            $this->error(self::ENTITY_FOUND);

        // Valid if no records are found -> result count is 0
        return !$entitiesFound;
    }

}