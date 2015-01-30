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
        $this->getMigrationMapper()->setOutputType('echo');

        $request = $this->getRequest();

        // Check verbose flag
        $verbose = $request->getParam('verbose') || $request->getParam('v');
        $verbosity = ($verbose) ? 3 : 1;

        // Check mode
        $mode = $request->getParam('mode'); // defaults to 'all'

        $users = array();
        switch ($mode) {
            case 'materials':
                $output = $this->getMigrationMapper()->migrateJoomlaColors($verbosity);
                break;
            case 'collections':
                $output = $this->getMigrationMapper()->migrateJoomlaMaterials($verbosity);
                break;
            case 'colorrefs':
                $output = $this->getMigrationMapper()->migrateColorRefs($verbosity);
                break;
            case 'options':
                $output = $this->getMigrationMapper()->migrateMaterialOptions($verbosity);
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
               migration [materials|collections|colorrefs|options]:mode


EOT;
    }

    public function migmatAction()
    {
        $this->getMigrationMapper()->setOutputType('buffer');

        $response = $this->getResponse();
        $response->setStatusCode(200);
        $response->setContent($this->getMigrationMapper()->migrateJoomlaColors(2));

        $headers = $response->getHeaders();
        $headers->addHeaderLine('Content-Type', 'text/text');

        return $response;
    }

    public function migcollAction()
    {
        $this->getMigrationMapper()->setOutputType('buffer');

        $response = $this->getResponse();
        $response->setStatusCode(200);
        $response->setContent($this->getMigrationMapper()->migrateJoomlaMaterials(2));

        $headers = $response->getHeaders();
        $headers->addHeaderLine('Content-Type', 'text/text');

        return $response;
    }

    public function migcolrefAction()
    {
        $this->getMigrationMapper()->setOutputType('buffer');

        $response = $this->getResponse();
        $response->setStatusCode(200);
        $response->setContent($this->getMigrationMapper()->migrateColorRefs(2));

        $headers = $response->getHeaders();
        $headers->addHeaderLine('Content-Type', 'text/text');

        return $response;
    }

    /**
     * override just to get the proper phpStorm auto-complete association
     * 
     * @return \Application\Mapper\MigrationMapper
     */
    public function getMigrationMapper() {
        return parent::getMapper();
    }
}
