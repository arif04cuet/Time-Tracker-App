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
 * @ORM\Entity
 * @ORM\Table(name="memus")
 */
class Memu
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
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $status;

    /**
     * @ORM\OneToMany(targetEntity="TimeSlot", mappedBy="memu")
     */
    protected $timeSlots;

    /**
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="memus")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id",nullable=true)
     */
    protected $project;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="memus")
     * @ORM\JoinColumn(name="developer_id", referencedColumnName="id",nullable=true)
     */
    protected $developer;

    /**
     * Initialies the roles variable.
     */
    public function __construct()
    {
	$this->timeSlots = new \Doctrine\Common\Collections\ArrayCollection();
	$this->status = 0;
    }

    public function addTimeSlot(\Application\Entity\TimeSlot $slot)
    {

	if (!$this->getTimeSlots()->contains($slot))
	{
	    $this->getTimeSlots()->add($slot);
	    $slot->setMemu($this);
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

    public function getTitle()
    {
	return $this->title;
    }

    public function setTitle($title)
    {
	$this->title = $title;
    }

    public function getStatus()
    {
	return $this->status;
    }

    public function setStatus($status)
    {
	$this->status = $status;
    }

    public function getTimeSlots()
    {
	return $this->timeSlots;
    }

    public function setTimeSlots($timeSlots)
    {
	$this->timeSlots = $timeSlots;
    }

    public function getProject()
    {
	return $this->project;
    }

    public function setProject($project)
    {
	$this->project = $project;
    }

    public function getDeveloper()
    {
	return $this->developer;
    }

    public function setDeveloper($developer)
    {
	$this->developer = $developer;
    }

}
