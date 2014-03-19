<?php

/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 *
 * @link https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="ProjectRepository")
 * @ORM\Table(name="projects")
 */
class Project
{

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @var string
     * @ORM\Column(type="datetime",name="starting_date",nullable=true)
     */
    protected $startingDate;

    /**
     * @var string
     * @ORM\Column(type="datetime",name="closing_date",nullable=true)
     */
    protected $closingDate;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $status;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="projects")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id",onDelete="CASCADE")
     */
    protected $client;

    /**
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="projects_developers",
     *      joinColumns={@ORM\JoinColumn(name="project_id", referencedColumnName="id",onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="developer_id", referencedColumnName="id",onDelete="CASCADE")}
     *      )
     */
    private $developers;

    /**
     * @ORM\OneToMany(targetEntity="Memu", mappedBy="project")
     */
    protected $memus;

    /**
     * Initialies the roles variable.
     */
    public function __construct()
    {
	$this->developers = new \Doctrine\Common\Collections\ArrayCollection();
	$this->memus = new \Doctrine\Common\Collections\ArrayCollection();
	$this->status = 1;
    }

    // add
    public function addDeveloper(\Application\Entity\User $developer)
    {
	if (!$this->getDevelopers()->contains($developer) and $developer->getUserType() == 3)
	    $this->getDevelopers()->add($developer);
    }

    public function getId()
    {
	return $this->id;
    }

    public function setId($id)
    {
	$this->id = $id;
    }

    public function getTitle()
    {
	return $this->title;
    }

    public function setTitle($title)
    {
	$this->title = $title;
    }

    public function getStartingDate()
    {
	$date = $this->startingDate;
	return $date->format('d-m-Y');
    }

    public function setStartingDate($startingDate)
    {
	$this->startingDate = $startingDate;
    }

    public function getClosingDate()
    {
	return $this->closingDate;
    }

    public function setClosingDate($closingDate)
    {
	$this->closingDate = $closingDate;
    }

    public function getStatus()
    {
	return ($this->status) ? '<span style="color:green">Enable</span>' : '<span style="color:red">Disabled</span>';
    }

    public function getDBStatus()
    {
	return $this->status;
    }

    public function setStatus($status)
    {
	$this->status = $status;
    }

    public function getClient()
    {
	return $this->client;
    }

    public function setClient($client)
    {
	$this->client = $client;
    }

    public function getDevelopers()
    {
	return $this->developers;
    }

    public function setDevelopers($developers)
    {
	$this->developers = $developers;
    }

    public function getMemus()
    {
	return $this->memus;
    }

    public function setMemus($memus)
    {
	$this->memus = $memus;
    }

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy()
    {
	return get_object_vars($this);
    }

}
