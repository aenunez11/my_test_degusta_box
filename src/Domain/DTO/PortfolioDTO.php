<?php

namespace Domain\DTO;


class PortfolioDTO
{

    /** @var string */
    private $uidentifier;
    /** @var string */
    private $name;
    /** @var array */
    private $allocations;

    /**
     * PortfolioDTO constructor.
     * @param string $uidentifier
     * @param $name
     * @param array $allocations
     */
    public function __construct(string $uidentifier,$name,$allocations = [])
    {
        $this->uidentifier = $uidentifier;
        $this->name = $name;
        $this->allocations = $allocations;
    }

    /**
     * @return string
     */
    public function getUidentifier(): string
    {
        return $this->uidentifier;
    }

    /**
     * @return array
     */
    public function getAllocations(): array
    {
        return $this->allocations;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


}