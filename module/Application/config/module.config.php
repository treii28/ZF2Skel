<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

// check for an environmental variable to use alternate doctrine driver (generate entities uses xml_config)
$doctrine_driver = ((isset($_SERVER['DOCTRINE_DRIVER'])) ? $_SERVER['DOCTRINE_DRIVER'] : 'application_entities');

return array(
    'doctrine' => array(
        'driver' => array(
            'application_entities' => array(
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Application/Entity')
            ),
            'xml_config' => array(
                'class' =>'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'cache' => 'array',
                'paths' => array(__DIR__.'/doctrine/xml/')
            ),
            'yml_config' => array(
                'class' =>'Doctrine\ORM\Mapping\Driver\YamlDriver',
                'cache' => 'array',
                'paths' => array(__DIR__.'/doctrine/yaml/')
            ),

            'orm_default' => array(
                'drivers' => array(
                    'Application\Entity' => $doctrine_driver
                    //'Application\Entity' => 'xml_config'
                    //'Application\Entity' => 'application_entities'
                )
            )
        )
    ),

    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),

            'user' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/user[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\User',
                        'action'     => 'index',
                    ),
                ),
            ),

            'list' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/list[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\List',
                        'action'     => 'index',
                    ),
                ),
            ),

            'order' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/order[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Order',
                        'action'     => 'index',
                    ),
                ),
            ),
            'orderitem' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/orderitem[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\OrderItem',
                        'action'     => 'index',
                    ),
                ),
            ),
            'product' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/product[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Product',
                        'action'     => 'index',
                    ),
                ),
            ),

            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
        'invokables' => array(
            'AddressMapper'   => 'Application\Mapper\AddressMapper',
            'ListMapper'      => 'Application\Mapper\ListMapper',
            'ListXrefMapper'  => 'Application\Mapper\ListXrefMapper',
            'OrderItemMapper' => 'Application\Mapper\OrderItemMapper',
            'OrderMapper'     => 'Application\Mapper\OrderMapper',
            'ProductMapper'   => 'Application\Mapper\ProductMapper',
            'TypeMapper'      => 'Application\Mapper\TypeMapper',
            'UserMapper'      => 'Application\Mapper\UserMapper',

            'MaterialCollectionMapper' => 'Application\Mapper\Lists\MaterialCollectionMapper',
            'PrinterCollectionMapper'  => 'Application\Mapper\Lists\PrinterCollectionMapper',
        )
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\User'  => 'Application\Controller\UserController',
            'Application\Controller\List'  => 'Application\Controller\ListController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
