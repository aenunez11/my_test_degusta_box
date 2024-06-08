<?php

namespace Domain\Repository;


use Doctrine\ORM\AbstractQuery;
use Domain\Collections\OrderCollection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Domain\DTO\OrderDTO;
use Domain\Entity\Order;

class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    /**
     * get all order in collection
     * @return OrderCollection
     */
    public function getAllOrders(): OrderCollection
    {
        $orders = $this->createQueryBuilder('o')
            ->select('o,p')
            ->join('o.portfolio', 'p')
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_ARRAY);

        $ordersDTO = array_map(function ($order){
            return new OrderDTO($order['portfolio']['name'],$order['type'],$order['allocationId'],$order['shares'],$order['createdAt'],$order['completedAt']);
        },$orders);

        return new OrderCollection($ordersDTO);
    }
}