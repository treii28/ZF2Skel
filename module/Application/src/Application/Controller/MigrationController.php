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
        return new ViewModel(array('migact' => "migcol"));
    }

    public function migmatAction() {

        $response = $this->getResponse();
        $response->setStatusCode(200);
        $response->setContent($this->getMapper()->migrateJoomlaColors(2));

        $headers = $response->getHeaders();
        $headers->addHeaderLine('Content-Type', 'text/text');

        return $response;
    }

    public function migcolAction() {

        $response = $this->getResponse();
        $response->setStatusCode(200);
        $response->setContent($this->getMapper()->migrateJoomlaMaterials(2));

        $headers = $response->getHeaders();
        $headers->addHeaderLine('Content-Type', 'text/text');

        return $response;
    }
}
