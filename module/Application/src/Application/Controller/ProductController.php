<?php

namespace Application\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Application\Entity\Product;
use Application\Mapper\ProductMapper;

class ProductController extends AbstractController
{
    public function indexAction()
    {
    }

    public function addAction()
    {
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }


    protected function getProduct($productId=null)
    {
        $product = ((is_null($productId)) ?
            new Product()
            :
            $this->getMapper()->findRecordById($productId)
        );

        return $product;
    }
}
