<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Form;

use Zend\Captcha;
use Zend\Form\Element;
use Zend\Form\Form;

class Login extends Form
{

    public function __construct($name = null)
    {
        parent::__construct('login');

        $this->setAttribute('method', 'post');

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
