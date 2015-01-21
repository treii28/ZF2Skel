<?php

namespace Application\Controller;

use Zend\Mvc\Application;
use Zend\View\Model\ViewModel;

class MigrationController extends AbstractController
{

    public function indexAction()
    {
        $myActions = $this->getActionNames(array('indexAction'));
        return new ViewModel(array('actions' => $myActions));
    }

    public function materialsAction() {
        return new ViewModel(array('migact' => "migmat"));
    }
    public function collectionsAction() {
        return new ViewModel(array('migact' => "migcoll"));
    }
    public function colorrefsAction() {
        return new ViewModel(array('migact' => "migcolref"));
    }

    public function cliAction() {
        $mapper = $this->getMapper();
        $mapper->setsetOutputType('echo');

        $request = $this->getRequest();

        // Check verbose flag
        $verbose = $request->getParam('verbose') || $request->getParam('v');

        // Check mode
        $mode = $request->getParam('mode'); // defaults to 'all'

        $users = array();
        switch ($mode) {
            case 'materials':
                $output = $mapper->migrateJoomlaColors(2);
                break;
            case 'collections':
                $users = $mapper->migrateJoomlaMaterials(2);
                break;
            case 'colorrefs':
                $users = $mapper->migrateColorRefs(2);
                break;
        }
    }

    public function migmatAction() {

        $mapper = $this->getMapper();
        $mapper->setOutputType('buffer');

        $response = $this->getResponse();
        $response->setStatusCode(200);
        $response->setContent($mapper->migrateJoomlaColors(2));

        $headers = $response->getHeaders();
        $headers->addHeaderLine('Content-Type', 'text/text');

        return $response;
    }

    public function migcollAction() {
        $mapper = $this->getMapper();
        $mapper->setOutputType('buffer');

        $response = $this->getResponse();
        $response->setStatusCode(200);
        $response->setContent($mapper->migrateJoomlaMaterials(2));

        $headers = $response->getHeaders();
        $headers->addHeaderLine('Content-Type', 'text/text');

        return $response;
    }

    public function migcolrefAction() {
        $mapper = $this->getMapper();
        $mapper->setOutputType('buffer');

        $response = $this->getResponse();
        $response->setStatusCode(200);
        $response->setContent($mapper->migrateColorRefs(2));

        $headers = $response->getHeaders();
        $headers->addHeaderLine('Content-Type', 'text/text');

        return $response;
    }
}
