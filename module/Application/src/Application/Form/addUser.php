<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Form;

use Zend\Captcha;
use Zend\Form\Element;
use Zend\Form\Form;

class addUser extends Form
{

    public function __construct($name = null)
    {
	parent::__construct('application');

	$this->setAttribute('method', 'post');

	$this->add(array(
	    'name' => 'id',
	    'type' => 'Zend\Form\Element\Hidden',
	    'attributes' => array(
		'class' => 'id',
		'id' => 'namide',
	    ),
	));

	$this->add(array(
	    'name' => 'name',
	    'type' => 'Zend\Form\Element\Text',
	    'attributes' => array(
		'class' => 'name',
		'id' => 'name',
		'placeholder' => 'Type a name',
		'required' => 'required',
	    ),
	    'options' => array(
		'label' => 'Name',
		'label_attributes' => array(
		    'class' => 'control-label',
		),
	    ),
	));

	$this->add(array(
	    'name' => 'email',
	    'type' => 'Zend\Form\Element\Email',
	    'attributes' => array(
		'class' => 'email',
		'id' => 'email',
		'placeholder' => 'Enter Email',
		'required' => 'required',
	    ),
	    'options' => array(
		'label' => 'Email',
		'label_attributes' => array(
		    'class' => 'control-label',
		),
	    ),
	));

	$this->add(array(
	    'name' => 'username',
	    'type' => 'Zend\Form\Element\Text',
	    'attributes' => array(
		'class' => 'username',
		'id' => 'username',
		'placeholder' => 'Type a unique username',
		'required' => 'required',
	    ),
	    'options' => array(
		'label' => 'Username',
		'label_attributes' => array(
		    'class' => 'control-label',
		),
	    ),
	));

	$this->add(array(
	    'name' => 'password',
	    'type' => 'Zend\Form\Element\Password',
	    'attributes' => array(
		'class' => 'password',
		'id' => 'password',
		'placeholder' => 'Password Here...',
		'required' => 'required',
	    ),
	    'options' => array(
		'label' => 'Password',
		'label_attributes' => array(
		    'class' => 'control-label',
		),
	    ),
	));

	$this->add(array(
	    'name' => 'password_verify',
	    'type' => 'Zend\Form\Element\Password',
	    'attributes' => array(
		'class' => 'password',
		'id' => 'password',
		'placeholder' => 'Verify Password Here...',
		'required' => 'required',
	    ),
	    'options' => array(
		'label' => 'Verify Password',
		'label_attributes' => array(
		    'class' => 'control-label',
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
		    '0' => 'Checkbox',
		    '1' => 'Checkbox',
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
	    'name' => 'id',
	    'type' => 'Zend\Form\Element\Hidden',
	    'attributes' => array(
		'class' => 'id',
		'id' => 'id',
	    ),
	    'options' => array(
	    ),
	));

	$this->add(array(
	    'name' => 'csrf',
	    'type' => 'Zend\Form\Element\Csrf',
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
