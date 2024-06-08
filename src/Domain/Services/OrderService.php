<?php

namespace Domain\Services;


use Doctrine\ORM\EntityManagerInterface;
use Domain\Collections\PortfolioCollection;
use Domain\DTO\ClientDTO;
use Domain\DTO\PortfolioDTO;
use Domain\Entity\Allocation;
use Domain\Entity\Client;
use Domain\Entity\Order;
use Domain\Entity\Portfolio;
use Domain\Repository\ClientRepository;
use Domain\Repository\OrderRepository;
use Domain\Repository\PortfolioRepository;
use Symfony\Component\Uid\Uuid;

class OrderService
{

    /** @var OrderRepository */
    private $orderRepository;
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * OrderService constructor.
     * @param OrderRepository $orderRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(OrderRepository $orderRepository,EntityManagerInterface $entityManager)
    {
        $this->orderRepository = $orderRepository;
        $this->entityManager = $entityManager;
    }


    /**
     * get all Orders
     * @return \Domain\Collections\OrderCollection
     */
    public function getAllOrders()
    {
        return $this->orderRepository->getAllOrders();
    }
}