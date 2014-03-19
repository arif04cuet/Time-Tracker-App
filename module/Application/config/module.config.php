<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
// new controllers and actions without needing to create a new
// module. Simply drop new controllers in, and you can access them
// using the path /application/:controller/:action
            'application' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(),
                        ),
                    ),
                ),
            ),
            'ajax' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/application/ajax[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Ajax',
                        'action' => 'index',
                    ),
                ),
            ),
            'developer' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/application/developer[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Developer',
                        'action' => 'index',
                    ),
                ),
            ),
            'client' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/application/client[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Client',
                        'action' => 'index',
                    ),
                ),
            ),
            'project' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/application/project[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Project',
                        'action' => 'index',
                    ),
                ),
            ),
            'work' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/application/work[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Work',
                        'action' => 'index',
                    ),
                ),
            ),
            'add-developer' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/add-developer',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Developer',
                        'action' => 'add',
                    ),
                ),
            ),
            'developer-list' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/developer-list',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Developer',
                        'action' => 'list',
                    ),
                ),
            ),
            'login' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/login',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'login',
                    ),
                ),
            ),
            'logout' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/logout',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'logout',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Base' => 'Application\Controller\BaseController',
            'Application\Controller\Soap' => 'Application\Controller\SoapController',
            'Application\Controller\Ajax' => 'Application\Controller\AjaxController',
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\Developer' => 'Application\Controller\DeveloperController',
            'Application\Controller\Client' => 'Application\Controller\ClientController',
            'Application\Controller\Project' => 'Application\Controller\ProjectController',
            'Application\Controller\Work' => 'Application\Controller\WorkController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'listHeader' => 'Application\View\Helper\ListHeader',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'annotation_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/../src/Application/Entity',
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Application\Entity' => 'annotation_driver',
                ),
            ),
        ),
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'Application\Entity\User',
                'identity_property' => 'username',
                'credential_property' => 'password',
                'credential_callable' => function(Application\Entity\User $user, $passwordGiven) {
                    if ($user->getAccessType() == 'web')
                        return md5($passwordGiven);
                },
            ),
        ),
    ),
);
