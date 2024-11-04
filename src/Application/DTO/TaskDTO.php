<?php

namespace Application\DTO;

class TaskDTO
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private  $name;

    /**
     * @var \DateTime|null
     */
    private  $startTime;

    /**
     * @var \DateTime|null
     */
    private $endTime;

    /**
     * @var bool
     */
    private $isActive;

    public function __construct(int $id,string $name, bool $isActive = false, ?\DateTime $startTime = null, ?\DateTime $endTime = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->isActive = $isActive;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    public function getId(): int
    {
        return $this->id;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function getStartTime(): \DateTime
    {
        return $this->startTime;
    }

    public function getEndTime(): ?\DateTime
    {
        return $this->endTime;
    }

    public function getDurationTime()
    {
        $date = date('Y-m-d', $this->getStartTime()->getTimestamp());
        $startTime = $this->getStartTime()->getTimestamp();
        $endTime = $this->getEndTime() ? $this->getEndTime()->getTimestamp() : time();
        if (date('Y-m-d', $startTime) < date('Y-m-d', $endTime)) {
            $endTime = strtotime($date . ' 23:59:59');
        }
        return  $endTime - $startTime;
    }

}
