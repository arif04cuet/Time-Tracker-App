<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Form;

use Zend\Form\Form;

class Diary extends Form
{

    public function __construct($name = null)
    {
	parent::__construct('diary');

	$this->setAttribute('method', 'get');

	$this->add(array(
	    'name' => 'id',
	    'type' => 'Zend\Form\Element\Hidden',
	));




	$this->add(array(
	    'name' => 'client',
	    'type' => 'Zend\Form\Element\Select',
	    'attributes' => array(
		'class' => 'client ajax span2',
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
	    'name' => 'project',
	    'type' => 'Zend\Form\Element\Select',
	    'attributes' => array(
		'class' => 'project ajax span2',
		'id' => 'project',
		'required' => 'required',
	    ),
	    'options' => array(
		'label' => 'Project',
		'label_attributes' => array(
		    'class' => 'control-label',
		),
		'value_options' => array(
		    '' => 'Select One',
		),
	    ),
	));

	$this->add(array(
	    'name' => 'developer',
	    'type' => 'Zend\Form\Element\Select',
	    'attributes' => array(
		'class' => 'developer span2',
		'id' => 'developer',
		'required' => 'required',
	    ),
	    'options' => array(
		'label' => 'Developer',
		'label_attributes' => array(
		    'class' => 'control-label',
		),
		'value_options' => array(
		    '' => 'Select One',
		),
	    ),
	));

	$this->add(array(
	    'name' => 'from',
	    'type' => 'Zend\Form\Element\Text',
	    'attributes' => array(
		'class' => 'date from span2',
		'id' => 'from',
		'placeholder' => 'From Date',
	    ),
	    'options' => array(
		'label' => 'From',
		'label_attributes' => array(
		    'class' => 'control-label',
		),
	    ),
	));



	$this->add(array(
	    'name' => 'to',
	    'type' => 'Zend\Form\Element\Text',
	    'attributes' => array(
		'class' => 'date to span2',
		'id' => 'to',
		'placeholder' => 'To Date',
	    ),
	    'options' => array(
		'label' => 'To',
		'label_attributes' => array(
		    'class' => 'control-label',
		),
	    ),
	));

	$this->add(array(
	    'name' => 'submit',
	    'attributes' => array(
		'type' => 'submit',
		'value' => 'Show',
		'id' => 'submitbutton',
		'class' => 'btn btn-primary'
	    ),
	));
	$this->add(array(
	    'name' => 'delete',
	    'attributes' => array(
		'type' => 'submit',
		'value' => 'Delete',
		'id' => 'del',
		'class' => 'btn btn-danger'
	    ),
	));
    }

}

?>
