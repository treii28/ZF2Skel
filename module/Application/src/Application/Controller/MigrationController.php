<?php

namespace Application\Controller;

use Zend\Mvc\Application;
use Zend\View\Model\ViewModel;

class MigrationController extends AbstractController
{

    public function indexAction()
    {
        $myActions = $this->getActionNames(array('indexAction'));
        return new ViewModel(array('actions' => $myActions, 'usage' => $this->usageMessage()));
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
        $mapper->setOutputType('echo');

        $request = $this->getRequest();

        // Check verbose flag
        $verbose = $request->getParam('verbose') || $request->getParam('v');
        $verbosity = ($verbose) ? 3 : 1;

        // Check mode
        $mode = $request->getParam('mode'); // defaults to 'all'

        $users = array();
        switch ($mode) {
            case 'materials':
                $output = $mapper->migrateJoomlaColors($verbosity);
                break;
            case 'collections':
                $output = $mapper->migrateJoomlaMaterials($verbosity);
                break;
            case 'colorrefs':
                $output = $mapper->migrateColorRefs($verbosity);
                break;
            default:
                echo $this->usageMessage();
                break;

        }
    }

    private function usageMessage() {
        return <<<EOT

  Usage:
         php public/index.php [--verbose|-v]
               migration [materials|collections|colorrefs]:mode


EOT;
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
