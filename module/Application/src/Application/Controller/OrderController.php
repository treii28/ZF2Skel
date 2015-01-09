<?php

namespace Application\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Application\Entity\Order;
use Application\Mapper\OrderMapper;

class OrderController extends AbstractController
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


    protected function getOrder($orderId=null)
    {
        $order = ((is_null($orderId)) ?
            new Order()
            :
            $this->getMapper()->findRecordById($orderId)
        );

        return $order;
    }
}
