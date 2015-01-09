<?php

namespace Application\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Application\Entity\OrderItem;
use Application\Mapper\OrderItemMapper;

class OrderItemController extends AbstractController
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


    protected function getOrderItem($orderItemId=null)
    {
        $orderItem = ((is_null($orderItemId)) ?
            new OrderItem()
            :
            $this->getMapper()->findRecordById($orderItemId)
        );

        return $orderItem;
    }
}
