<?php

namespace App\Controller;


use Domain\Services\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{

    /** @var OrderService */
    private $orderService;

    /**
     * OrderController constructor.
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAllOrders()
    {
        $orderCollection = $this->orderService->getAllOrders();
        return $this->render('orders/index.html.twig',[
            'orderCollection' => $orderCollection
        ]);
    }
}