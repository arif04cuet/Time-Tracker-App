<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Form;

use Zend\Captcha;
use Zend\Form\Element;
use Zend\Form\Form;

class Project extends Form
{

    public function __construct($name = null)
    {
	parent::__construct('project');

	$this->setAttribute('method', 'post');

	$this->add(array(
	    'name' => 'id',
	    'type' => 'Zend\Form\Element\Hidden',
	    'attributes' => array(
		'class' => 'id',
		'id' => 'id',
	    ),
	));

	$this->add(array(
	    'name' => 'title',
	    'type' => 'Zend\Form\Element\Text',
	    'attributes' => array(
		'class' => 'title',
		'id' => 'title',
		'placeholder' => 'Enter Title',
		'required' => 'required',
	    ),
	    'options' => array(
		'label' => 'Title',
		'label_attributes' => array(
		    'class' => 'control-label',
		),
	    ),
	));

	$this->add(array(
	    'name' => 'client',
	    'type' => 'Zend\Form\Element\Select',
	    'attributes' => array(
		'class' => 'client ajax',
		'id' => 'client',
		'required' => 'required',
	    ),
	    'options' => array(
		'label' => 'Client',
		'label_attributes' => array(
		    'class' => 'control-label',
		),
		'value_options' => array(
		    '' => 'Select One',
		),
	    ),
	));

	$this->add(array(
	    'name' => 'status',
	    'type' => 'Zend\Form\Element\Select',
	    'attributes' => array(
		'class' => 'status',
		'id' => 'status',
		'required' => 'required',
	    ),
	    'options' => array(
		'label' => 'Status',
		'label_attributes' => array(
		    'class' => 'control-label',
		),
		'value_options' => array(
		    '1' => 'Enabled',
		    '0' => 'Disabled',
		),
	    ),
	));

	$this->add(array(
	    'name' => 'developers',
	    'type' => 'Zend\Form\Element\MultiCheckbox',
	    'attributes' => array(
		'class' => 'developers',
		'id' => 'developers',
		'value' => '0',
	    ),
	    'options' => array(
		'label' => 'Select Developer',
		'label_attributes' => array(
		    'class' => 'checkbox',
		),
		'value_options' => array(
		    '0' => 'Select',
		),
	    ),
	));

	$this->add(array(
	    'name' => 'submit',
	    'attributes' => array(
		'type' => 'submit',
		'value' => 'Save',
		'id' => 'submitbutton',
		'class' => 'btn btn-primary'
	    ),
	));
	$this->add(array(
	    'name' => 'cancel',
	    'attributes' => array(
		'type' => 'button',
		'value' => 'Cancel',
		'id' => 'cancel',
		'class' => 'btn btn-danger'
	    ),
	));
    }

}

?>
