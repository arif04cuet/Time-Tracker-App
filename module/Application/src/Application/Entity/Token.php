<?php

/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 * @link https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="token")
 */
class Token
{

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id",nullable=true)
     */
    protected $project;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="developer_id", referencedColumnName="id",nullable=true)
     */
    protected $developer;

    /**
     * @ORM\ManyToOne(targetEntity="Memu")
     * @ORM\JoinColumn(name="memo_id", referencedColumnName="id",nullable=true)
     */
    protected $memo;

    /**
     * @var string
     * @ORM\Column(type="string",length=255,nullable=true,unique=true)
     */
    protected $sessionToken;

    /**
     * @var string
     * @ORM\Column(type="datetime",name="start_time",nullable=true)
     */
    protected $startTime;

    /**
     * @var Int
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $duration;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $status;

    public function __construct()
    {
	$this->status = 1;
    }

    public function getId()
    {
	return $this->id;
    }

    public function setId($id)
    {
	$this->id = $id;
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

    public function getMemo()
    {
	return $this->memo;
    }

    public function setMemo($memo)
    {
	$this->memo = $memo;
    }

    public function getSessionToken()
    {
	return $this->sessionToken;
    }

    public function setSessionToken($sessionToken)
    {
	$this->sessionToken = $sessionToken;
    }

    public function getStartTime()
    {
	return $this->startTime;
    }

    public function setStartTime($startTime)
    {
	$this->startTime = $startTime;
    }

    public function getDuration()
    {
	return $this->duration;
    }

    public function setDuration($duration)
    {
	$this->duration = $duration;
    }

    public function getStatus()
    {
	return $this->status;
    }

    public function setStatus($status)
    {
	$this->status = $status;
    }

}
