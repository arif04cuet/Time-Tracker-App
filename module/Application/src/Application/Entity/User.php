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
 * @ORM\Entity(repositoryClass="UserRepository")
 * @ORM\Table(name="users")
 */
class User
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
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(type="string",length=255,nullable=true)
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    protected $username;

    /**
     * @var string
     * @ORM\Column(type="string", length=128)
     */
    protected $password;

    /**
     * @var int
     * @ORM\Column(type="integer",name="access_type")
     */
    protected $accessType;

    /**
     * @var int
     * @ORM\Column(type="integer",name="user_type")
     */
    protected $userType;

    /**
     * @var string
     * @ORM\Column(type="datetime",nullable=true,name="created_date")
     */
    protected $createdDate;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $status;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="developers")
     */
    protected $clients;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="clients")
     * @ORM\JoinTable(name="clients_developers",
     *      joinColumns={@ORM\JoinColumn(name="client_id", referencedColumnName="id",onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="developer_id", referencedColumnName="id",onDelete="CASCADE")}
     *      )
     */
    protected $developers;

    /**
     * @ORM\OneToMany(targetEntity="Project", mappedBy="client")
     */
    protected $projects;

    /**
     * @ORM\OneToMany(targetEntity="Memu", mappedBy="developer")
     */
    protected $memus;

    /**
     * Initialies the roles variable.
     */
    public function __construct()
    {
	$this->clients = new \Doctrine\Common\Collections\ArrayCollection();
	$this->developers = new \Doctrine\Common\Collections\ArrayCollection();
	$this->projects = new \Doctrine\Common\Collections\ArrayCollection();
	$this->memus = new \Doctrine\Common\Collections\ArrayCollection();

	//default value here
	$this->status = 1;
	$this->createdDate = new \DateTime("now");
    }

    //add methods

    public function addDeveloper(User $developer)
    {
	if (!$this->getDevelopers()->contains($developer))
	{
	    $this->getDevelopers()->add($developer);
	}
    }

    public function addClient(User $client)
    {
	if (!$this->getClients()->contains($client))
	{
	    $this->getClients()->add($client);
	}
    }

    public function addProject(\Application\Entity\Project $project)
    {
	if (!$this->getProjects()->contains($project))
	{
	    $this->getProjects()->add($project);
	    $project->setClient($this);
	}
    }

    public function addMemu(\Application\Entity\Memu $memu)
    {
	if (!$this->getMemus()->contains($memu) and $this->getUserType() == 3)
	{
	    $this->getMemus()->add($memu);
	    $memu->setDeveloper($this);
	}
    }

    public function getId()
    {
	return $this->id;
    }

    public function setId($id)
    {
	$this->id = $id;
    }

    public function getName()
    {
	return $this->name;
    }

    public function setName($name)
    {
	$this->name = $name;
    }

    public function getEmail()
    {
	return $this->email;
    }

    public function setEmail($email)
    {
	$this->email = $email;
    }

    public function getUsername()
    {
	return $this->username;
    }

    public function setUsername($username)
    {
	$this->username = $username;
    }

    public function getPassword()
    {
	return $this->password;
    }

    public function setPassword($password)
    {

	$this->password = md5($password);
    }

    public function getAccessType()
    {
	return ($this->accessType == 1) ? 'web' : 'desktop';
    }

    public function setAccessType($accessType)
    {
	$this->accessType = $accessType;
    }

    public function getUserType()
    {
	return $this->userType;
    }

    public function setUserType($userType)
    {
	$this->userType = $userType;
    }

    public function getCreatedDate()
    {
	return $this->createdDate;
    }

    public function setCreatedDate($createdDate)
    {
	$this->createdDate = $createdDate;
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

    public function getClients()
    {
	return $this->clients;
    }

    public function setClients($clients)
    {
	$this->clients = $clients;
    }

    public function getDevelopers()
    {
	return $this->developers;
    }

    public function setDevelopers($developers)
    {
	$this->developers = $developers;
    }

    public function getProjects()
    {
	return $this->projects;
    }

    public function setProjects($projects)
    {
	$this->projects = $projects;
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

    /**
     * Populate from an array.
     *
     * @param array $data
     */
    public function populate($data = array())
    {
	$this->setId($data['id']);
	$this->setName($data['name']);
	$this->setGovtCode($data['code']);
    }

    public function exchangeArray($data)
    {
	$this->id = (isset($data['id'])) ? $data['id'] : null;
	$this->name = (isset($data['name'])) ? $data['name'] : null;
	$this->govtCode = (isset($data['code'])) ? $data['code'] : null;
    }

}
