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

$app_root = dirname(__DIR__);
$proj_root = realpath(preg_replace('/\/module\/Application\/?$/', '', $app_root));

$modcfg = array(
    'doctrine' => array(
        'driver' => array(
            'application_entities' => array(
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(realpath($app_root . '/src/Application/Entity'))
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
                        'controller' => 'IndexController',
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
                        'controller' => 'UserController',
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
                        'controller' => 'ListController',
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
                        'controller' => 'OrderController',
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
                        'controller' => 'OrderItemController',
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
                        'controller' => 'ProductController',
                        'action'     => 'index',
                    ),
                ),
            ),

            'migration' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/migration[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'MigrationController',
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
            'ListItemMapper'  => 'Application\Mapper\ListItemMapper',
            'MaterialMapper'  => 'Application\Mapper\MaterialMapper',
            'OrderItemMapper' => 'Application\Mapper\OrderItemMapper',
            'OrderMapper'     => 'Application\Mapper\OrderMapper',
            'ProductMapper'   => 'Application\Mapper\ProductMapper',
            'TypeMapper'      => 'Application\Mapper\TypeMapper',
            'UserMapper'      => 'Application\Mapper\UserMapper',

            'MigrationMapper' => 'Application\Mapper\MigrationMapper',
        )
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => $app_root . '/language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'IndexController'     => 'Application\Controller\IndexController',
            'UserController'      => 'Application\Controller\UserController',
            'ListController'      => 'Application\Controller\ListController',
            'ProductController'   => 'Application\Controller\ProductController',
            'OrderController'     => 'Application\Controller\OrderController',
            'OrderItemController' => 'Application\Controller\OrderItemController',
            'MigrationController' => 'Application\Controller\MigrationController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => $app_root . '/view/layout/layout.phtml',
            'application/index/index' => $app_root . '/view/application/index/index.phtml',
            'error/404'               => $app_root . '/view/error/404.phtml',
            'error/index'             => $app_root . '/view/error/index.phtml',
        ),
        'template_path_stack' => array(
            $app_root . '/view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
                'migration' => array(
                    'options' => array(
                        'route'    => 'migration [materials|collections|colorrefs|options]:mode [--verbose|-v]',
                        'defaults' => array(
                            'controller' => 'MigrationController',
                            'action'     => 'cli'
                        )
                    )
                )
            ),
        ),
    ),
);

return $modcfg;