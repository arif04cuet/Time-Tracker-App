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
 * @ORM\Table(name="time_slots")
 */
class TimeSlot
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
     * @ORM\Column(type="datetime",name="start_time")
     */
    protected $startTime;

    /**
     * @var string
     * @ORM\Column(type="datetime",name="end_time")
     */
    protected $endTime;

    /**
     * @var string
     * @ORM\Column(type="blob",name="image",nullable=true)
     */
    protected $image;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $status;

    /**
     * @ORM\ManyToOne(targetEntity="Memu", inversedBy="timeSlots")
     * @ORM\JoinColumn(name="memu_id", referencedColumnName="id",nullable=true)
     */
    protected $memu;

    /**
     * Initialies the roles variable.
     */
    public function __construct()
    {
	$this->status = 1;
    }

    public function getId()
    {
	return $this->id;
    }

    public function getCheckbox()
    {
	$id = $this->id;
	return '<input class="checkbox" type="checkbox" name="del[]" value="' . $id . '" />';
    }

    public function setId($id)
    {
	$this->id = $id;
    }

    public function getStartTime()
    {
	$date = $this->startTime;
	return $date->format("h:i:s");
    }

    public function setStartTime($startTime)
    {
	$this->startTime = $startTime;
    }

    public function getEndTime()
    {
	$date = $this->endTime;
	return $date->format("h:i:s");
    }

    public function setEndTime($endTime)
    {
	$this->endTime = $endTime;
    }

    public function getImage()
    {
	$imageBinary = stream_get_contents($this->image);
	$src = 'data:image/png;base64,' . $imageBinary;
	return '<img style="width:300px" src="' . $src . '" alt="Image" />';
    }

    public function setImage($image)
    {
	$this->image = $image;
    }

    public function getStatus()
    {
	return $this->status;
    }

    public function setStatus($status)
    {
	$this->status = $status;
    }

    public function getMemu()
    {
	return $this->memu;
    }

    public function getMemoName()
    {
	$memo = $this->getMemu();
	return $memo->getTitle();
    }

    public function setMemu($memu)
    {
	$this->memu = $memu;
    }

}
