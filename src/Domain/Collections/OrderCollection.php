<?php

namespace Domain\Collections;


use Domain\DTO\OrderDTO;

class OrderCollection
{

    /**
     * @var OrderDTO[]
     */
    private $orderDTOCollection;

    /**
     * OrderCollection constructor.
     * @param array $orderDTOCollection
     */
    public function __construct(array $orderDTOCollection)
    {
        $this->orderDTOCollection = $orderDTOCollection;
    }

    /**
     * @return OrderDTO[]
     */
    public function getOrderDTOCollection(): array
    {
        return $this->orderDTOCollection;
    }

    public function getTotalOrdersCompleted()
    {
        $count = 0;
        foreach ($this->orderDTOCollection as $orderDTO){
            if (!empty($orderDTO->getCompletedAt())){
                $count++;
            }
        }
        return $count;
    }

    public function getTotalOrdersPendingCompletion()
    {
        $count = 0;
        foreach ($this->orderDTOCollection as $orderDTO){
            if (empty($orderDTO->getCompletedAt())){
                $count++;
            }
        }
        return $count;
    }

    public function getTotalOrdersByBuyType()
    {
        $count = 0;
        foreach ($this->orderDTOCollection as $orderDTO){
            if ($orderDTO->getType() === 'buy'){
                $count++;
            }
        }
        return $count;
    }

    public function getTotalOrdersBySellType()
    {
        $count = 0;
        foreach ($this->orderDTOCollection as $orderDTO){
            if ($orderDTO->getType() === 'sell'){
                $count++;
            }
        }
        return $count;
    }

    public  function getTotalOrders()
    {
        return count($this->orderDTOCollection);
    }

}